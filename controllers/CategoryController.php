<?php
require_once 'models/Category.php';
require_once 'models/ProjectGroup.php'; // để lấy danh sách dự án nhóm



class CategoryController {
    private $db;

    public function __construct($db) {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }

    public function list() {
        require_once 'helpers/shared.php'; // Gọi ở đầu hàm hoặc đầu file
        $model = new Category($this->db);
        $categories = $model->getAll();
        // Lấy danh sách projectGroups cho sidebar
        $projectGroups = getProjectGroups($this->db);
        include 'views/categories/list.php';
    }

    public function add() {
        $projectGroupModel = new ProjectGroup($this->db);
        $projectGroups = $projectGroupModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'project_group_id' => $_POST['project_group_id'] ?? '',
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];
            $model = new Category($this->db);
            $model->create($data);
            header('Location: index.php?controller=category&action=list');
            exit;
        } else {
            include 'views/categories/add.php';
        }
    }

    public function edit() {
          require_once 'helpers/shared.php';
        $model = new Category($this->db);
        $projectGroupModel = new ProjectGroup($this->db);
        $projectGroups = $projectGroupModel->getAll();

        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'project_group_id' => $_POST['project_group_id'] ?? '',
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];
            $model->update($id, $data);
            header('Location: index.php?controller=category&action=list');
            exit;
        } else {
            $category = $model->getById($id);
            $projectGroups = getProjectGroups($this->db);
             
            include 'views/categories/edit.php';
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $model = new Category($this->db);
        $model->delete($id);
        header('Location: index.php?controller=category&action=list');
    }
    
    public function createAjax() {
        // Trả về JSON
        header('Content-Type: application/json');

        $projectGroupId = $_POST['project_group_id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($projectGroupId && $name) {
            $categoryModel = new Category($this->db);
            $categoryModel->create([
                'project_group_id' => $projectGroupId,
                'name' => $name,
                'description' => $description
            ]);

            // Lấy ID vừa tạo
            $lastId = $this->db->lastInsertId();

            echo json_encode([
                'success' => true,
                'id' => $lastId,
                'name' => $name
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu dữ liệu'
            ]);
        }
        exit;
    }

}
