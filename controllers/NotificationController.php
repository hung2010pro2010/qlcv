<?php
require_once 'models/Notification.php';

class NotificationController {
    private $db;

    public function __construct() {
        $this->db = (new DB())->connect();
    }

    // ✅ Danh sách thông báo
    public function list() {
        session_start();
        if (empty($_SESSION['user']['id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $model = new Notification($this->db);
        $notifications = $model->getAllByUser($userId, 100);

        include 'views/notifications/list.php';
    }

    // ✅ Xoá 1 thông báo
    public function delete() {
        session_start();
        if (empty($_SESSION['user']['id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: index.php?controller=notification&action=list');
            exit;
        }

        $model = new Notification($this->db);
        $model->deleteById($_GET['id']);

        header('Location: index.php?controller=notification&action=list');
        exit;
    }

    // ✅ Xoá toàn bộ thông báo
    public function deleteAll() {
        session_start();
        if (empty($_SESSION['user']['id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $model = new Notification($this->db);
        $model->deleteAllByUser($userId);

        header('Location: index.php?controller=notification&action=list');
        exit;
    }

    public function fetch() {
    session_start();
    header('Content-Type: application/json');

    if (empty($_SESSION['user']['id'])) {
        echo json_encode([]);
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $model = new Notification($this->db);
    $notifications = $model->getAllByUser($userId, 5);

    echo json_encode($notifications);
    exit;
}

public function markRead() {
    session_start();
    $userId = $_SESSION['user']['id'] ?? 0;
    if (!$userId) return;

    $model = new Notification($this->db);
    $model->markAllAsRead($userId);
}


}
