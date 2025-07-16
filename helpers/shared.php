<?php
require_once 'models/ProjectGroup.php';
require_once 'models/TaskSupervisor.php';
require_once 'models/Task.php';
require_once 'models/Notification.php';

// ✅ Lấy danh sách nhóm dự án (dùng cho sidebar)
function getProjectGroups($db) {
    $currentUser = $_SESSION['user'] ?? null;
    if (!$currentUser) return [];

    $projectGroupModel = new ProjectGroup($db);
    $taskModel = new Task($db);
    $taskSupervisorModel = new TaskSupervisor($db);

    // Admin → lấy tất cả nhóm
    // Nhân viên → chỉ lấy nhóm có task mà họ là người phụ trách
    if ($currentUser['role'] === 'admin') {
        $groups = $projectGroupModel->getAll();
    } else {
        $groups = $projectGroupModel->getGroupsBySupervisor($currentUser['id']);
    }

    // Đếm số task liên quan theo từng nhóm
    foreach ($groups as &$group) {
        $group['new_task_count'] = $taskModel->countTasksForGroupAndUser(
            $group['id'],
            $currentUser['id']
        );
    }
    unset($group);

    return $groups;
}

// ✅ Lấy danh sách thông báo gần đây của người dùng
function getNotifications($db, $userId) {
    $notificationModel = new Notification($db);
    return $notificationModel->getRecentByUser($userId);
}

// ✅ Màu sắc theo trạng thái công việc
function getStatusColorClass($status) {
    return match ($status) {
        'Chưa nhận việc' => 'bg-blue-grey',
        'Đang thực hiện' => 'bg-green',
        'Trình duyệt', 'Tái trình duyệt' => 'bg-orange',
        'Đã hoàn thành' => 'bg-green',
        'Đã hoãn việc' => 'bg-orange',
        'Đã hủy' => 'bg-red',
        default => 'bg-grey',
    };
}

// ✅ Màu thanh trạng thái
function getStatusBarClass($status) {
    return getStatusColorClass($status); // dùng lại logic màu
}

// ✅ Phần trăm tiến độ tương ứng trạng thái
function getStatusProgress($status) {
    return match ($status) {
        'Chưa nhận việc' => 10,
        'Đang thực hiện' => 50,
        'Trình duyệt', 'Tái trình duyệt' => 80,
        'Đã hoàn thành' => 100,
        'Đã hoãn việc' => 30,
        'Đã hủy' => 100,
        default => 0,
    };
}

// ✅ Lấy ID người dùng mục tiêu (cho admin hoặc chính họ)
function getTargetUserId() {
    $currentUser = $_SESSION['user'] ?? null;
    if (!$currentUser) return null;

    if ($currentUser['role'] === 'admin' && isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
        return (int) $_GET['user_id'];
    }

    return $currentUser['id'];
}
