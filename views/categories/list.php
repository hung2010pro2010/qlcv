<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Danh sách Hạng mục công việc</h2>
        </div>

        <a href="index.php?controller=category&action=add" class="btn btn-primary mb-3">+ Thêm Hạng mục</a>

        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên hạng mục</th>
                                    <th>Dự án nhóm</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><?= $cat['id'] ?></td>
                                    <td><?= htmlspecialchars($cat['name']) ?></td>
                                    <td><?= htmlspecialchars($cat['project_group_name']) ?></td>
                                    <td>
                                        <a href="index.php?controller=category&action=edit&id=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="index.php?controller=category&action=delete&id=<?= $cat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
