<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
          <h2>
    Danh sách công việc 
    <?php if (!empty($currentGroupId)): ?>
        - Nhóm: <?= htmlspecialchars($currentGroupId) ?>
    <?php elseif (!empty($currentStatus)): ?>
        - Trạng thái: <?= htmlspecialchars($currentStatus) ?>
    <?php elseif ($currentAction === 'listByUser'): ?>
        - Công việc của tôi
    <?php endif; ?>
</h2>


        </div> 

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-deep-orange">
                       
                        <?php if (in_array($_SESSION['user']['role'], ['admin', 'manager'])): ?>
                        <ul class="header-dropdown m-r--5 menu_cv">
                            <li>
                                <a href="index.php?controller=task&action=add" class="btn bg-cyan btn-sm">
                                    <i class="material-icons">add</i> Thêm công việc
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </div>

                    <div class="body table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

                        <!-- <table class="table table-bordered table-striped table-hover js-basic-example dataTable"> -->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã công việc</th>
                                    <th>Ngày tạo</th>
                                    <th>Dự án / Nhóm</th>
                                    <th>Hạng mục</th>
                                    <th>Liên phòng</th>

                                    <th>Chi tiết</th>
                                    <th>Kết quả</th>
                                    <th>Yêu cầu</th>
                                    <th>Ưu tiên</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Người giao</th>
                                    <th>Phụ trách</th>
                                    <th>Liên quan</th>
                                    <th>Xem báo cáo</th>
                                    <th>Phê duyệt</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian phê duyệt</th>
                                    <th>Thời gian trình duyệt</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tasks)): ?>
                                    <?php foreach ($tasks as $index => $task): ?>
                                        <?php $stt = isset($currentPage, $tasksPerPage) ? ($currentPage - 1) * $tasksPerPage + $index + 1 : $index + 1; ?>
                                        <tr>
                                            <td><?= $stt ?></td>
                                            <td><?= htmlspecialchars($task['task_code']) ?></td>
                                            <td><?= htmlspecialchars($task['created_at']) ?></td>
                                            <td><?= htmlspecialchars($task['project_group_name'] ?? 'Không rõ') ?></td>
                                            <td><?= htmlspecialchars($task['category_name'] ?? 'Không rõ') ?></td>
                                            <td>
                                                <?php if (!empty($task['department_task_code'])): ?>
                                                    <span class="badge bg-info">
                                                        <?= htmlspecialchars($task['department_task_code']) ?> - <?= htmlspecialchars($task['department_task_title']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <em>Không</em>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= htmlspecialchars($task['detail']) ?></td>
                                            <td>
                                                <!-- ✅ Kết quả chính thức -->
                                                <?php if (!empty($task['results'])): ?>
                                                    <!-- <div><strong>Kết quả chính thức:</strong></div> -->
                                                    <?php foreach ($task['results'] as $res): ?>
                                                        <div>
                                                            <strong>-</strong> <?= htmlspecialchars($res['description']) ?>
                                                            <?php if (!empty($res['result_link'])): ?>
                                                               
                                                                👉 <a href="<?= htmlspecialchars($report['result_link']) ?>" target="_blank">Link kết quả</a>

                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div><em>Không có kết quả chính thức</em></div>
                                                <?php endif; ?>

                                                <!-- ✅ Báo cáo của người dùng -->
                                                <!-- <?php if (!empty($task['reports_by_user'])): ?>
                                                    <div class="mt-2"><strong>Báo cáo từ người dùng:</strong></div>
                                                    <?php foreach ($task['reports_by_user'] as $userId => $reports): ?>
                                                        <?php foreach ($reports as $report): ?>
                                                            <div class="pl-2">
                                                                <strong>-</strong> <?= htmlspecialchars($report['title']) ?> 
                                                                (<?= htmlspecialchars($report['full_name'] ?? 'Người dùng #'.$userId) ?>)
                                                                <?php if (!empty($report['result_link'])): ?>
                                                                    (<a href="<?= htmlspecialchars($report['result_link']) ?>" target="_blank">Link</a>)
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?> -->
                                            </td>

                                            <td><?= htmlspecialchars($task['requirements']) ?></td>
                                            <td><span class="badge bg-green"><?= htmlspecialchars($task['priority']) ?></span></td>
                                            <td><?= htmlspecialchars($task['start_date']) ?></td>
                                            <td><?= htmlspecialchars($task['due_date']) ?></td>
                                            <td><?= htmlspecialchars($task['creator_full_name'] ?? 'N/A') ?></td>
                                           
                                            <td>
                                                <?php if (!empty($task['supervisor_names'])): ?>
                                                    <?= htmlspecialchars(implode(', ', $task['supervisor_names'])) ?>
                                                <?php else: ?>
                                                    <em>Không có</em>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= htmlspecialchars($task['responsible_usernames'] ?? '') ?></td>
                                            
                                           <td>

                                             <?php if (!empty($task['id']) && $task['task_status'] !== 'Đang thực hiện'): ?>

                                                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                                    <?php if (!empty($task['reports_by_user'])): ?>
                                                        <button type="button"
                                                                class="btn btn-xs bg-cyan"
                                                                data-toggle="modal"
                                                                data-target="#reportModal_<?= $task['id'] ?>">
                                                            👁 Xem báo cáo
                                                        </button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php
                                                        $currentUserId = $_SESSION['user']['id'];
                                                        $hasReport = !empty($task['reports_by_user'][$currentUserId]);
                                                    ?>
                                                    <?php if ($hasReport): ?>
                                                        <button type="button"
                                                                class="btn btn-xs bg-cyan"
                                                                data-toggle="modal"
                                                                data-target="#reportModal_<?= $task['id'] ?>_<?= $currentUserId ?>">
                                                            👁 Báo cáo của tôi
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                 <?php endif; ?>
                                            </td> 
                                            <!-- test -->

                                            <!-- end test -->
                                            <?php
                                            $approval = $task['approval_status'];
                                            $approvalClass = match ($approval) {
                                                'Đã duyệt' => 'bg-green',
                                                'Hủy' => 'bg-red',
                                                'Hoãn việc' => 'bg-orange',
                                                default => 'bg-blue',
                                            };
                                            ?>
                                            <td><span class="label <?= $approvalClass ?>"><?= htmlspecialchars($approval) ?></span></td>
                                            <?php
                                            $status = $task['task_status'];
                                            $statusClass = match ($status) {
                                                'Chưa bắt đầu'     => 'bg-grey',
                                                'Đang thực hiện'   => 'bg-blue',
                                                'Chờ duyệt'        => 'bg-orange',
                                                'Đã hoàn thành'    => 'bg-green',
                                                'Đã hủy'           => 'bg-red',
                                                default            => 'bg-light-blue',
                                            };
                                            ?>
                                            <td><span class="label <?= $statusClass ?>"><?= htmlspecialchars($status) ?></span></td>
                                            <td><?= !empty($task['approval_time']) ? date('H:i:s , d/m/Y', strtotime($task['approval_time'])) : '-' ?></td>
                                            
                            

                                                                                    <?php
                                            $currentUserId = $_SESSION['user']['id'];
                                            $submittedTime = '-';

                                            if (!empty($task['reports_by_user'][$currentUserId])) {
                                                $userReports = $task['reports_by_user'][$currentUserId];
                                                $lastReport = end($userReports); // Lấy báo cáo cuối cùng
                                                if (!empty($lastReport['created_at'])) {
                                                    $submittedTime = date('H:i:s , d/m/Y', strtotime($lastReport['created_at']));
                                                }
                                            }
                                            ?>
                                            <td><?= $submittedTime ?></td>




                                            <td>
                                               
                                                <!-- Báo cáo -->
                                              
                                                <?php if (!empty($task['id']) && $task['task_status'] !== 'Đã hoàn thành'): ?>
                                                    <a href="index.php?controller=task&action=report&id=<?= (int)$task['id'] ?>" class="btn btn-sm bg-deep-orange" title="Gửi báo cáo">
                                                        <i class="material-icons">assignment</i>
                                                    </a>
                                                <?php endif; ?>

                                                <!-- end báo cáo -->

                                                <?php if (in_array($_SESSION['user']['role'], ['admin', 'manager']) && $status !== 'Đã hoàn thành'): ?>

                                                     <?php if (!in_array($approval, ['Đã duyệt', 'Hủy'])): ?>
                                                    <a href="index.php?controller=task&action=edit&id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                    <a href="index.php?controller=task&action=delete&id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa công việc này?')">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="19" class="text-center">Không có công việc nào.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                        <?php if (!empty($totalPages) && $totalPages > 1): ?>
                            <div class="align-center mt-3">
                                <ul class="pagination pagination-sm">
                                   <?php
                                        // Giữ lại các tham số GET hiện có, trừ `page`
                                        $queryParams = $_GET;
                                        unset($queryParams['page']);
                                    ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <?php
                                            $queryParams['page'] = $i;
                                            $queryStr = http_build_query($queryParams);
                                        ?>
                                        <li class="<?= $i == $currentPage ? 'active' : '' ?>">
                                            <a href="?<?= $queryStr ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Báo cáo -->
<?php
if (!function_exists('makeClickableLinks')) {
    function makeClickableLinks($text) {
        return preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
            htmlspecialchars($text)
        );
    }
}

// Gom tất cả report thành 1 mảng phẳng để render modal sửa riêng biệt
$allReports = [];
foreach ($tasks as $task) {
    if (!empty($task['reports_by_user'])) {
        foreach ($task['reports_by_user'] as $userReports) {
            foreach ($userReports as $report) {
                $allReports[] = $report;
            }
        }
    }
}
?>

<!-- BÁO CÁO -->
<?php foreach ($tasks as $task): ?>
    <?php if ($_SESSION['user']['role'] === 'admin' && !empty($task['reports_by_user'])): ?>
        <div class="modal fade" id="reportModal_<?= $task['id'] ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue-grey">
                        <h4 class="modal-title text-white">Báo cáo công việc: <?= htmlspecialchars($task['task_code']) ?></h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($task['reports_by_user'] as $userId => $reports): ?>
                            <div class="mb-4 border-bottom pb-2">
                                <h5 class="text-primary">👤 <?= htmlspecialchars($reports[0]['full_name'] ?? 'Người dùng #' . $userId) ?></h5>
                                <?php foreach ($reports as $report): ?>
                                    <div class="mb-2">
                                        <strong><i>Tiêu đề:</i></strong> <?= htmlspecialchars($report['title']) ?>
                                        - <em><?= htmlspecialchars($report['status']) ?></em>
                                        <?php if (!empty($report['result_link'])): ?>
                                            👉 <a href="<?= htmlspecialchars($report['result_link']) ?>" target="_blank">Link kết quả</a>
                                        <?php endif; ?>
                                        <br>
                                        <div class="mt-1"><?= nl2br(makeClickableLinks($report['content'])) ?></div>
                                        <small class="text-muted"><strong><i>Thời gian: </i></strong> <?= htmlspecialchars($report['created_at']) ?></small><br><br>
                                        <?php if ($_SESSION['user']['id'] == $report['user_id']): ?>
                                            <button class="btn btn-xs bg-amber mt-1"
                                                    onclick="$('#reportModal_<?= $task['id'] ?>').modal('hide'); $('#editReportModal_<?= $report['id'] ?>').modal('show');">
                                                ✏️ Sửa
                                            </button>
                                            <a href="index.php?controller=task&action=deleteReport&id=<?= $report['id'] ?>"
                                               class="btn btn-xs btn-danger mt-1"
                                               onclick="return confirm('Bạn có chắc muốn xoá báo cáo này không?')">
                                                🗑 Xoá
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-orange" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<!-- Modal xem báo cáo cho user -->
<?php foreach ($tasks as $task): ?>
    <?php
        $userId = $_SESSION['user']['id'];
        $reports = $task['reports_by_user'][$userId] ?? [];
    ?>
    <?php if ($_SESSION['user']['role'] !== 'admin' && !empty($reports)): ?>
        <div class="modal fade" id="reportModal_<?= $task['id'] ?>_<?= $userId ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue-grey">
                        <h4 class="modal-title text-white">Báo cáo của bạn</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($reports as $report): ?>
                            <div class="mb-2">
                                <strong><?= htmlspecialchars($report['title']) ?></strong>
                                - <em><?= htmlspecialchars($report['status']) ?></em>
                                <?php if (!empty($report['result_link'])): ?>
                                    👉 <a href="<?= htmlspecialchars($report['result_link']) ?>" target="_blank">Link kết quả</a>
                                <?php endif; ?>
                                <br>
                                <div class="mt-1"><?= nl2br(makeClickableLinks($report['content'])) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($report['created_at']) ?></small><br>
                                <?php if ($_SESSION['user']['id'] == $report['user_id']): ?>
                                    <button class="btn btn-xs bg-amber mt-1"
                                            onclick="$('#reportModal_<?= $task['id'] ?>_<?= $report['user_id'] ?>').modal('hide'); $('#editReportModal_<?= $report['id'] ?>').modal('show');">
                                        ✏️ Sửa
                                    </button>
                                    <a href="index.php?controller=task&action=deleteReport&id=<?= $report['id'] ?>"
                                       class="btn btn-xs btn-danger mt-1"
                                       onclick="return confirm('Bạn có chắc muốn xoá báo cáo này không?')">
                                        🗑 Xoá
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-orange" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<!-- Modal sửa báo cáo riêng tách khỏi modal xem -->
<?php foreach ($allReports as $report): ?>
    <?php if ($_SESSION['user']['id'] == $report['user_id']): ?>
        <div class="modal fade" id="editReportModal_<?= $report['id'] ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="index.php?controller=task&action=updateReport" method="POST">
                    <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                    <div class="modal-content">
                        <div class="modal-header bg-amber">
                            <h4 class="modal-title text-white">Sửa báo cáo</h4>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Trạng thái báo cáo</label>
                                <div class="form-line">
                                    <select class="form-control" name="status" required>
                                        <?php foreach (["Đang thực hiện", "Trình duyệt", "Tái trình duyệt"] as $opt): ?>
                                            <option value="<?= $opt ?>" <?= $report['status'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="content" rows="5" required><?= htmlspecialchars($report['content']) ?></textarea>
                                    <label class="form-label">Nội dung và/hoặc Link báo cáo</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-orange">Cập nhật</button>
                            <button type="button" class="btn bg-grey" data-dismiss="modal">Hủy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<style>
    ul.header-dropdown.m-r--5.menu_cv{
        top: 2px;
        right: auto !important;
        left: 0px !important;
    }
</style>
<?php include 'views/layouts/footer.php'; ?>