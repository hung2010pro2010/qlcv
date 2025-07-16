<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?= isset($group) ? 'Sửa' : 'Thêm' ?> Dự án nhóm</h2>
        </div>

        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="body">
                        <form method="post">
                            <div class="form-group">
                                <label>Tên dự án nhóm</label>
                                <input type="text" name="name" class="form-control" value="<?= $group['name'] ?? '' ?>" required>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="index.php?controller=project_groups&action=list" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
