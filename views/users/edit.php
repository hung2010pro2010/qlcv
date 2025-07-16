<?php 
if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['id'] != $id) {
    echo "Bạn không có quyền chỉnh sửa người dùng này.";
    exit;
}
?>
<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Cập nhật người dùng</h2>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="header bg-cyan">
                        <h2 class="text-white">Thông tin người dùng</h2>
                    </div>
                    <div class="body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="form-group">
                                <label>Tên đăng nhập</label>
                                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($formData['username']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Mật khẩu (để trống nếu không đổi)</label>
                                <div style="position: relative;">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <span onclick="togglePassword()" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;">👁️</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($formData['full_name']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($formData['email']) ?>">
                            </div>

                            <div class="form-group">
                                <label>Phòng ban</label>
                                <select name="department_id" class="form-control" required>
                                    <option value="">-- Chọn phòng ban --</option>
                                    <?php foreach ($departments as $dep): ?>
                                        <option value="<?= $dep['id'] ?>" <?= $formData['department_id'] == $dep['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dep['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Chức vụ</label>
                                <input type="text" class="form-control" name="position" value="<?= htmlspecialchars($formData['position']) ?>">
                            </div>

                            <div class="form-group">
                                <label>Vai trò</label>
                                <select name="role" class="form-control">
                                    <option value="admin" <?= $formData['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="manager" <?= $formData['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                                    <option value="nhanvien" <?= $formData['role'] == 'nhanvien' ? 'selected' : '' ?>>Nhân viên</option>
                                </select>
                            </div>

                            <div class="form-group d-flex">
                                <button type="submit" class="btn btn-primary flex-fill mr-2">Cập nhật</button>
                                <a href="index.php?controller=user&action=list" class="btn btn-default flex-fill">Quay lại danh sách</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";
    event.currentTarget.textContent = isPassword ? '🙈' : '👁️';
}
</script>

<?php include 'views/layouts/footer.php'; ?>
