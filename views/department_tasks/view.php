<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Chi tiết công việc liên phòng</h2>
        </div>

        <div class="card mb-3">
            <div class="body">
                <?php if (!empty($task)): ?>
                    <h4><i class="material-icons">assignment</i> <?= htmlspecialchars($task['title']) ?></h4>

                    <?php
                       $statusLabel = [
                            'pending'     => ['Chờ duyệt', 'bg-grey'],
                            'in_progress' => ['Đang thực hiện', 'bg-blue'],
                            'approved'    => ['Đã duyệt', 'bg-green'],
                            'rejected'    => ['Từ chối', 'bg-red'],
                            'completed'   => ['Hoàn thành', 'bg-teal'],
                            'cancelled'   => ['Đã hủy', 'bg-black']
                        ];

                        $status = $statusLabel[$task['status']] ?? ['Không rõ', 'bg-black'];
                    ?>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>Mã công việc</th>
                                    <td><?= htmlspecialchars($task['code']) ?></td>
                                    <th>Trạng thái</th>
                                    <td><span class="label <?= $status[1] ?>"><?= $status[0] ?></span></td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td><?= htmlspecialchars($task['category_name'] ?? '---') ?></td>
                                    <th>Thời gian</th>
                                    <td><?= date('d/m/Y', strtotime($task['start_time'])) ?> - <?= date('d/m/Y', strtotime($task['end_time'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Phụ trách chính</th>
                                    <td><?= htmlspecialchars($task['main_responsible_name'] ?? '---') ?></td>
                                    <th>Người cùng phụ trách</th>
                                    <td><?= !empty($responsibles) ? implode('; ', array_map(fn($r) => htmlspecialchars($r['full_name']), $responsibles)) : '---' ?></td>
                                </tr>
                             <!--    <tr>
                                    <th>Người liên quan</th>
                                    <td colspan="3"><?= !empty($relatedUsers) ? implode('; ', array_map(fn($r) => htmlspecialchars($r['full_name']), $relatedUsers)) : '---' ?></td>
                                </tr> -->
                                <tr>
                                    <th>Mô tả</th>
                                    <td colspan="3"><?= nl2br(htmlspecialchars($task['description'])) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">Không tìm thấy công việc.</div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($subtasks)): ?>
            <div class="card">
                <div class="body">
                    <h5 class="mb-3">Các công việc nhỏ</h5>
                    <?php $userId = $_SESSION['user']['id'] ?? null; ?>

                    <?php foreach ($subtasks as $s): ?>
                        <?php
                            $isAssignee = $userId && $s['assignee_id'] == $userId;
                            $comments = $this->taskModel->getCommentsBySubtask($s['id']);
                            $reports = $subtaskReports[$s['id']] ?? [];
                        ?>
                        <div class="card border mb-3">
                            <div class="body">
                                <div class="row">
                                    <!-- Thông tin bên trái -->
                                    <div class="col-md-6">
                                        <h6><i class="material-icons">work</i> <?= htmlspecialchars($s['title']) ?></h6>
                                        <p><strong>Giao cho:</strong> <?= htmlspecialchars($s['assignee_name'] ?? '---') ?></p>
                                        <p><strong>Người liên quan:</strong>
                                            <?= !empty($followersBySubtask[$s['id']]) ? implode(', ', array_map('htmlspecialchars', $followersBySubtask[$s['id']])) : '---' ?>
                                        </p>

                                        <?php foreach ($reports as $r): ?>
                                            <div class="border rounded bg-light p-2 mt-2">
                                                <p><strong>Báo cáo:</strong><br><?= nl2br(htmlspecialchars($r['content'])) ?></p>
                                                <?php if (!empty($r['attachment'])): ?>
                                                    <p><strong>File:</strong> <a href="<?= htmlspecialchars($r['attachment']) ?>" target="_blank">Tải xuống</a></p>
                                                <?php endif; ?>

                                                <?php
    if ($task['status'] === 'cancelled') {
        $currentStatus = ['Đã hủy', 'bg-black'];
    } else {
        $statusText = [
            'approved' => ['Đã duyệt', 'bg-green'],
            'rejected' => ['Từ chối', 'bg-red'],
            'pending'  => ['Chờ duyệt', 'bg-grey']
        ];
        $currentStatus = $statusText[$r['status']] ?? ['Không rõ', 'bg-black'];
    }
?>
<p><strong>Trạng thái:</strong> <span class="label <?= $currentStatus[1] ?>"><?= $currentStatus[0] ?></span></p>

                                                <small class="text-muted">Gửi bởi <?= htmlspecialchars($r['full_name']) ?> lúc <?= date('H:i d/m/Y', strtotime($r['created_at'])) ?></small>

                                                <?php
                                                    $canApprove = ($_SESSION['user']['role'] === 'admin' || $userId == ($task['main_responsible_id'] ?? null));
                                                    $isReporter = $userId == $r['user_id'];
                                                ?>
                                                <div class="mt-2">
                                                    <?php if ($canApprove): ?>
                                                        <a href="index.php?controller=department_task&action=approve_report&id=<?= $r['id'] ?>" class="btn btn-sm btn-success">Duyệt</a>
                                                        <a href="index.php?controller=department_task&action=reject_report&id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Từ chối</a>
                                                    <?php endif; ?>
                                                    

                                                    <?php if ($isReporter): ?>
                                                        <a href="index.php?controller=department_task&action=edit_report&id=<?= $r['id'] ?>" class="btn btn-sm btn-info">Sửa</a>
                                                        <a href="index.php?controller=department_task&action=delete_report&id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá báo cáo này?')">Xoá</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <?php if ($isAssignee): ?>
                                            <form method="post" action="index.php?controller=department_task&action=submit_subtask_report" enctype="multipart/form-data" class="mt-3">
                                                <input type="hidden" name="subtask_id" value="<?= $s['id'] ?>">
                                                <div class="form-group">
                                                    <textarea name="report_content" class="form-control" rows="2" placeholder="Nhập báo cáo..." required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png,.zip">
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success">Gửi báo cáo</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Bình luận bên phải -->
                                    <div class="col-md-6">
                                        <h6><i class="material-icons">comment</i> Bình luận</h6>
                                        <div class="comment-list mb-2">
                                            <?php foreach ($comments as $c): ?>
                                                <div class="border-bottom py-1">
                                                    <strong><?= htmlspecialchars($c['full_name']) ?>:</strong>
                                                    <?= nl2br(htmlspecialchars($c['content'])) ?><br>
                                                    <small class="text-muted"><?= date('H:i d/m/Y', strtotime($c['created_at'])) ?></small>
                                                    <?php
                                                        $canEditComment = ($_SESSION['user']['role'] === 'admin' || $userId == $c['user_id']);
                                                    ?>
                                                    <?php if ($canEditComment): ?>
                                                        <div class="mt-1">
                                                            <a href="index.php?controller=department_task&action=edit_comment&id=<?= $c['id'] ?>&task_id=<?= $task['id'] ?>" class="btn btn-xs btn-info">Sửa</a>
                                                            <a href="index.php?controller=department_task&action=delete_comment&id=<?= $c['id'] ?>&task_id=<?= $task['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Xoá bình luận này?')">Xoá</a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <form action="index.php?controller=department_task&action=add_comment" method="post" class="mt-2">
                                            <input type="hidden" name="subtask_id" value="<?= $s['id'] ?>">
                                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                            <div class="form-group">
                                                <textarea name="comment_content" rows="2" class="form-control" placeholder="Viết bình luận..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">Gửi bình luận</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Chưa có công việc nhỏ nào.</div>
        <?php endif; ?>

        <div class="text-right mt-4">
            <a href="index.php?controller=department_task&action=edit&id=<?= $task['id'] ?>" class="btn btn-warning">
                <i class="material-icons">edit</i> Sửa
            </a>
            <a href="index.php?controller=department_task&action=list" class="btn btn-default">
                <i class="material-icons">arrow_back</i> Quay lại
            </a>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
