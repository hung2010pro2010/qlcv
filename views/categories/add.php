<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?= isset($category) ? 'Sửa' : 'Thêm' ?> Hạng mục công việc</h2>
        </div>

        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="body">
                        <form method="post">
                            <div class="form-group">
                                <label>Tên hạng mục</label>
                                <input type="text" name="name" class="form-control" value="<?= $category['name'] ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Thuộc dự án nhóm</label>
                                <select name="project_group_id" class="form-control" required>
                                    <option value="">-- Chọn dự án nhóm --</option>
                                    <?php foreach ($projectGroups as $group): ?>
                                        <option value="<?= $group['id'] ?>" <?= (isset($category['project_group_id']) && $category['project_group_id'] == $group['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($group['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="index.php?controller=category&action=list" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
