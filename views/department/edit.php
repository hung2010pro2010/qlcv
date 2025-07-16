<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Chỉnh sửa phòng ban</h2>
        </div>

        <div class="card">
            <div class="body">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="name">Tên phòng ban:</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-primary flex-fill mr-2">Cập nhật</button>
                        <a href="index.php?controller=department&action=list" class="btn btn-default flex-fill">Quay lại danh sách</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
