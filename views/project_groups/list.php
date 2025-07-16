<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Danh sách Dự án nhóm</h2>
        </div>

        <!-- <a href="index.php?controller=projectGroup&action=add" class="btn btn-primary mb-3">+ Thêm Dự án nhóm</a> -->
        <a href="index.php?controller=project_groups&action=add" class="btn btn-primary">Thêm mới</a>


        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên dự án nhóm</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projectGroups as $group): ?>
                                <tr>
                                    <td><?= $group['id'] ?></td>
                                    <td><?= htmlspecialchars($group['name']) ?></td>
                                    <td>
                                        <a href="index.php?controller=project_groups&action=edit&id=<?= $group['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="index.php?controller=project_groups&action=delete&id=<?= $group['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
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
