<?php
require_once 'models/ProjectGroup.php';
require_once 'models/Notification.php';
require_once 'models/Task.php';
//Controllers/TaskController.php


class ProjectGroupController {
    private $db;

    public function __construct($db) {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }

    public function list() {
        $model = new ProjectGroup($this->db);
         $taskModel = new Task($this->db); 
        $projectGroups = $model->getAll();
        foreach ($projectGroups as &$group) {
            // $group['tasks'] = $taskModel->getTasksByGroupId($group['id']);
            $group['tasks'] = $taskModel->getByGroupId($group['id']);

        }
        include 'views/project_groups/list.php';
    }
    public function getTasksByGroupId($groupId) {
    $stmt = $this->db->prepare("
        SELECT * FROM tasks
        WHERE project_group_id = ?
    ");
    $stmt->execute([$groupId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];
            $model = new ProjectGroup($this->db);
            $model->create($data);
            header('Location: index.php?controller=project_groups&action=list');
            exit;
        } else {
            include 'views/project_groups/add.php';
        }
    }

public function edit() {
    $model = new ProjectGroup($this->db);
    $id = $_GET['id'] ?? 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? ''
        ];
        $model->update($id, $data);
        header('Location: index.php?controller=project_groups&action=list');
        exit;
    } else {
        $group = $model->getById($id); // 🟢 dòng quan trọng để hiển thị dữ liệu cũ
        include 'views/project_groups/edit.php';
    }
}


    public function delete() {
        $id = $_GET['id'] ?? 0;
        $model = new ProjectGroup($this->db);
        $model->delete($id);
        header('Location: index.php?controller=project_groups&action=list');
    }
}
