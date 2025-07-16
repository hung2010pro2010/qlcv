<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Danh sách công việc liên phòng</h2>
        </div>

        <div class="card">
            <div class="body">
                <a href="index.php?controller=department_task&action=add" class="btn btn-success mb-3">
                    <i class="material-icons">add</i> Giao công việc mới
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-sm">
                        <thead class="thead-light bg-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Mã</th>
                                <th>Tên công việc</th>
                               
                                <th>Người cùng phụ trách</th>   <!-- mới -->
                                <th>Công việc nhỏ</th>          <!-- hiển thị tên -->
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tasks)): ?>
                                <?php $i = 1; foreach ($tasks as $task): ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><strong><?= htmlspecialchars($task['code']) ?></strong></td>
                                        <td><?= htmlspecialchars($task['title']) ?></td>
                                        
                                        <td><?= htmlspecialchars($task['all_responsibles'] ?: '---') ?></td>
                                        <td>
                                            <?= htmlspecialchars($task['subtask_names'] ?: '---') ?>
                                        </td>
                                        <td class="text-center">
                                            <?= !empty($task['start_time']) ? date('d/m/Y', strtotime($task['start_time'])) : '' ?><br>
                                            <?= !empty($task['end_time'])   ? date('d/m/Y', strtotime($task['end_time']))   : '' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php [$label, $class] = departmentTaskStatus($task['status'], 'badge'); ?>
                                            <span class="<?= $class ?>"><?= $label ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="index.php?controller=department_task&action=view&id=<?= $task['id'] ?>" class="btn btn-sm btn-primary" title="Xem"><i class="material-icons">visibility</i></a>
                                            <a href="index.php?controller=department_task&action=edit&id=<?= $task['id'] ?>" class="btn btn-sm btn-warning" title="Sửa"><i class="material-icons">edit</i></a>
                                            <a href="index.php?controller=department_task&action=delete&id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" title="Xoá" onclick="return confirm('Bạn có chắc chắn muốn xoá công việc này?');"><i class="material-icons">delete</i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="9" class="text-center">Chưa có công việc nào được giao.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
