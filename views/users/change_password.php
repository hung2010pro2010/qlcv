<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Đổi mật khẩu</h2>
        </div>

        <div class="card">
            <div class="body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label>Mật khẩu hiện tại:</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu mới:</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nhập lại mật khẩu mới:</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                    <a href="index.php?controller=task&action=list" class="btn btn-default">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
