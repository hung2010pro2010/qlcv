<?php
class TaskReport {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy báo cáo theo task_id (dùng để kiểm tra hoặc hiển thị)
    public function getByTaskId($taskId) {
        $stmt = $this->db->prepare("
            SELECT tr.*, u.full_name 
            FROM task_reports tr
            LEFT JOIN users u ON tr.user_id = u.id
            WHERE tr.task_id = ?
            ORDER BY tr.created_at DESC
        ");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm báo cáo mới (dùng cho submitReport)
    public function add($taskId, $userId, $title, $resultLink, $content, $status) {
        $stmt = $this->db->prepare("
            INSERT INTO task_reports (task_id, user_id, title, result_link, content, status)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$taskId, $userId, $title, $resultLink, $content, $status]);
    }

    // Lấy báo cáo đầu tiên của user (tuỳ chọn)
    public function getFirstReportByUser($taskId, $userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM task_reports
            WHERE task_id = ? AND user_id = ?
            ORDER BY created_at ASC
            LIMIT 1
        ");
        $stmt->execute([$taskId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Xoá báo cáo theo taskId (nếu cần)
    public function deleteByTaskId($taskId) {
        $stmt = $this->db->prepare("DELETE FROM task_reports WHERE task_id = ?");
        return $stmt->execute([$taskId]);
    }

    public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM task_reports WHERE id = ?");
    return $stmt->execute([$id]);
}
public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM task_reports WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function update($id, $title, $resultLink, $content, $status) {
    $stmt = $this->db->prepare("
        UPDATE task_reports
        SET title = ?, result_link = ?, content = ?, status = ?
        WHERE id = ?
    ");
    return $stmt->execute([$title, $resultLink, $content, $status, $id]);
}


}
