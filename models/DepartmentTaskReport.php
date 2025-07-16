<?php
class DepartmentTaskReport {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO department_task_reports (task_id, user_id, content, created_at)
                                      VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['task_id'], $data['user_id'], $data['content'], $data['created_at']]);
    }

    public function getByTaskId($taskId) {
        $stmt = $this->conn->prepare("SELECT r.*, u.full_name FROM department_task_reports r
                                      JOIN users u ON r.user_id = u.id
                                      WHERE task_id = ? ORDER BY created_at DESC");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
