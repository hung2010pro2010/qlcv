<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Thêm danh mục công việc liên phòng</h2>
        </div>

        <!-- Form thêm danh mục -->
        <div class="card">
            <div class="body">
                <form method="post">
                    <div class="form-group">
                        <label for="name">Tên danh mục:</label>
                        <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                        <?php if (!empty($errors['name'])): ?>
                            <small class="text-danger"><?= $errors['name'] ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-primary flex-fill mr-2">Lưu</button>
                        <a href="index.php?controller=department_task_category&action=list" class="btn btn-default flex-fill">Quay lại danh sách</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
