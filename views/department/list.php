<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Danh sách phòng ban</h2>
        </div>

        <div class="card">
            <div class="body table-responsive">
                <a href="index.php?controller=department&action=add" class="btn btn-success mb-3">➕ Thêm phòng ban</a>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên phòng ban</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($departments as $index => $department): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($department['name']) ?></td>
                                <td><?= htmlspecialchars($department['description']) ?></td>
                                <td>
                                    <a href="index.php?controller=department&action=edit&id=<?= $department['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="index.php?controller=department&action=delete&id=<?= $department['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($departments)): ?>
                            <tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
