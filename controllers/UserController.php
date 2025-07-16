<?php
require_once 'models/User.php';
require_once 'models/ProjectGroup.php';
require_once 'models/Notification.php';
require_once 'models/Department.php';

 
class UserController {
    private $db;
    private $userModel;
    

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $db = (new DB())->connect();
        $this->db = $db;
        $this->userModel = new User($db);
    }

    private function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
    }

    public function login() {
        if (isset($_SESSION['user'])) {
            header("Location: index.php?controller=task&action=list");
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
            } else {
                $user = $this->userModel->authenticate($username, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    header("Location: index.php?controller=task&action=list");
                    exit;
                } else {
                    $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
                }
            }
        }

        include 'views/users/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=user&action=login");
        exit;
    }

    public function list() {
        require_once 'helpers/shared.php';
        $this->requireLogin();
        $users = $this->userModel->getAll();
        $projectGroups = getProjectGroups($this->db);
        include 'views/users/list.php';
    }

    public function add() {
        require_once 'helpers/shared.php';
        $this->requireLogin();

        $projectGroups = getProjectGroups($this->db);
        $departmentModel = new Department($this->db);
        $departments = $departmentModel->getAll(); // cho dropdown

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username   = trim($_POST['username'] ?? '');
            $password   = $_POST['password'] ?? '';
            $fullName   = trim($_POST['full_name'] ?? '');
            $email      = trim($_POST['email'] ?? '');
            $departmentId = $_POST['department_id'] ?? null;
            $position   = trim($_POST['position'] ?? '');
            $role       = trim($_POST['role'] ?? '');

            if (empty($username) || empty($password) || empty($fullName)) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
                include 'views/users/add.php';
                return;
            }
            $existing = $this->userModel->getByUsername($username);
                if ($existing) {
                    $error = 'Tên đăng nhập đã tồn tại.';
                    include 'views/users/add.php';
                    return;
                }

            $this->userModel->create([
                'username'   => $username,
                'password'   => $password,
                'full_name'  => $fullName,
                'email'      => $email,
                'department_id' => $departmentId,
                'position'   => $position,
                'role'       => $role
            ]);

            // Gửi thông báo
            $notificationModel = new Notification($this->db);
            $notificationModel->create([
                'user_id' => $_SESSION['user']['id'],
                'icon'    => 'person_add',
                'color'   => 'bg-light-green',
                'message' => 'Đã thêm người dùng mới: "' . htmlspecialchars($fullName) . '"'
            ]);

            header("Location: index.php?controller=user&action=list");
            exit;
        }

        include 'views/users/add.php';
    }


public function edit() {
    $this->requireLogin();

    // Lấy ID từ URL
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "Thiếu ID người dùng.";
        return;
    }

    // Lấy thông tin người dùng cần sửa
    $user = $this->userModel->getById($id);
    if (!$user) {
        echo "Người dùng không tồn tại.";
        return;
    }

    // Kiểm tra quyền chỉnh sửa
    if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['id'] != $id) {
        echo "Bạn không có quyền chỉnh sửa người dùng này.";
        return;
    }
    $departmentModel = new Department($this->db);
    $departments = $departmentModel->getAll();

    // Gán dữ liệu gốc để hiển thị form ban đầu
    $formData = $user;
    $error = null;

    // Nếu submit form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username   = trim($_POST['username'] ?? '');
        $password   = $_POST['password'] ?? '';
        $fullName   = trim($_POST['full_name'] ?? '');
        $email      = trim($_POST['email'] ?? '');
       $departmentId  = $_POST['department_id'] ?? null;
        $position   = trim($_POST['position'] ?? '');
        $role       = trim($_POST['role'] ?? '');

        // Kiểm tra dữ liệu bắt buộc
        if (empty($username) || empty($fullName) || empty($role)) {
            $error = "Vui lòng nhập đầy đủ các trường bắt buộc.";
            // Giữ lại dữ liệu form đã nhập để hiển thị lại
            $formData = [
                'id'         => $id,
                'username'   => $username,
                'full_name'  => $fullName,
                'email'      => $email,
                'department_id' => $departmentId,
                'position'   => $position,
                'role'       => $role
            ];
        } else {
            // Dữ liệu hợp lệ => tiến hành cập nhật
            $dataToUpdate = $formData;
            $dataToUpdate['username'] = $username;
            $dataToUpdate['full_name'] = $fullName;
            $dataToUpdate['email'] = $email;
            $dataToUpdate['department_id'] = $departmentId;
            $dataToUpdate['position'] = $position;
            $dataToUpdate['role'] = $role;

           if (!empty($password)) {
                $dataToUpdate['password'] = $password;
            } else {
                unset($dataToUpdate['password']);
            }
            $this->userModel->update($dataToUpdate);

            // Gửi thông báo nếu cần
            $notificationModel = new Notification($this->db);
            $notificationModel->create([
                'user_id' => $_SESSION['user']['id'],
                'icon'    => 'mode_edit',
                'color'   => 'bg-orange',
                'message' => 'Đã cập nhật người dùng: "' . htmlspecialchars($fullName) . '"'
            ]);

            header("Location: index.php?controller=user&action=list");
            exit;
        }
    }

    // Gửi dữ liệu sang view
    include 'views/users/edit.php';
}


    public function delete() {
        $this->requireLogin();

        $id = $_GET['id'] ?? null;
        if ($id) {
            $user = $this->userModel->getById($id);
            if ($user) {
                $this->userModel->delete($id);

                // Gửi thông báo xóa
                $notificationModel = new Notification($this->db);
                $notificationModel->create([
                    'user_id' => $_SESSION['user']['id'],
                    'icon'    => 'delete_forever',
                    'color'   => 'bg-red',
                    'message' => 'Đã xóa người dùng: "' . htmlspecialchars($user['full_name']) . '"'
                ]);
            }
        }
        if ($user['username'] === 'admin') {
            die('Không thể xóa tài khoản admin chính.');
        }

        header("Location: index.php?controller=user&action=list");
        exit;
    }
    
    
public function changePassword() {
    $this->requireLogin();
    $userId = $_SESSION['user']['id'];
    $user = $this->userModel->getById($userId);

    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!password_verify($currentPassword, $user['password'])) {
            $error = 'Mật khẩu hiện tại không đúng.';
        } elseif (empty($newPassword)) {
            $error = 'Vui lòng nhập mật khẩu mới.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'Mật khẩu mới không trùng khớp.';
        } else {
            // Cập nhật mật khẩu
            $this->userModel->update([
                'id'       => $userId,
                'username' => $user['username'], // cần thiết cho model
                'full_name' => $user['full_name'],
                'email'    => $user['email'],
                'department' => $user['department'],
                'position' => $user['position'],
                'role'     => $user['role'],
                'password' => $newPassword
            ]);

            $success = 'Mật khẩu đã được cập nhật thành công.';
        }
    }

    include 'views/users/change_password.php';
}
}
