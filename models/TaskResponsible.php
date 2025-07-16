<?php
class TaskResponsible {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

   
    public function create($taskId, $userId) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM task_responsible WHERE task_id = :task_id AND user_id = :user_id");
    $stmt->execute([':task_id' => $taskId, ':user_id' => $userId]);
    if ($stmt->fetchColumn() > 0) {
        return false; // Đã tồn tại
    }

    $stmt = $this->db->prepare("INSERT INTO task_responsible (task_id, user_id) VALUES (:task_id, :user_id)");
    $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    return $stmt->execute();
}


    // Xoá tất cả người phụ trách của một task
    public function deleteByTaskId($taskId) {
        $stmt = $this->db->prepare("DELETE FROM task_responsible WHERE task_id = :task_id");
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Lấy danh sách ID người phụ trách của một task (mảng số nguyên)
    public function getUserIdsByTaskId($taskId) {
        $stmt = $this->db->prepare("SELECT user_id FROM task_responsible WHERE task_id = :task_id");
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'user_id');
    }

    // (Tuỳ chọn) Lấy thông tin chi tiết người phụ trách (join bảng user)
    public function getResponsibleUsersByTaskId($taskId) {
        $stmt = $this->db->prepare("
            SELECT u.* 
            FROM task_responsible tr
            JOIN users u ON tr.user_id = u.id
            WHERE tr.task_id = :task_id
        ");
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy danh sách tên người phụ trách (full_name) theo task ID
    public function getUsernamesByTaskId($taskId) {
        $stmt = $this->db->prepare("
            SELECT u.full_name 
            FROM task_responsible tr 
            JOIN users u ON tr.user_id = u.id 
            WHERE tr.task_id = :task_id
        ");
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Mảng ['Nguyễn A', 'Trần B', ...]
    }
    public function getTaskIdsByUserId($userId) {
    $stmt = $this->db->prepare("SELECT task_id FROM task_responsible WHERE user_id = ?");
    $stmt->execute([$userId]);
    return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'task_id');
}


}
