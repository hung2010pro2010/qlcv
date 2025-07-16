<?php
class Notification {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ✅ Tạo thông báo mới
    public function create($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO notifications (user_id, icon, color, message, created_at) 
                VALUES (:user_id, :icon, :color, :message, NOW())
            ");
            return $stmt->execute([
                ':user_id' => $data['user_id'],
                ':icon'    => $data['icon'],
                ':color'   => $data['color'],
                ':message' => $data['message']
            ]);
        } catch (PDOException $e) {
            error_log('Notification::create - ' . $e->getMessage());
            return false;
        }
    }

    // ✅ Lấy danh sách thông báo theo user (có giới hạn)
    public function getAllByUser($userId, $limit = 10) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM notifications 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Notification::getAllByUser - ' . $e->getMessage());
            return [];
        }
    }

    // ✅ Lấy tất cả thông báo không giới hạn
    public function getAllByUserNoLimit($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM notifications 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC
            ");
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Notification::getAllByUserNoLimit - ' . $e->getMessage());
            return [];
        }
    }

    // ✅ Xoá 1 thông báo theo ID
    public function deleteById($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM notifications WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Notification::deleteById - ' . $e->getMessage());
            return false;
        }
    }

    // ✅ Xoá tất cả thông báo của 1 user
    public function deleteAllByUser($userId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM notifications WHERE user_id = :user_id");
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Notification::deleteAllByUser - ' . $e->getMessage());
            return false;
        }
    }

    // ⭕ Tuỳ chọn: Đánh dấu đã đọc (nếu có cột is_read)
    public function markAsRead($id) {
        try {
            $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Notification::markAsRead - ' . $e->getMessage());
            return false;
        }
    }
public function markAllAsRead($userId) {
    $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :user_id");
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
}
public function countUnread($userId) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND is_read = 0");
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}


}
