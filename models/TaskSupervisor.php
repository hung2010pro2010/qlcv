<?php
class TaskSupervisor {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ✅ Tạo người phụ trách (chính/phụ)
    public function create($taskId, $userId, $role = 'phụ') {
        $stmt = $this->db->prepare("INSERT INTO task_supervisors (task_id, user_id, role, assigned_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$taskId, $userId, $role]);
    }

    // ✅ Lấy chi tiết người phụ trách theo task
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

    // ✅ Xoá toàn bộ phụ trách theo task
    public function deleteByTaskId($taskId) {
        $stmt = $this->db->prepare("DELETE FROM task_supervisors WHERE task_id = ?");
        return $stmt->execute([$taskId]);
    }

    // ✅ Lấy danh sách user_id đã gán cho task (để hiển thị checkbox đã tick)
    public function getUserIdsByTaskId($taskId) {
        $stmt = $this->db->prepare("SELECT user_id FROM task_supervisors WHERE task_id = ?");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getMainSupervisorId($taskId) {
    $stmt = $this->db->prepare("SELECT user_id FROM task_supervisors WHERE task_id = ? AND role = 'chính' LIMIT 1");
    $stmt->execute([$taskId]);
    return $stmt->fetchColumn();
}
public function getMainSupervisorNameByTaskId($taskId) {
    $stmt = $this->db->prepare("
        SELECT u.full_name
        FROM task_supervisors ts
        JOIN users u ON ts.user_id = u.id
        WHERE ts.task_id = ? AND ts.role = 'chịu trách nhiệm'
        LIMIT 1
    ");
    $stmt->execute([$taskId]);
    return $stmt->fetchColumn(); // trả về 1 chuỗi tên
}
public function getTaskIdsByUserId($userId) {
    $stmt = $this->db->prepare("SELECT task_id FROM task_supervisors WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function getTaskIdsByUserIdAndGroup($userId, $groupId) {
    $sql = "SELECT t.id
            FROM task_supervisors ts
            JOIN tasks t ON t.id = ts.task_id
            WHERE ts.user_id = :user_id
              AND t.project_group = :group_id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':user_id' => $userId,
        ':group_id' => $groupId
    ]);
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function getSupervisorNamesByTaskId($taskId) {
    $stmt = $this->db->prepare("
        SELECT u.full_name 
        FROM task_supervisors ts 
        JOIN users u ON ts.user_id = u.id 
        WHERE ts.task_id = ?
    ");
    $stmt->execute([$taskId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN); // trả về array tên
}


}
