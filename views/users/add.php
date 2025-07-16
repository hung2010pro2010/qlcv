<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Thêm người dùng mới</h2>
        </div>

        <!-- Form Thêm người dùng -->
        <div class="card">
            <div class="body">
                <form method="post">
                    <div class="row">
                        <!-- Cột Tên đăng nhập -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                        </div>

                        <!-- Cột Mật khẩu -->
                        <div class="col-sm-6">
                            <div class="form-group position-relative">
                                <label for="password">Mật khẩu:</label>
                                <div style="position: relative;">
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <span onclick="togglePassword()" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;">
                                        👁️
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Cột Họ tên -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="full_name">Họ tên:</label>
                                <input type="text" id="full_name" name="full_name" class="form-control">
                            </div>
                        </div>

                        <!-- Cột Email -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Cột Bộ phận -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="department_id">Phòng ban:</label>
                                <select id="department_id" name="department_id" class="form-control" required>
                                    <option value="">-- Chọn phòng ban --</option>
                                    <?php foreach ($departments as $dep): ?>
                                        <option value="<?= $dep['id'] ?>"><?= htmlspecialchars($dep['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>

                        <!-- Cột Chức vụ -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="position">Chức vụ:</label>
                                <input type="text" id="position" name="position" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Cột Vai trò -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="role">Vai trò:</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="nhanvien">Nhân viên</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-primary flex-fill mr-2">Lưu</button>
                        <a href="index.php?controller=user&action=list" class="btn btn-default flex-fill">Quay lại danh sách</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Script toggle mật khẩu -->
<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = event.currentTarget;
    if (input.type === "password") {
        input.type = "text";
        icon.textContent = "🙈";
    } else {
        input.type = "password";
        icon.textContent = "👁️";
    }
}
</script>

<?php include 'views/layouts/footer.php'; ?>
