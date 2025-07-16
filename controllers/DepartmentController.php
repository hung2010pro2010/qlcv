<?php
require_once 'models/Department.php';

class DepartmentController {
    private $db;
    private $departmentModel;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->departmentModel = new Department($db);
    }

    public function list()
    {
        require_once 'helpers/shared.php';
        $departments = $this->departmentModel->getAll();

        // Khai báo biến dùng cho sidebar
        $projectGroups = getProjectGroups($this->db);
        $currentController = 'department';
        $currentAction = 'list';

        include 'views/department/list.php';
    }

    public function add()
    {
        $errors = [];
        $old = [
            'name' => '',
            'description' => ''
        ];
        require_once 'helpers/shared.php';
         // Khai báo biến dùng cho sidebar
        $projectGroups = getProjectGroups($this->db);
        $currentController = 'department';
        $currentAction = 'add';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $old['name'] = $name;
            $old['description'] = $description;

            if ($name === '') {
                $errors['name'] = 'Tên phòng ban không được để trống.';
            }

            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description
                ];

                $this->departmentModel->insert($data);
                $_SESSION['success'] = 'Đã thêm phòng ban thành công.';
                header('Location: index.php?controller=department&action=list');
                exit;
            }
        }

        include 'views/department/add.php';
    }

    public function edit()
    {   
         require_once 'helpers/shared.php';
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if (!$id) {
            header('Location: index.php?controller=department&action=list');
            exit;
        }


        // Khai báo biến dùng cho sidebar
        $projectGroups = getProjectGroups($this->db);
        $currentController = 'department';
        $currentAction = 'edit';

        $department = $this->departmentModel->getById($id);
        if (!$department) {
            $_SESSION['error'] = 'Không tìm thấy phòng ban.';
            header('Location: index.php?controller=department&action=list');
            exit;
        }

        $errors = [];
        $old = $department;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $old['name'] = $name;
            $old['description'] = $description;

            if ($name === '') {
                $errors['name'] = 'Tên phòng ban không được để trống.';
            }

            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description
                ];

                $this->departmentModel->update($id, $data);
                $_SESSION['success'] = 'Đã cập nhật phòng ban.';
                header('Location: index.php?controller=department&action=list');
                exit;
            }
        }

        include 'views/department/edit.php';
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id) {
            $this->departmentModel->delete($id);
            $_SESSION['success'] = 'Đã xóa phòng ban.';
        } else {
            $_SESSION['error'] = 'ID không hợp lệ.';
        }

        header('Location: index.php?controller=department&action=list');
        exit;
    }
}
