<?php
//Controllers/TaskController.php
require_once 'models/Task.php';
require_once 'models/User.php';
require_once 'models/ProjectGroup.php';
require_once 'models/Category.php';
require_once 'models/TaskResponsible.php';
require_once 'models/Notification.php';
require_once 'models/TaskResult.php'; // 👈 thêm dòng này
require_once 'models/TaskReport.php';
require_once 'models/TaskSupervisor.php';
require_once 'models/DepartmentTask.php'; // ⬅️ Bổ sung dòng này nếu chưa có




class TaskController {
    private $db;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }

    private function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
    }
    // Hàm lấy tên project theo id
    private function getProjectNameById($projects, $id) {
        foreach ($projects as $p) {
            if ($p['id'] == $id) {
                return $p['name'];
            }
        }
        return 'Không xác định';
    }

public function list() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    $taskModel = new Task($this->db);
    $taskResultModel = new TaskResult($this->db);
    $taskReportModel = new TaskReport($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db);
    $userModel = new User($this->db);

    $filters = [
        'status'              => $_GET['status'] ?? '',
        'priority'            => $_GET['priority'] ?? '',
        'approval_status'     => $_GET['approval_status'] ?? '',
        'responsible_person'  => $_GET['responsible_person'] ?? ''
    ];

    // ✅ Nếu không truyền status thì loại công việc "Đã hoàn thành"
    if (empty($_GET['status'])) {
        $filters['exclude_status'] = 'Đã hoàn thành';
    }

    $status = $_GET['status'] ?? null;

    if ($status === 'all') {
        // Hiển thị tất cả công việc — không lọc
        unset($filters['status']);
    } elseif (!empty($status)) {
        $filters['status'] = $status;
    } else {
        // Mặc định: chỉ hiển thị công việc chưa hoàn thành
        $filters['exclude_status'] = 'Đã hoàn thành';
    }


    $currentUser = $_SESSION['user'];
    if ($currentUser['role'] !== 'admin') {
        $supervisorTaskIds = $taskSupervisorModel->getTaskIdsByUserId($currentUser['id']);
        $filters['related_to_user'] = [
            'user_id' => $currentUser['id'],
            'responsible_task_ids' => $supervisorTaskIds
        ];
    }

    // Phân trang
    $tasksPerPage = 10;
    $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($currentPage - 1) * $tasksPerPage;

    $totalTasks = $taskModel->countFiltered($filters);
    $totalPages = ceil($totalTasks / $tasksPerPage);

    $tasks = $taskModel->getFilteredPaged($filters, $tasksPerPage, $offset);

    foreach ($tasks as &$task) {
        // Người phụ trách
        $supervisorIds = $taskSupervisorModel->getUserIdsByTaskId($task['id']);
        $supervisorNames = [];
        foreach ($supervisorIds as $uid) {
            $user = $userModel->getById($uid);
            if ($user) $supervisorNames[] = $user['full_name'];
        }
        $task['supervisor_names'] = $supervisorNames;

        // Kết quả
        $task['results'] = $taskResultModel->getByTaskId($task['id']);

        // Báo cáo
        $reports = $taskReportModel->getByTaskId($task['id']);
        $reportsByUser = [];
        foreach ($reports as $report) {
            $uid = $report['user_id'];
            $user = $userModel->getById($uid);
            $report['full_name'] = $user['full_name'] ?? 'Người dùng #' . $uid;
            $reportsByUser[$uid][] = $report;
        }
        $task['reports_by_user'] = $reportsByUser;

        // Tự động cập nhật trạng thái khi đã duyệt hoặc hủy
        if ($task['approval_status'] === 'Đã duyệt' && $task['task_status'] !== 'Đã hoàn thành') {
            $task['task_status'] = 'Đã hoàn thành';
            $taskModel->updateTaskStatus($task['id'], 'Đã hoàn thành');
        } elseif ($task['approval_status'] === 'Hủy' && $task['task_status'] !== 'Đã hủy') {
            $task['task_status'] = 'Đã hủy';
            $taskModel->updateTaskStatus($task['id'], 'Đã hủy');
        }
    }
    unset($task);

    // Lấy nhóm dự án cho menu
    $projectGroups = getProjectGroups($this->db);
    $userId = $currentUser['id'];
    $userRole = $currentUser['role'];

    if ($userRole !== 'admin') {
        $filteredGroups = [];
        foreach ($projectGroups as $group) {
            $count = $taskModel->countTasksForGroupAndUser($group['id'], $userId);
            if ($count > 0) {
                $group['new_task_count'] = $count;
                $filteredGroups[] = $group;
            }
        }
        $projectGroups = $filteredGroups;
    }

    include 'views/tasks/list.php';
}

public function add() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    $userModel = new User($this->db);
    $projectModel = new ProjectGroup($this->db);
    $categoryModel = new Category($this->db);
    $taskModel = new Task($this->db);
    $taskResponsibleModel = new TaskResponsible($this->db);
    $notificationModel = new Notification($this->db);
    $taskResultModel = new TaskResult($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db);
    $departmentTaskModel = new DepartmentTask($this->db);

    // Thông tin người dùng
    $currentUser = $_SESSION['user'];
    $userId = $currentUser['id'];

    // Lấy dữ liệu view
    $users = $userModel->getAll();
    $projects = $projectModel->getAll();
    $categories = $categoryModel->getAll();

    // Lấy danh sách công việc liên phòng phù hợp
    if (in_array($currentUser['role'], ['admin', 'manager'])) {
        $relatedDepartmentTasks = $departmentTaskModel->getAllForDropdown();
    } else {
        $relatedDepartmentTasks = $departmentTaskModel->getRelatedTasksForUser($userId);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $createdBy = $userId;
        $projectGroupId = $_POST['project_group_id'] ?? null;
        $projectName = $this->getProjectNameById($projects, $projectGroupId);

        // Upload file
        $attachmentPath = '';
        if (!empty($_FILES['attachment_path']['name'])) {
            $uploadDir = 'uploads/';
            $filename = time() . '_' . basename($_FILES['attachment_path']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['attachment_path']['tmp_name'], $targetPath)) {
                $attachmentPath = $targetPath;
            }
        }

        $data = [
            'task_code' => $_POST['code'] ?? '',
            'project_group' => $projectGroupId,
            'category' => $_POST['task_category_id'] ?? '',
            'detail' => $_POST['title'] ?? '',
            'expected_result' => null,
            'requirements' => $_POST['requirements'] ?? '',
            'result_link' => null,
            'attachment_path' => $attachmentPath,
            'priority' => $_POST['priority'] ?? '',
            'start_date' => $_POST['start_date'] ?? '',
            'due_date' => $_POST['due_date'] ?? '',
            'approval_status' => $_POST['approval'] ?? '',
            'task_status' => $_POST['status'] ?? '',
            'approval_time' => $_POST['approval_time'] ?? null,
            'status_time' => $_POST['status_time'] ?? null,
            'created_by' => $createdBy,
            'department_task_id' => is_numeric($_POST['department_task_id'] ?? '') ? $_POST['department_task_id'] : null
        ];

        $taskId = $taskModel->create($data);

        // Kết quả cần đạt
        $descriptions = $_POST['description'] ?? [];
        $resultLinks  = $_POST['result_link'] ?? [];
        foreach ($descriptions as $i => $desc) {
            $link = $resultLinks[$i] ?? '';
            if (trim($desc) !== '' || trim($link) !== '') {
                $taskResultModel->add($taskId, $desc, $link);
            }
        }

        // Người liên quan
        foreach ($_POST['responsible_person'] ?? [] as $userId) {
            $taskResponsibleModel->create($taskId, (int)$userId);
        }

        // Người phụ trách
        foreach ($_POST['supervisors'] ?? [] as $userId) {
            $taskSupervisorModel->create($taskId, (int)$userId, 'chịu trách nhiệm');
        }

        // Tạo thông báo
        $notificationModel->create([
            'user_id' => $createdBy,
            'icon' => 'add_circle',
            'color' => 'bg-blue',
            'message' => 'Công việc thuộc dự án "' . htmlspecialchars($projectName) . '" đã được tạo.'
        ]);

        header('Location: index.php?controller=task&action=list');
        exit;
    } else {
        $autoCode = $taskModel->generateSequentialCode();
        $projectGroups = getProjectGroups($this->db);
        include 'views/tasks/add.php';
    }
}


public function edit() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php?controller=task&action=list');
        exit;
    }

    $taskId = (int)$_GET['id'];
    $currentUser = $_SESSION['user'];

    $taskModel = new Task($this->db);
    $userModel = new User($this->db);
    $projectModel = new ProjectGroup($this->db);
    $categoryModel = new Category($this->db);
    $taskResponsibleModel = new TaskResponsible($this->db);
    $notificationModel = new Notification($this->db);
    $taskResultModel = new TaskResult($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db);
    $departmentTaskModel = new DepartmentTask($this->db);

    $users = $userModel->getAll();
    $projects = $projectModel->getAll();
    $categories = $categoryModel->getAll();

    // Danh sách công việc liên phòng phù hợp
    if (in_array($currentUser['role'], ['admin', 'manager'])) {
        $relatedDepartmentTasks = $departmentTaskModel->getAllForDropdown();
    } else {
        $relatedDepartmentTasks = $departmentTaskModel->getRelatedTasksForUser($currentUser['id']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = date('Y-m-d H:i:s');

        $attachmentPath = $_POST['old_attachment'] ?? '';
        if (!empty($_FILES['attachment_path']['name'])) {
            $uploadDir = 'uploads/';
            $filename = time() . '_' . basename($_FILES['attachment_path']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['attachment_path']['tmp_name'], $targetPath)) {
                $attachmentPath = $targetPath;
            }
        }

        $approvalStatus = $_POST['approval_status'] ?? '';
        $taskStatus = $_POST['task_status'] ?? '';
        $approvalTime = in_array($approvalStatus, ['Phê duyệt', 'Giao việc']) ? $now : ($_POST['approval_time'] ?? null);
        $statusTime = in_array($taskStatus, ['Đang thực hiện', 'Đã hoàn thành']) ? $now : ($_POST['status_time'] ?? null);

        $data = [
            'id' => $taskId,
            'task_code' => $_POST['task_code'] ?? '',
            'project_group' => $_POST['project_group'] ?? null,
            'category' => $_POST['category'] ?? null,
            'detail' => $_POST['detail'] ?? '',
            'requirements' => $_POST['requirements'] ?? '',
            'priority' => $_POST['priority'] ?? 1,
            'start_date' => $_POST['start_date'] ?? null,
            'due_date' => $_POST['due_date'] ?? null,
            'approval_status' => $approvalStatus,
            'approval_time' => $approvalTime,
            'task_status' => $taskStatus,
            'status_time' => $statusTime,
            'attachment_path' => $attachmentPath,
            'department_task_id' => is_numeric($_POST['department_task_id'] ?? '') ? $_POST['department_task_id'] : null
        ];

        $taskModel->update($data);
        $taskResultModel->updateResults($taskId, $_POST['description'] ?? [], $_POST['result_link'] ?? []);

        $taskSupervisorModel->deleteByTaskId($taskId);
        foreach ($_POST['supervisors'] ?? [] as $uid) {
            $taskSupervisorModel->create($taskId, (int)$uid, 'chịu trách nhiệm');
        }

        $taskResponsibleModel->deleteByTaskId($taskId);
        foreach ($_POST['responsible_person'] ?? [] as $uid) {
            $taskResponsibleModel->create($taskId, (int)$uid);
        }

        $projectName = $this->getProjectNameById($projects, $data['project_group']);
        $notificationModel->create([
            'user_id' => $currentUser['id'],
            'icon' => 'edit',
            'color' => 'bg-orange',
            'message' => 'Công việc "' . htmlspecialchars($projectName) . '" đã được cập nhật.'
        ]);

        header('Location: index.php?controller=task&action=list');
        exit;
    } else {
        $task = $taskModel->getById($taskId);
        $taskResults = $taskResultModel->getByTaskId($taskId);
        $responsibleUserIds = $taskResponsibleModel->getUserIdsByTaskId($taskId);
        $supervisorIds = $taskSupervisorModel->getUserIdsByTaskId($taskId);
        $projectGroups = getProjectGroups($this->db);

        $departmentTaskTitle = '';
        if (!empty($task['department_task_id'])) {
            $departmentTaskTitle = $departmentTaskModel->getTitleById($task['department_task_id']);
        }

        include 'views/tasks/edit.php';
    }
}




    public function delete() {
        $this->requireLogin();

        $taskModel = new Task($this->db);
        $taskResponsibleModel = new TaskResponsible($this->db);
        $taskResultModel = new TaskResult($this->db);
        $notificationModel = new Notification($this->db);
        $projectModel = new ProjectGroup($this->db);

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $taskId = $_GET['id'];
            $task = $taskModel->getById($taskId);

            if ($task) {
                $projectGroups = $projectModel->getAll();
                $projectName = $this->getProjectNameById($projectGroups, $task['project_group']);
                $taskResponsibleModel->deleteByTaskId($taskId);
                $taskResultModel->deleteByTaskId($taskId);
                $taskModel->delete($taskId);

                $notificationModel->create([
                    'user_id' => $_SESSION['user']['id'],
                    'icon' => 'delete',
                    'color' => 'bg-red',
                    'message' => 'Công việc thuộc dự án "' . htmlspecialchars($projectName) . '" đã bị xóa.'
                ]);
            }
        }

        header('Location: index.php?controller=task&action=list');
        exit;
    }

public function listByStatus() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    $status = $_GET['status'] ?? '';
    if (!$status) {
        header('Location: index.php?controller=task&action=list');
        exit;
    }

    $taskModel = new Task($this->db);
    $taskResultModel = new TaskResult($this->db);
    $taskResponsibleModel = new TaskResponsible($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db); 

    $filters = ['approval_status' => $status];
    $currentUser = $_SESSION['user'];

    if ($currentUser['role'] !== 'admin') {
        $filters['assigned_to'] = $currentUser['id'];
    }

    $tasks = $taskModel->getFiltered($filters);

    foreach ($tasks as &$task) {
        $task['results'] = $taskResultModel->getByTaskId($task['id']);
        $task['responsible_usernames'] = implode(', ', $taskResponsibleModel->getUsernamesByTaskId($task['id']));
    }
    unset($task);

    $projectGroups = getProjectGroups($this->db);
    foreach ($projectGroups as &$group) {
        $group['new_task_count'] = $taskModel->countNewTasksForGroupAndUser($group['id'], $currentUser['id'], $taskResponsibleModel);
    }
    unset($group);

    $currentController = 'task';
    $currentAction = 'listByStatus';
    $currentStatus = $status;

    include 'views/tasks/list.php';
}


public function listByGroup() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    $groupId = isset($_GET['group_id']) ? (int)$_GET['group_id'] : 0;
    if ($groupId <= 0) {
        header('Location: index.php?controller=task&action=list');
        exit;
    }

    $currentUser = $_SESSION['user'];
    $userId = $currentUser['id'];
    $userRole = $currentUser['role'];

    $taskModel = new Task($this->db);
    $taskResultModel = new TaskResult($this->db);
    $taskResponsibleModel = new TaskResponsible($this->db);
    $taskReportModel = new TaskReport($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db);
    $userModel = new User($this->db);

    // ✅ Lấy tất cả công việc theo group
    if ($userRole === 'admin') {
        $allTasks = $taskModel->getByGroupId($groupId);
    } else {
        $allTasks = $taskModel->getByGroupIdAndUser($groupId, $userId, $userRole);
    }
    // ✅ LỌC ra công việc chưa hoàn thành
    // $allTasks = array_filter($allTasks, function ($task) {
    //     return $task['task_status'] !== 'Đã hoàn thành';
    // });
    // ✅ Phân trang trước
    $tasksPerPage = 10;
    $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $totalTasks = count($allTasks);
    $totalPages = ceil($totalTasks / $tasksPerPage);
    $tasks = array_slice($allTasks, ($currentPage - 1) * $tasksPerPage, $tasksPerPage);

    // ✅ Bổ sung dữ liệu cho từng công việc
    foreach ($tasks as &$task) {
        // Người phụ trách (từ bảng task_supervisors)
        $supervisorIds = $taskSupervisorModel->getUserIdsByTaskId($task['id']);
        $supervisorNames = [];
        foreach ($supervisorIds as $uid) {
            $user = $userModel->getById($uid);
            if ($user) {
                $supervisorNames[] = $user['full_name'];
            }
        }
        $task['supervisor_names'] = $supervisorNames;

        // Người liên quan (task_responsible)
        $task['responsible_usernames'] = implode(', ', $taskResponsibleModel->getUsernamesByTaskId($task['id']));

        // Kết quả chính thức
        $task['results'] = $taskResultModel->getByTaskId($task['id']);

        // Báo cáo theo user
        $reports = $taskReportModel->getByTaskId($task['id']);
        $reportsByUser = [];
        foreach ($reports as $report) {
            $uid = $report['user_id'];
            $user = $userModel->getById($uid);
            $report['full_name'] = $user['full_name'] ?? 'Người dùng #' . $uid;
            $reportsByUser[$uid][] = $report;
        }
        $task['reports_by_user'] = $reportsByUser;
    }
    unset($task);

    // ✅ Sidebar nhóm dự án + badge
    $projectGroups = getProjectGroups($this->db);
    foreach ($projectGroups as &$group) {
        $group['new_task_count'] = $taskModel->countNewTasksForGroupAndUser($group['id'], $userId, $taskResponsibleModel);
    }
    unset($group);

    // ✅ Biến truyền view
    $currentController = 'task';
    $currentAction = 'listByGroup';
    $currentGroupId = $groupId;

    include 'views/tasks/list.php';
}



public function listByUser() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    $userId = $_GET['user_id'] ?? null;
    if (!$userId || !is_numeric($userId)) {
        header('Location: index.php?controller=task&action=list');
        exit;
    }

    $taskModel = new Task($this->db);
    $taskResultModel = new TaskResult($this->db);
    $taskSupervisorModel = new TaskSupervisor($this->db);
    $userModel = new User($this->db);

    // Lấy danh sách task_id mà user này là người phụ trách
    $supervisedTaskIds = $taskSupervisorModel->getTaskIdsByUserId($userId);

    // Tạo bộ lọc chính xác theo quyền người dùng
    $filters = [
        'current_user' => [
            'id' => $userId,
            'is_admin' => false, // vì đang xem theo 1 user cụ thể
            'supervisor_task_ids' => $supervisedTaskIds
        ]
    ];

    $tasks = $taskModel->getFiltered($filters);
    $taskReportModel = new TaskReport($this->db);
    // Gán thêm tên người phụ trách và kết quả cho mỗi task
    foreach ($tasks as &$task) {
        // Người phụ trách
        $supervisorIds = $taskSupervisorModel->getUserIdsByTaskId($task['id']);
        $supervisorNames = [];

        foreach ($supervisorIds as $sid) {
            $user = $userModel->getById($sid);
            if ($user) {
                $supervisorNames[] = $user['full_name'];
            }
        }

        // $task['supervisor_names'] = implode(', ', $supervisorNames);
        $task['supervisor_names'] = $supervisorNames; // trả về dạng mảng


        // Kết quả công việc
        $task['results'] = $taskResultModel->getByTaskId($task['id']);
        // 👇 Bổ sung phần lấy báo cáo
        $reports = $taskReportModel->getByTaskId($task['id']);
        $reportsByUser = [];
        foreach ($reports as $report) {
            $uid = $report['user_id'];
            $user = $userModel->getById($uid);
            $report['full_name'] = $user['full_name'] ?? 'Người dùng #' . $uid;
            $reportsByUser[$uid][] = $report;
        }
        $task['reports_by_user'] = $reportsByUser;
        
    }
    unset($task);

    $projectGroups = getProjectGroups($this->db);
    $currentController = 'task';
    $currentAction = 'listByUser';
    $currentUserId = $userId;

    include 'views/tasks/list.php';
}

function getTargetUserId() {
    $currentUser = $_SESSION['user'] ?? null;
    if (!$currentUser) return null;

    if ($currentUser['role'] === 'admin' && isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
        return (int) $_GET['user_id'];
    }

    return $currentUser['id'];
}

public function updateTaskStatus($taskId, $status, $statusTime = null) {
    $statusTime = $statusTime ?? date('Y-m-d H:i:s');

    $stmt = $this->db->prepare("
        UPDATE tasks 
        SET task_status = :status, status_time = :status_time 
        WHERE id = :id
    ");

    return $stmt->execute([
        ':status' => $status,
        ':status_time' => $statusTime,
        ':id' => $taskId
    ]);
}
// Báo cáo
public function report() {
    require_once 'helpers/shared.php';
    $this->requireLogin();

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php?controller=task&action=list');
        exit;
    }

    $taskId = (int)$_GET['id'];
    $taskModel = new Task($this->db);
    $userModel = new User($this->db);
    $taskReportModel = new TaskReport($this->db); // 👈 Bạn cần tạo model này nếu chưa có

    $task = $taskModel->getById($taskId);
    if (!$task) {
        echo "Không tìm thấy công việc.";
        return;
    }

    // Lấy danh sách báo cáo
    $reports = $taskReportModel->getByTaskId($taskId);

    // Lấy thông tin người dùng cho từng báo cáo
    foreach ($reports as &$r) {
        $user = $userModel->getById($r['user_id']);
        $r['full_name'] = $user['full_name'] ?? 'Không rõ';
    }
    unset($r);

    include 'views/tasks/report.php';
}

public function submitReport() {
    $this->requireLogin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
        $taskId = (int) $_GET['id'];
        $userId = $_SESSION['user']['id'];
        $title = $_POST['title'] ?? '';
        $link = $_POST['link'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? '';
        $currentTime = date('Y-m-d H:i:s');

        require_once 'models/TaskReport.php';
        $taskReportModel = new TaskReport($this->db);

        // Lưu báo cáo
        if ($status === 'Đang thực hiện') {
            $stmt = $this->db->prepare("INSERT INTO task_reports (task_id, user_id, title, result_link, content, status, submitted_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$taskId, $userId, $title, $link, $content, $status, $currentTime]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO task_reports (task_id, user_id, title, result_link, content, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$taskId, $userId, $title, $link, $content, $status]);
        }

        // ✅ Cập nhật trạng thái task tương ứng
        if (in_array($status, ['Đang thực hiện', 'Trình duyệt', 'Tái trình duyệt', 'Hoàn thành'])) {
            $this->updateTaskStatus($taskId, $status, $currentTime);
        }

        header('Location: index.php?controller=task&action=list');
        exit;
    }

    echo "Dữ liệu không hợp lệ.";
}

public function editReport() {
    $this->requireLogin();

    $reportId = $_GET['id'] ?? null;
    if (!$reportId || !is_numeric($reportId)) {
        echo "Báo cáo không hợp lệ."; exit;
    }

    $taskReportModel = new TaskReport($this->db);
    $report = $taskReportModel->getById($reportId);

    if (!$report || $report['user_id'] != $_SESSION['user']['id']) {
        echo "Bạn không có quyền sửa báo cáo này."; exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $link = $_POST['link'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? '';

        $taskReportModel->update($reportId, $title, $link, $content, $status);
        header("Location: index.php?controller=task&action=report&id=" . $report['task_id']);
        exit;
    }

    include 'views/tasks/edit_report.php';
}

public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM task_reports WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function update($id, $title, $link, $content, $status) {
    $stmt = $this->db->prepare("
        UPDATE task_reports
        SET title = ?, result_link = ?, content = ?, status = ?
        WHERE id = ?
    ");
    return $stmt->execute([$title, $link, $content, $status, $id]);
}
public function deleteReport() {
    $this->requireLogin();
    $reportId = $_GET['id'] ?? null;

    if (!$reportId) {
        echo "ID không hợp lệ."; exit;
    }

    require_once 'models/TaskReport.php';
    $reportModel = new TaskReport($this->db);
    $report = $reportModel->getById($reportId);

    if (!$report || $report['user_id'] != $_SESSION['user']['id']) {
        echo "Bạn không có quyền xoá báo cáo này."; exit;
    }

    $this->db->prepare("DELETE FROM task_reports WHERE id = ?")->execute([$reportId]);

    // header("Location: index.php?controller=task&action=report&id=" . $report['task_id']);
    header('Location: index.php?controller=task&action=list');
    exit;
}


public function updateReport() {
    $reportId = $_POST['report_id'] ?? null;
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Nếu có thêm title hoặc link
    $title = $_POST['title'] ?? '';
    $resultLink = $_POST['link'] ?? '';

    if ($reportId) {
        $taskReportModel = new TaskReport($this->db);
        $taskReportModel->update($reportId, $title, $resultLink, $content, $status);
    }

    // Chuyển hướng lại trang danh sách
    header('Location: index.php?controller=task&action=list');
    exit;
}

public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $id = $data['id'] ?? null;
            $status = $data['status'] ?? null;

            if ($id && $status) {
                $success = $this->taskModel->updateStatus($id, $status);
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            }
            exit;
        }
    }

}
