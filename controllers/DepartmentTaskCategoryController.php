<?php
require_once 'models/DepartmentTaskCategory.php';
require_once 'helpers/shared.php'; 
 
class DepartmentTaskCategoryController {

    private $db;
    private $model;


    public function __construct($db) {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

         $this->model = new DepartmentTaskCategory($db);

        $this->db = $db;
    }


   

    public function list() {
        // Khai báo biến dùng cho sidebar
        $projectGroups = getProjectGroups($this->db);
        $categories = $this->model->getAll();
        include 'views/department_task_categories/list.php';
    }

    public function add() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {
                $error = 'Tên danh mục không được để trống.';
            } else {
                $this->model->insert(['name' => $name, 'description' => $description]);
                header("Location: index.php?controller=department_task_category&action=list");
                exit;
            }
        }
        // Khai báo biến dùng cho sidebar
        $projectGroups = getProjectGroups($this->db);
        include 'views/department_task_categories/add.php';
    }

    public function edit() {
    $id = $_GET['id'] ?? 0;
    $category = $this->model->getById($id);

    if (!$category) {
        die('Không tìm thấy danh mục.');
    }

    $formData = $category;
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {
            $errors['name'] = 'Tên danh mục không được để trống.';
        }

        if (empty($errors)) {
            $this->model->update($id, $name, $description);
            header('Location: index.php?controller=department_task_category&action=list');
            exit;
        } else {
            // Gán lại dữ liệu đã nhập để hiển thị lại
            $formData = [
                'name' => $name,
                'description' => $description
            ];
        }
    }

    include 'views/department_task_categories/edit.php';
}


    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php?controller=department_task_category&action=list");
        exit;
    }
}
