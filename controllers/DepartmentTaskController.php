<?php
require_once 'models/DepartmentTask.php';
require_once 'models/Department.php';
require_once 'models/User.php';
require_once 'models/DepartmentTaskCategory.php';
require_once 'helpers/shared.php';

class DepartmentTaskController {
    private $db; 
    private $taskModel;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->taskModel = new DepartmentTask($db);

    }

    private function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
    }

    private function requireManagerOrAdmin() {
        $this->requireLogin();
        if (!in_array($_SESSION['user']['role'], ['admin', 'manager'])) {
            die("Bạn không có quyền truy cập chức năng này.");
        }
    }

public function list()
{
    $this->requireManagerOrAdmin();

    $catId  = isset($_GET['category_id']) && $_GET['category_id'] !== ''
              ? (int)$_GET['category_id']
              : null;

    $user   = $_SESSION['user'];
    $uid    = $user['id'];
    $isAdmin = ($user['role'] === 'admin');

    /* <-- truyền thêm $uid & $isAdmin --> */
    $tasks = $this->taskModel->getAll($catId, $uid, $isAdmin);

    $projectGroups = getProjectGroups($this->db);
    include 'views/department_tasks/list.php';
}

    
public function add()
{
    $this->requireManagerOrAdmin();

    /* ===== Lấy dữ liệu cho form ===== */
    $departmentModel = new Department($this->db);
    $departments     = $departmentModel->getAll();

    $userModel       = new User($this->db);
    $allUsers        = $userModel->getAll();
    $managerUsers    = $userModel->getByRole('manager');

    $categoryModel   = new DepartmentTaskCategory($this->db);
    $categories      = $categoryModel->getAll();

    /* ===== Sinh mã tự động để hiển thị ===== */
    $autoCode = $this->taskModel->generateCode();

    $errors = [];

    /* ===== Xử lý POST ===== */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // MÃ sinh tự động — luôn lấy lại để tránh trùng
        $code        = $this->taskModel->generateCode();
        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $categoryId  = $_POST['category_id'] ?? null;
        $startDate   = $_POST['start_date'] ?? '';
        $dueDate     = $_POST['due_date'] ?? '';
        $status      = $_POST['status'] ?? 'pending';
        $responsibles = $_POST['responsibles'] ?? [];
        $departments  = $_POST['departments']  ?? [];
        $subtasks     = $_POST['subtasks']     ?? [];

        $currentUser   = $_SESSION['user'] ?? [];
        $departmentId  = $currentUser['department_id'] ?? null;
        $createdBy     = $currentUser['id'] ?? null;

        /* Kiểm tra bắt buộc */
        if (!$title || !$categoryId || !$startDate || !$dueDate || empty($responsibles)) {
            $errors[] = "Vui lòng điền đầy đủ thông tin và chọn ít nhất một người phụ trách.";
        }

        if (empty($errors)) {
            $assignedBy = $responsibles[0]; // người phụ trách chính

            /* ========== Tạo công việc chính ========== */
            $taskId = $this->taskModel->create([
                'code'               => $code,
                'title'              => $title,
                'description'        => $description,
                'category_id'        => $categoryId,
                'from_department_id' => $departmentId,
                'to_department_id'   => $departmentId,
                'created_by'         => $createdBy,
                'assigned_by'        => $assignedBy,
                'start_time'         => $startDate . ' 00:00:00',
                'end_time'           => $dueDate   . ' 23:59:59',
                'status'             => $status
            ]);

            /* Người phụ trách */
            foreach ($responsibles as $uid) {
                $this->taskModel->addResponsible($taskId, $uid);
            }

            /* Phòng phụ trách */
            foreach ($departments as $deptId) {
                $this->taskModel->addRelatedDepartment($taskId, $deptId);
            }

            /* Công việc nhỏ + follower */
            foreach ($subtasks as $s) {
                $subTitle  = trim($s['title'] ?? '');
                $assignee  = $s['assignee_id'] ?? null;
                if ($subTitle && $assignee) {
                    $this->taskModel->addSubtask($taskId, [
                        'title'       => $subTitle,
                        'assignee_id' => $assignee
                    ]);
                    $subId = $this->db->lastInsertId();
                    foreach (($s['followers'] ?? []) as $fid) {
                        $this->taskModel->addSubtaskFollower($subId, $fid);
                    }
                }
            }

            $_SESSION['success'] = "Đã giao việc thành công.";
            header("Location: index.php?controller=department_task&action=list");
            exit;
        }
    }

    /* ===== Hiển thị form ===== */
    include 'views/department_tasks/add.php';
}



public function edit() {
    $this->requireManagerOrAdmin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        $_SESSION['error'] = "Thiếu ID công việc.";
        header("Location: index.php?controller=department_task&action=list");
        exit;
    }

    $task = $this->taskModel->getById($id);
    if (!$task) {
        $_SESSION['error'] = "Không tìm thấy công việc.";
        header("Location: index.php?controller=department_task&action=list");
        exit;
    }

    // Models
    $userModel = new User($this->db);
    $categoryModel = new DepartmentTaskCategory($this->db);
    $departmentModel = new Department($this->db);

    // Dữ liệu hiển thị
    $categories     = $categoryModel->getAll();
    $managerUsers   = $userModel->getByRole('manager');
    $responsibles   = $this->taskModel->getResponsibles($id);
    $responsibleIds = array_column($responsibles, 'id');
    $relatedUsers   = $this->taskModel->getRelatedUsers($id);
    $relatedIds     = array_column($relatedUsers, 'id');
    $subtasks       = $this->taskModel->getSubtasks($id);
    foreach ($subtasks as &$sub) {
        $sub['followers'] = array_column($this->taskModel->getSubtaskFollowers($sub['id']), 'id');
    }

    $departmentsAll = $departmentModel->getAll();
    $departmentIds = $this->taskModel->getRelatedDepartmentIds($id);

    if (method_exists($userModel, 'getDepartmentsByUserIds')) {
        $userDepartments = $userModel->getDepartmentsByUserIds($responsibleIds);
        $departments = array_filter($departmentsAll, function ($d) use ($userDepartments) {
            return in_array($d['id'], $userDepartments);
        });
    } else {
        $departments = $departmentsAll;
    }

    $errors = [];

    // Khi submit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title          = trim($_POST['title'] ?? '');
        $description    = trim($_POST['description'] ?? '');
        $categoryId     = $_POST['category_id'] ?? null;
        $startDate      = $_POST['start_date'] ?? '';
        $dueDate        = $_POST['due_date'] ?? '';
        $status         = $_POST['status'] ?? 'pending';
        $responsibles   = $_POST['responsibles'] ?? [];
        $relatedUsers   = $_POST['related_users'] ?? [];
        $departmentsPost= $_POST['departments'] ?? [];
        $subtasksPost   = $_POST['subtasks'] ?? [];
        $deleted        = $_POST['deleted_subtasks'] ?? '';

        // Nếu thiếu người giao việc thì lấy người phụ trách đầu tiên
        if (empty($_POST['main_responsible']) && !empty($responsibles)) {
            $_POST['main_responsible'] = $responsibles[0];
        }
        $mainResponsible = $_POST['main_responsible'] ?? null;

        if (!$title || !$categoryId || !$startDate || !$dueDate || !$mainResponsible) {
            $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc.";
        }

        if (empty($errors)) {
            // Cập nhật công việc chính
            $this->taskModel->update($id, [
                'title'         => $title,
                'description'   => $description,
                'category_id'   => $categoryId,
                'start_time'    => $startDate . ' 00:00:00',
                'end_time'      => $dueDate . ' 23:59:59',
                'status'        => $status,
                'assigned_by'   => $mainResponsible
            ]);

            // Người phụ trách & liên quan
            $this->taskModel->updateResponsibles($id, $responsibles);
            $this->taskModel->updateRelatedUsers($id, $relatedUsers);

            // Phòng phụ trách
            $this->taskModel->deleteRelatedDepartments($id);
            foreach ($departmentsPost as $deptId) {
                $this->taskModel->addRelatedDepartment($id, $deptId);
            }

            // Cập nhật subtasks cũ
            foreach ($subtasks as $i => $sub) {
                $subId = $sub['id'];
                if (isset($subtasksPost[$i])) {
                    $new = $subtasksPost[$i];
                    if (!empty($new['title']) && !empty($new['assignee_id'])) {
                        $this->taskModel->updateSubtask($subId, [
                            'title' => $new['title'],
                            'assignee_id' => $new['assignee_id']
                        ]);
                        $this->taskModel->deleteSubtaskFollowers($subId);
                        foreach ($new['followers'] ?? [] as $fid) {
                            $this->taskModel->addSubtaskFollower($subId, $fid);
                        }
                    }
                }
            }

            // Thêm subtasks mới
            foreach ($subtasksPost as $s) {
                if (empty($s['id']) && !empty($s['title']) && !empty($s['assignee_id'])) {
                    $this->taskModel->addSubtask($id, [
                        'title' => $s['title'],
                        'assignee_id' => $s['assignee_id']
                    ]);
                    $newId = $this->db->lastInsertId();
                    foreach ($s['followers'] ?? [] as $fid) {
                        $this->taskModel->addSubtaskFollower($newId, $fid);
                    }
                }
            }

            // Xoá subtasks bị đánh dấu xoá
            if (!empty($deleted)) {
                $ids = explode(',', $deleted);
                foreach ($ids as $subId) {
                    $this->taskModel->deleteSubtaskFollowers($subId);
                    $this->taskModel->deleteSubtaskReports($subId);
                    $this->taskModel->deleteSubtaskComments($subId);
                    $this->taskModel->deleteSubtask($subId);
                }
            }

            $_SESSION['success'] = "Đã cập nhật công việc thành công.";
            header("Location: index.php?controller=department_task&action=list");
            exit;
        }
    }

    include 'views/department_tasks/edit.php';
}


public function delete() {
    $this->requireManagerOrAdmin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Thiếu ID công việc.");
    }

    // Kiểm tra có tồn tại không
    $task = $this->taskModel->getDetailById($id);
    if (!$task) {
        die("Không tìm thấy công việc.");
    }

    // Xoá các bản ghi phụ trước (subtasks, liên quan)
    $this->taskModel->deleteAllSubtasks($id);         // Xoá công việc nhỏ
    $this->taskModel->deleteAllResponsibles($id);     // Xoá người phụ trách
    $this->taskModel->deleteAllRelatedUsers($id);     // Xoá người liên quan

    // Xoá công việc chính
    $this->taskModel->delete($id);

    $_SESSION['success'] = "Đã xoá công việc.";
    header("Location: index.php?controller=department_task&action=list");
    exit;
}


public function view()
{
    $this->requireManagerOrAdmin();
    $id = $_GET['id'] ?? null;
    if (!$id) die("Thiếu ID công việc.");

    $task = $this->taskModel->getDetailById($id);
    if (!$task) die("Không tìm thấy công việc.");

    // Nếu công việc không phải là 'cancelled' mới sync trạng thái
    if ($task['status'] !== 'cancelled') {
        $subtaskIds = $this->taskModel->getSubtaskIdsByTaskId($id);
        $hasUnreported = false;
        $allStatuses = [];

        foreach ($subtaskIds as $subId) {
            $reports = $this->taskModel->getReportsBySubtask($subId);
            if (empty($reports)) {
                $hasUnreported = true;
                break;
            }
            foreach ($reports as $r) {
                $allStatuses[] = $r['status'];
            }
        }

        if ($hasUnreported) {
            $calculatedStatus = 'in_progress';
        } elseif (in_array('rejected', $allStatuses)) {
            $calculatedStatus = 'rejected';
        } elseif (in_array('pending', $allStatuses)) {
            $calculatedStatus = 'in_progress';
        } else {
            $calculatedStatus = 'approved';
        }

        if ($task['status'] !== $calculatedStatus) {
            $this->taskModel->updateStatus($id, $calculatedStatus);
            $task['status'] = $calculatedStatus;
        }
    }

    // Lấy các thông tin còn lại như cũ
    $responsibles = $this->taskModel->getResponsibles($id);
    $relatedUsers = $this->taskModel->getRelatedUsers($id);

    // Lấy danh sách subtasks
    $stmt = $this->db->prepare("
        SELECT ds.*, u.full_name AS assignee_name
        FROM department_subtasks ds
        LEFT JOIN users u ON ds.assignee_id = u.id
        WHERE ds.task_id = ?
    ");
    $stmt->execute([$id]);
    $subtasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Lấy báo cáo theo subtask
    $subtaskReports = $this->taskModel->getSubtaskReports($id);

    // Followers
    $followersBySubtask = [];
    foreach ($subtasks as $sub) {
        $stmt = $this->db->prepare("
            SELECT u.full_name
            FROM department_subtask_followers f
            JOIN users u ON u.id = f.user_id
            WHERE f.subtask_id = ?
        ");
        $stmt->execute([$sub['id']]);
        $followersBySubtask[$sub['id']] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    include 'views/department_tasks/view.php';
}




public function report() {
    $this->requireLogin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        $_SESSION['error'] = "Thiếu ID công việc.";
        header("Location: index.php?controller=department_task&action=list");
        exit;
    }

    $task = $this->taskModel->getById($id);
    if (!$task) {
        $_SESSION['error'] = "Không tìm thấy công việc.";
        header("Location: index.php?controller=department_task&action=list");
        exit;
    }

    // Nếu gửi báo cáo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = trim($_POST['content'] ?? '');
        if ($content) {
            $reportModel = new DepartmentTaskReport($this->db);
            $reportModel->add([
                'task_id' => $id,
                'user_id' => $_SESSION['user']['id'],
                'content' => $content,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $_SESSION['success'] = "Đã gửi báo cáo.";
            header("Location: index.php?controller=department_task&action=view&id=$id");
            exit;
        } else {
            $error = "Vui lòng nhập nội dung báo cáo.";
        }
    }

    include 'views/department_tasks/report.php';
}

public function submit_subtask_report()
{
    $subtaskId = $_POST['subtask_id'] ?? null;
    $reportContent = trim($_POST['report_content'] ?? '');
    $userId = $_SESSION['user']['id'] ?? null;
    $now = date('Y-m-d H:i:s');
    $attachmentPath = null;

    if ($subtaskId && $userId && $reportContent) {
        // Xử lý file đính kèm
        if (!empty($_FILES['attachment']['name'])) {
            $uploadDir = 'uploads/reports/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filename = time() . '_' . basename($_FILES['attachment']['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
                $attachmentPath = $targetFile;
            }
        }

        // Gọi model để lưu báo cáo
        $this->taskModel->submitSubtaskReport($subtaskId, $userId, $reportContent, $now, $attachmentPath);
    }

    // Redirect về lại trang chi tiết công việc
    $stmt = $this->db->prepare("SELECT task_id FROM department_subtasks WHERE id = ?");
    $stmt->execute([$subtaskId]);
    $taskId = $stmt->fetchColumn();

    header("Location: index.php?controller=department_task&action=view&id=" . $taskId);
    exit;
}


public function delete_subtask_report() {
    $id = $_GET['id'] ?? null;
    // Kiểm tra quyền và xoá bằng model
    $this->taskModel->deleteSubtaskReport($id);
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

public function approve_subtask_report() {
    $id = $_GET['id'] ?? null;
    $this->taskModel->updateSubtaskReportStatus($id, 'approved');
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
 
public function reject_subtask_report() {
    $id = $_GET['id'] ?? null;
    $this->taskModel->updateSubtaskReportStatus($id, 'rejected');
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

public function approve_report() {
        $reportId = $_GET['id'] ?? null;
        if (!$reportId) {
            echo "Thiếu ID báo cáo";
            return;
        }

        $report = $this->taskModel->getReportById($reportId);
        if (!$report) {
            echo "Không tìm thấy báo cáo";
            return;
        }

        $this->taskModel->approveSubtaskReport($reportId);
        $taskId = $this->taskModel->getTaskIdBySubtask($report['subtask_id']);
        $this->taskModel->updateTaskStatusIfCompleted($taskId);

        header("Location: index.php?controller=department_task&action=view&id=$taskId");
        exit;
    }

public function getReportById($id) {
    $stmt = $this->db->prepare("SELECT * FROM department_subtask_reports WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
public function getTaskIdBySubtask($subtaskId) {
    $stmt = $this->db->prepare("SELECT task_id FROM department_subtasks WHERE id = ?");
    $stmt->execute([$subtaskId]);
    return $stmt->fetchColumn();
}


    public function reject_report() {
        $reportId = $_GET['id'] ?? null;
        if (!$reportId) {
            $_SESSION['error'] = "Thiếu ID báo cáo.";
            header('Location: index.php?controller=department_task&action=list');
            exit;
        }

        $this->taskModel->updateSubtaskReportStatus($reportId, 'rejected');
        $_SESSION['success'] = "Đã từ chối báo cáo.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function delete_report() {
        $reportId = $_GET['id'] ?? null;
        if (!$reportId) {
            $_SESSION['error'] = "Thiếu ID báo cáo.";
            header('Location: index.php?controller=department_task&action=list');
            exit;
        }

        $this->taskModel->deleteSubtaskReport($reportId);
        $_SESSION['success'] = "Đã xoá báo cáo.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

public function edit_report() {
    if (empty($_GET['id'])) {
        echo "Thiếu dữ liệu.";
        return;
    }

    $id = $_GET['id'];

    // Lấy báo cáo
    $report = $this->taskModel->getSubtaskReportById($id);
    if (!$report) {
        echo "Không tìm thấy báo cáo.";
        return;
    }

    // Truy ngược từ subtask_id sang task_id
    $subtaskId = $report['subtask_id'];
    $taskId = $this->taskModel->getTaskIdBySubtaskId($subtaskId);

    include 'views/department_tasks/edit_subtask_report.php';
}


public function update_report() {
        $id = $_POST['id'] ?? null;
        $content = $_POST['content'] ?? '';
        $attachment = null;

        // Xử lý file nếu có
        if (!empty($_FILES['attachment']['name'])) {
            $fileName = time() . '_' . $_FILES['attachment']['name'];
            $target = 'uploads/' . $fileName;
            move_uploaded_file($_FILES['attachment']['tmp_name'], $target);
            $attachment = $target;
        }

        // Kiểm tra quyền
        $stmt = $this->db->prepare("SELECT * FROM department_subtask_reports WHERE id = ?");
        $stmt->execute([$id]);
        $report = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$report || $report['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Bạn không có quyền cập nhật báo cáo này.";
            header('Location: index.php?controller=department_task&action=list');
            exit;
        }

        // Cập nhật
        $sql = "UPDATE department_subtask_reports SET content = ?, attachment = ? WHERE id = ?";
        $this->db->prepare($sql)->execute([$content, $attachment ?? $report['attachment'], $id]);

        $_SESSION['success'] = "Đã cập nhật báo cáo.";
        header('Location: index.php?controller=department_task&action=view&id=' . $report['subtask_id']);
    }
    public function add_comment() {
    $subtaskId = $_POST['subtask_id'];
    $content = $_POST['comment_content'];
    $userId = $_SESSION['user']['id'];
    $createdAt = date('Y-m-d H:i:s');

    $this->taskModel->addCommentToSubtask($subtaskId, $userId, $content, $createdAt);
    header("Location: index.php?controller=department_task&action=view&id=" . $_POST['task_id']);
    exit;
}



public function update_subtask_report() {
    $reportId = $_POST['report_id'] ?? null;
    $content = trim($_POST['report_content'] ?? '');
    $taskId = $_POST['task_id'] ?? null;

    if (!$reportId || !$taskId || !$content) {
        die("Thiếu dữ liệu.");
    }

    // Lấy thông tin báo cáo từ DB
    $report = $this->taskModel->getSubtaskReportById($reportId);
    if (!$report) {
        die("Không tìm thấy báo cáo.");
    }

    // Kiểm tra quyền
    $userId = $_SESSION['user']['id'] ?? null;
    $isOwner = $report['user_id'] == $userId;
    $isAdmin = $_SESSION['user']['role'] === 'admin';

    if (!$isOwner && !$isAdmin) {
        die("Bạn không có quyền cập nhật báo cáo này.");
    }

    // Xử lý file upload nếu có
    $attachment = $report['attachment']; // giữ file cũ
    if (!empty($_FILES['attachment']['name'])) {
        $uploadDir = 'uploads/';
        $fileName = time() . '_' . basename($_FILES['attachment']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
            $attachment = $targetPath;
        } else {
            die("Lỗi khi upload file.");
        }
    }

    // Cập nhật
    $this->taskModel->updateSubtaskReport($reportId, $content, $attachment);
    header("Location: index.php?controller=department_task&action=view&id=$taskId");
    exit;
}



    // Hiển thị form sửa bình luận
public function edit_comment() {
    if (empty($_GET['id']) || empty($_GET['task_id'])) {
        echo "Thiếu dữ liệu.";
        return;
    }

    $id = $_GET['id'];
    $taskId = $_GET['task_id'];

    $comment = $this->taskModel->getCommentById($id);
    if (!$comment) {
        echo "Không tìm thấy bình luận.";
        return;
    }

    // Truyền thêm taskId vào view để link "Huỷ" quay lại
    include 'views/department_tasks/edit_comment.php';
}


// Xử lý cập nhật bình luận
public function update_comment() {
    $commentId = $_POST['id'] ?? null;
    $taskId = $_POST['task_id'] ?? null;
    $content = trim($_POST['content'] ?? '');

    if (!$commentId || !$taskId || $content === '') {
        die("Thiếu dữ liệu.");
    }

    $comment = $this->taskModel->getCommentById($commentId);
    if (!$comment) {
        die("Không tìm thấy bình luận.");
    }

    $userId = $_SESSION['user']['id'] ?? null;
    $isOwner = $userId && $userId == $comment['user_id'];
    $isAdmin = $_SESSION['user']['role'] === 'admin';

    if (!$isOwner && !$isAdmin) {
        die("Bạn không có quyền sửa bình luận này.");
    }

    $this->taskModel->updateComment($commentId, $content);
    header("Location: index.php?controller=department_task&action=view&id=$taskId");
    exit;
}


// Xoá bình luận
public function delete_comment() {
    $commentId = $_GET['id'] ?? null;
    $taskId = $_GET['task_id'] ?? null;

    if (!$commentId || !$taskId) {
        die("Thiếu dữ liệu.");
    }

    $comment = $this->taskModel->getCommentById($commentId);
    if (!$comment) {
        die("Không tìm thấy bình luận.");
    }

    // Kiểm tra quyền
    $userId = $_SESSION['user']['id'] ?? null;
    $isOwner = $userId && $userId == $comment['user_id'];
    $isAdmin = $_SESSION['user']['role'] === 'admin';

    if (!$isOwner && !$isAdmin) {
        die("Bạn không có quyền xoá bình luận này.");
    }

    $this->taskModel->deleteComment($commentId);
    header("Location: index.php?controller=department_task&action=view&id=$taskId");
    exit;
}

public function cancel()
{
    $this->requireAdmin();

    $id = $_GET['id'] ?? null;
    if (!$id) die("Thiếu ID công việc");

    // Cập nhật trạng thái task chính
    $stmt = $this->db->prepare("UPDATE department_tasks SET status = 'cancelled' WHERE id = ?");
    $stmt->execute([$id]);

    // Cập nhật trạng thái tất cả các công việc nhỏ
    $stmt = $this->db->prepare("UPDATE department_subtasks SET status = 'cancelled' WHERE task_id = ?");
    $stmt->execute([$id]);

    $_SESSION['success'] = "Đã hủy công việc và các công việc nhỏ liên quan.";
    header("Location: index.php?controller=department_task&action=view&id=$id");
}




// private function requireLogin() {
//     if (empty($_SESSION['user'])) {
//         $_SESSION['error'] = 'Bạn cần đăng nhập.';
//         header('Location: index.php?controller=auth&action=login');
//         exit;
//     }
// }

// private function requireAdmin() {
//     $this->requireLogin();
//     if ($_SESSION['user']['role'] !== 'admin') {
//         $_SESSION['error'] = 'Bạn không có quyền truy cập.';
//         header('Location: index.php?controller=dashboard');
//         exit;
//     }
// }

// private function requireManagerOrAdmin() {
//     $this->requireLogin();
//     $role = $_SESSION['user']['role'] ?? '';
//     if (!in_array($role, ['admin', 'manager'])) {
//         $_SESSION['error'] = 'Chức năng chỉ dành cho quản lý hoặc admin.';
//         header('Location: index.php?controller=dashboard');
//         exit;
//     }
// }





}
