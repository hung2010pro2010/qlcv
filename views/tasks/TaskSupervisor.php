<?php
class TaskSupervisor {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Tạo bản ghi người phụ trách công việc
     */
    public function create($taskId, $userId, $role = 'phụ') {
        $stmt = $this->db->prepare("INSERT INTO task_supervisors (task_id, user_id, role, assigned_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$taskId, $userId, $role]);
    }

    /**
     * Lấy danh sách người phụ trách của một công việc
     */
    public function getByTaskId($taskId) {
        $stmt = $this->db->prepare("
            SELECT ts.*, u.full_name, u.position 
            FROM task_supervisors ts
            JOIN users u ON ts.user_id = u.id
            WHERE ts.task_id = ?
        ");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Xóa toàn bộ người phụ trách theo task_id (dùng khi cập nhật lại)
     */
    public function deleteByTaskId($taskId) {
        $stmt = $this->db->prepare("DELETE FROM task_supervisors WHERE task_id = ?");
        return $stmt->execute([$taskId]);
    }
}
