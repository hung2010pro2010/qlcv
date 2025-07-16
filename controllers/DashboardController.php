<?php
class DashboardController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    $currentUser = $_SESSION['user'];
    $isAdmin = $currentUser['role'] === 'admin';

    $taskModel = new Task($this->db);
    $taskResponsibleModel = new TaskResponsible($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db);
    $taskResultModel = new TaskResult($this->db);

    $filters = [];

    if (!empty($_GET['from_date'])) {
        $filters['start_date_from'] = $_GET['from_date'];
    }
    if (!empty($_GET['to_date'])) {
        $filters['due_date_to'] = $_GET['to_date'];
    }
    if (!empty($_GET['status'])) {
        $filters['status'] = $_GET['status'];
    }
   
    if (!empty($_GET['responsible_person'])) {
        $filters['responsible_person'] = $_GET['responsible_person'];
    }

    $filters['current_user'] = [
        'id' => $currentUser['id'],
        'is_admin' => $isAdmin,
        'supervisor_task_ids' => $isAdmin ? [] : $taskSupervisorModel->getTaskIdsByUserId($currentUser['id'])
    ];

    $allTasks = $taskModel->getFiltered($filters);

    $statusCount = [
        'Chưa nhận việc' => 0,
        'Đang thực hiện' => 0,
        'Trình duyệt' => 0,
        'Điều chỉnh nội dung' => 0,
        'Tái trình duyệt' => 0,
        'Đã hoàn thành' => 0,
        'Đã hoãn việc' => 0,
        'Đã hủy' => 0
    ];

    foreach ($allTasks as &$t) {
        if (isset($statusCount[$t['task_status']])) {
            $statusCount[$t['task_status']]++;
        }
        $t['responsible_usernames'] = implode(', ', $taskResponsibleModel->getUsernamesByTaskId($t['id']));
        $t['supervisor_names'] = implode(', ', array_column($taskSupervisorModel->getByTaskId($t['id']), 'full_name'));
        $t['results'] = $taskResultModel->getByTaskId($t['id']);
    }
    unset($t);

    $totalTasks = count($allTasks);
    $projectGroups = getProjectGroups($this->db);

    // ✅ Gửi danh sách người dùng xuống view
    $userList = $taskModel->getAllUsers();

    include 'views/dashboard/index.php';
}


    private function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
    }
}
?>
