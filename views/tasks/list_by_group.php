<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>
<?php require_once 'helpers/shared.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                Danh sách công việc theo nhóm dự án
                <?php if (!empty($_GET['group_id'])): ?>
                    - Nhóm ID: <?= htmlspecialchars($_GET['group_id']) ?>
                <?php endif; ?>
            </h2>
        </div> 

        <!-- Bộ lọc (nếu cần thì có thể thêm vào đây) -->

        <!-- Danh sách công việc -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-deep-orange">
                        <!-- <h2 class="text-white">Công việc trong nhóm dự án</h2> -->
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
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
                       <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
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
                                            
                                           <td> <?= !empty($report['submitted_at']) ? date('H:i:s , d/m/Y', strtotime($report['submitted_at'])) : '-' ?></td>

                                            <td>
                                               
                                                <!-- Báo cáo -->
                                              
                                                <?php if (!empty($task['id']) && $task['task_status'] !== 'Đã hoàn thành'): ?>
                                                    <a href="index.php?controller=task&action=report&id=<?= (int)$task['id'] ?>" class="btn btn-sm bg-deep-orange" title="Gửi báo cáo">
                                                        <i class="material-icons">assignment</i>
                                                    </a>
                                                <?php endif; ?>

                                                <!-- end báo cáo -->

                                                <?php if ($_SESSION['user']['role'] === 'admin' && $status !== 'Đã hoàn thành'): ?>
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
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
