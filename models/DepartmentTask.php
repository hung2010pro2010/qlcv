<?php
class DepartmentTask {
    private $conn;
 
    public function __construct($db) {
        $this->conn = $db;
    } 

/**
 * Lấy danh sách task; nếu $categoryId != null sẽ lọc theo danh mục
 */
public function getAll(?int $categoryId = null, ?int $userId = null, bool $isAdmin = false): array
{
    /* ==== base select ==== */
    $sql = "
        SELECT dt.id, dt.code, dt.title,
               dt.start_time, dt.end_time, dt.status, dt.created_at,
               CONCAT_WS('; ', u.full_name,
                         GROUP_CONCAT(DISTINCT r2.full_name SEPARATOR '; ')
               ) AS all_responsibles,
               GROUP_CONCAT(DISTINCT ds.title SEPARATOR '; ') AS subtask_names,
               COUNT(DISTINCT ds.id)                          AS subtask_count
        FROM department_tasks dt
        LEFT JOIN users u  ON u.id = dt.assigned_by
        LEFT JOIN department_task_responsibles r  ON r.department_task_id = dt.id
        LEFT JOIN users r2 ON r2.id = r.user_id AND r2.id <> dt.assigned_by
        LEFT JOIN department_task_related_users ru ON ru.department_task_id = dt.id
        LEFT JOIN department_subtasks ds ON ds.task_id = dt.id
        LEFT JOIN department_subtask_followers sf ON sf.subtask_id = ds.id
    ";

    /* ==== điều kiện lọc ==== */
    $conds  = [];
    $params = [];

    /* by category */
    if ($categoryId !== null) {
        $conds[]          = "dt.category_id = :cat";
        $params[':cat']   = $categoryId;
    }

    if (!$isAdmin && $userId) {
        $conds[] = "
            (
                dt.created_by     = :uid OR
                dt.assigned_by    = :uid OR
                r.user_id         = :uid OR
                ru.user_id        = :uid OR
                ds.assignee_id    = :uid OR
                sf.user_id        = :uid
            )
        ";
        $params[':uid'] = $userId;
    }

    if ($conds) {
        $sql .= " WHERE " . implode(' AND ', $conds);
    }

    $sql .= " GROUP BY dt.id ORDER BY dt.created_at DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getById($id) {
    $sql = "
        SELECT 
            dt.*, 
            d.name AS department_name
        FROM department_tasks dt
        LEFT JOIN departments d ON dt.department_id = d.id
        WHERE dt.id = ?
        LIMIT 1
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getAllForDropdown() {
    $sql = "
        SELECT id, code, title
        FROM department_tasks
        ORDER BY created_at DESC
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO department_tasks (code, title, description, from_department_id, to_department_id, category_id, created_by, assigned_by, start_time, end_time, status) VALUES (:code, :title, :description, :from_department_id, :to_department_id, :category_id, :created_by, :assigned_by, :start_time, :end_time, :status)");
        $stmt->execute([
            ':code' => $data['code'],
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':from_department_id' => $data['from_department_id'] ?? null,
            ':to_department_id' => $data['to_department_id'] ?? null,
            ':category_id' => $data['category_id'],
            ':created_by' => $data['created_by'],
            ':assigned_by' => $data['assigned_by'],
            ':start_time' => $data['start_time'],
            ':end_time' => $data['end_time'],
            ':status' => $data['status']
        ]);
        return $this->conn->lastInsertId();
    }

public function addAssignee($taskId, $userId) {
    $stmt = $this->conn->prepare("INSERT INTO department_task_assignees (task_id, user_id) VALUES (?, ?)");
    return $stmt->execute([$taskId, $userId]);
}

public function addFollower($taskId, $userId) {
    $stmt = $this->conn->prepare("INSERT INTO department_task_followers (task_id, user_id) VALUES (?, ?)");
    return $stmt->execute([$taskId, $userId]);
}

public function update($id, $data) {
    // Sửa dòng này:
    if (empty($data['assigned_by']) || !is_numeric($data['assigned_by'])) {
        throw new Exception("Người giao việc không hợp lệ.");
    }

    $sql = "UPDATE department_tasks SET 
                title = :title,
                description = :description,
                category_id = :category_id,
                start_time = :start_time,
                end_time = :end_time,
                status = :status,
                assigned_by = :assigned_by
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        ':title' => $data['title'] ?? '',
        ':description' => $data['description'] ?? '',
        ':category_id' => $data['category_id'] ?? null,
        ':start_time' => $data['start_time'] ?? null,
        ':end_time' => $data['end_time'] ?? null,
        ':status' => $data['status'] ?? 'pending',
        ':assigned_by' => $data['assigned_by'],
        ':id' => $id
    ]);
}


    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM department_tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }


    // Người chịu trách nhiệm
    public function addResponsible($taskId, $userId) {
        $stmt = $this->conn->prepare("INSERT INTO department_task_responsibles (department_task_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$taskId, $userId]);
    }

    public function getResponsibles($taskId) {
        $stmt = $this->conn->prepare("
            SELECT u.* FROM users u
            JOIN department_task_responsibles r ON r.user_id = u.id
            WHERE r.department_task_id = ?
        ");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateResponsibles($taskId, $userIds) {
        $this->conn->prepare("DELETE FROM department_task_responsibles WHERE department_task_id = ?")->execute([$taskId]);
        $stmt = $this->conn->prepare("INSERT INTO department_task_responsibles (department_task_id, user_id) VALUES (?, ?)");
        foreach ($userIds as $userId) {
            $stmt->execute([$taskId, $userId]);
        }
    }

    // Người liên quan
    public function addRelated($taskId, $userId) {
        $stmt = $this->conn->prepare("INSERT INTO department_task_related_users (department_task_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$taskId, $userId]);
    }

    public function getRelatedUsers($taskId) {
        $stmt = $this->conn->prepare("
            SELECT u.* FROM users u
            JOIN department_task_related_users r ON r.user_id = u.id
            WHERE r.department_task_id = ?
        ");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRelatedUsers($taskId, $userIds) {
        $this->conn->prepare("DELETE FROM department_task_related_users WHERE department_task_id = ?")->execute([$taskId]);
        $stmt = $this->conn->prepare("INSERT INTO department_task_related_users (department_task_id, user_id) VALUES (?, ?)");
        foreach ($userIds as $userId) {
            $stmt->execute([$taskId, $userId]);
        }
    }


    public function addSubtask($taskId, $data) {
    $stmt = $this->conn->prepare("
        INSERT INTO department_subtasks (task_id, title, assignee_id)
        VALUES (:task_id, :title, :assignee_id)
    ");

    return $stmt->execute([
        ':task_id'     => $taskId,
        ':title'       => $data['title'],
        ':assignee_id' => $data['assignee_id']
    ]);
}
public function addSubtaskFollower($subtaskId, $userId) {
    $stmt = $this->conn->prepare("INSERT INTO department_subtask_followers (subtask_id, user_id) VALUES (?, ?)");
    return $stmt->execute([$subtaskId, $userId]);
}


public function getSubtasks($taskId) {
    $stmt = $this->conn->prepare("
        SELECT ds.*, u.full_name AS assignee_name
        FROM department_subtasks ds
        LEFT JOIN users u ON ds.assignee_id = u.id
        WHERE ds.task_id = ?
    ");
    $stmt->execute([$taskId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getSubtaskFollowers($subtaskId) {
    $stmt = $this->conn->prepare("
        SELECT u.*
        FROM department_subtask_followers f
        JOIN users u ON f.user_id = u.id
        WHERE f.subtask_id = ?
    ");
    $stmt->execute([$subtaskId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getDetailById($id) {
    $stmt = $this->conn->prepare("
        SELECT 
            dt.*,
            d1.name AS from_department_name,
            d2.name AS to_department_name,
            c.name AS category_name,
            u1.full_name AS created_by_name,
            u2.full_name AS main_responsible_name,
            u2.id AS main_responsible_id
        FROM department_tasks dt
        LEFT JOIN departments d1 ON dt.from_department_id = d1.id
        LEFT JOIN departments d2 ON dt.to_department_id = d2.id
        LEFT JOIN department_task_categories c ON dt.category_id = c.id
        LEFT JOIN users u1 ON dt.created_by = u1.id
        LEFT JOIN users u2 ON dt.assigned_by = u2.id
        WHERE dt.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Xoá toàn bộ công việc nhỏ + người theo dõi công việc nhỏ
public function deleteAllSubtasks($taskId)
{
    // Lấy danh sách tất cả các subtask thuộc task này
    $stmt = $this->conn->prepare("SELECT id FROM department_subtasks WHERE task_id = ?");
    $stmt->execute([$taskId]);
    $subtasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subtasks as $sub) {
        $subId = $sub['id'];

        // Xoá dữ liệu liên quan trước
        $this->conn->prepare("DELETE FROM department_subtask_followers WHERE subtask_id = ?")->execute([$subId]);
        $this->conn->prepare("DELETE FROM department_subtask_comments WHERE subtask_id = ?")->execute([$subId]);
        $this->conn->prepare("DELETE FROM department_subtask_reports  WHERE subtask_id = ?")->execute([$subId]);

        // Cuối cùng xoá subtask
        $this->conn->prepare("DELETE FROM department_subtasks WHERE id = ?")->execute([$subId]);
    }
}


// Xoá người phụ trách
public function deleteAllResponsibles($taskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_task_responsibles WHERE department_task_id = ?");
    $stmt->execute([$taskId]);
}

// Xoá người liên quan
public function deleteAllRelatedUsers($taskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_task_related_users WHERE department_task_id = ?");
    $stmt->execute([$taskId]);
}
public function deleteSubtaskFollowers($subtaskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_subtask_followers WHERE subtask_id = ?");
    return $stmt->execute([$subtaskId]);
}
// Lấy báo cáo của từng subtask
    public function getSubtaskReports($taskId) {
        $sql = "SELECT r.*, u.full_name FROM department_subtask_reports r JOIN users u ON r.user_id = u.id JOIN department_subtasks s ON s.id = r.subtask_id WHERE s.task_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$taskId]);
        $reports = [];
        while ($row = $stmt->fetch()) {
            $reports[$row['subtask_id']][] = $row;
        }
        return $reports;
    }

  public function submitSubtaskReport($subtaskId, $userId, $content, $createdAt, $attachment = null) {
        $stmt = $this->conn->prepare("INSERT INTO department_subtask_reports (subtask_id, user_id, content, created_at, attachment) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$subtaskId, $userId, $content, $createdAt, $attachment]);
    }


    public function getSubtaskReportsWithUserNames() {
        $stmt = $this->conn->prepare("SELECT r.*, u.full_name AS reporter_name FROM department_subtask_reports r LEFT JOIN users u ON r.user_id = u.id");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach ($rows as $row) {
            // $results[$row['subtask_id']] = $row;
            $results[$row['subtask_id']][] = $row;

        }
        return $results;
    }


public function deleteSubtaskReport($id) {
    $stmt = $this->conn->prepare("DELETE FROM department_subtask_reports WHERE id = ?");
    return $stmt->execute([$id]);
}


public function updateSubtaskReportStatus($reportId, $status) {
    $sql = "UPDATE department_subtask_reports SET status = :status WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        ':status' => $status,
        ':id' => $reportId
    ]);
}


public function approveSubtaskReport($id) {
    return $this->updateSubtaskReportStatus($id, 'approved');
}

public function rejectSubtaskReport($id) {
    return $this->updateSubtaskReportStatus($id, 'rejected');
}

public function getAllReportStatusesByTaskId($taskId) {
    $sql = "SELECT r.status
            FROM department_subtask_reports r
            INNER JOIN department_subtasks s ON r.subtask_id = s.id
            WHERE s.task_id = :task_id";  // ✅ sửa ở đây
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['task_id' => $taskId]);
    return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'status');
}


// Lấy comment của từng subtask
public function getCommentsBySubtask($subtaskId) {
    $stmt = $this->conn->prepare("
        SELECT c.*, u.full_name
        FROM department_subtask_comments c
        JOIN users u ON c.user_id = u.id
        WHERE c.subtask_id = ?
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$subtaskId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function addCommentToSubtask($subtaskId, $userId, $content, $createdAt) {
    $stmt = $this->conn->prepare("
        INSERT INTO department_subtask_comments (subtask_id, user_id, content, created_at)
        VALUES (?, ?, ?, ?)
    ");
    return $stmt->execute([$subtaskId, $userId, $content, $createdAt]);
}

// Lấy 1 bình luận theo ID
public function getCommentById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM department_subtask_comments WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Xoá bình luận
public function deleteComment($id) {
    $stmt = $this->conn->prepare("DELETE FROM department_subtask_comments WHERE id = ?");
    return $stmt->execute([$id]);
}

// Cập nhật bình luận
public function updateComment($id, $content) {
    $stmt = $this->conn->prepare("UPDATE department_subtask_comments SET content = ? WHERE id = ?");
    return $stmt->execute([$content, $id]);
}

public function updateReportContent($id, $content)
{
    $stmt = $this->conn->prepare("UPDATE department_subtask_reports SET content = ? WHERE id = ?");
    return $stmt->execute([$content, $id]);
}


public function getSubtaskReportById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM department_subtask_reports WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateSubtaskReport($id, $content, $attachment) {
    $stmt = $this->conn->prepare("UPDATE department_subtask_reports SET content = ?, attachment = ? WHERE id = ?");
    return $stmt->execute([$content, $attachment, $id]);
}

// public function getTaskIdBySubtaskId($subtaskId) {
//     $stmt = $this->conn->prepare("SELECT task_id FROM department_subtasks WHERE id = ?");
//     $stmt->execute([$subtaskId]);
//     return $stmt->fetchColumn(); // chỉ lấy 1 giá trị
// }

public function updateSubtask($id, $data) {
    $sql = "UPDATE department_subtasks SET title = :title, assignee_id = :assignee_id WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        ':title' => $data['title'],
        ':assignee_id' => $data['assignee_id'],
        ':id' => $id
    ]);
}



public function addRelatedDepartment($taskId, $departmentId) {
    $stmt = $this->conn->prepare("INSERT INTO department_task_related_departments (task_id, department_id) VALUES (:task_id, :department_id)");
    return $stmt->execute([
        ':task_id' => $taskId,
        ':department_id' => $departmentId
    ]);
}
public function getRelatedDepartmentIds($taskId) {
    $stmt = $this->conn->prepare("SELECT department_id FROM department_task_related_departments WHERE task_id = ?");
    $stmt->execute([$taskId]);
    return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'department_id');
}

public function deleteRelatedDepartments($taskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_task_related_departments WHERE task_id = ?");
    $stmt->execute([$taskId]);
}

public function deleteSubtaskReports($subtaskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_subtask_reports WHERE subtask_id = ?");
    $stmt->execute([$subtaskId]);
}

public function deleteSubtaskComments($subtaskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_subtask_comments WHERE subtask_id = ?");
    $stmt->execute([$subtaskId]);
}
public function deleteSubtask($subtaskId) {
    $stmt = $this->conn->prepare("DELETE FROM department_subtasks WHERE id = ?");
    $stmt->execute([$subtaskId]);
}

public function updateTaskStatusIfCompleted($taskId) {
    // Tổng số subtask
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM department_subtasks WHERE task_id = ?");
    $stmt->execute([$taskId]);
    $total = $stmt->fetchColumn();

    // Tổng số subtask có ít nhất 1 báo cáo
    $stmt = $this->conn->prepare("
        SELECT COUNT(DISTINCT s.id)
        FROM department_subtasks s
        JOIN department_subtask_reports r ON r.subtask_id = s.id
        WHERE s.task_id = ?
    ");
    $stmt->execute([$taskId]);
    $reported = $stmt->fetchColumn();

    // Số subtask có báo cáo bị từ chối
    $stmt = $this->conn->prepare("
        SELECT COUNT(DISTINCT s.id)
        FROM department_subtasks s
        JOIN department_subtask_reports r ON r.subtask_id = s.id
        WHERE s.task_id = ? AND r.status = 'rejected'
    ");
    $stmt->execute([$taskId]);
    $rejected = $stmt->fetchColumn();

    // Số subtask có báo cáo được duyệt
    $stmt = $this->conn->prepare("
        SELECT COUNT(DISTINCT s.id)
        FROM department_subtasks s
        JOIN department_subtask_reports r ON r.subtask_id = s.id
        WHERE s.task_id = ? AND r.status = 'approved'
    ");
    $stmt->execute([$taskId]);
    $approved = $stmt->fetchColumn();

    // Quy tắc cập nhật trạng thái
    if ($rejected > 0) {
        $status = 'rejected';
    } elseif ($total > 0 && $total == $approved) {
        $status = 'completed';
    } elseif ($reported > 0) {
        $status = 'in_progress';
    } else {
        $status = 'pending';
    }

    // Cập nhật
    $stmt = $this->conn->prepare("UPDATE department_tasks SET status = ? WHERE id = ?");
    $stmt->execute([$status, $taskId]);
}


public function getReportById($reportId) {
    $stmt = $this->conn->prepare("SELECT * FROM department_subtask_reports WHERE id = ?");
    $stmt->execute([$reportId]);
    return $stmt->fetch();
}

public function getTaskIdBySubtask($subtaskId) {
    $stmt = $this->conn->prepare("SELECT task_id FROM department_subtasks WHERE id = ?");
    $stmt->execute([$subtaskId]);
    return $stmt->fetchColumn();
}

public function cancelTask($id) {
    $stmt = $this->conn->prepare("UPDATE department_tasks SET status = 'cancelled' WHERE id = ?");
    $stmt->execute([$id]);
}

public function updateStatus($taskId, $status) {
    $stmt = $this->conn->prepare("UPDATE department_tasks SET status = ? WHERE id = ?");
    $stmt->execute([$status, $taskId]);
}

public function syncTaskStatus($taskId) {
    $statusList = $this->getAllReportStatusesByTaskId($taskId);
    if (empty($statusList)) {
        $newStatus = 'pending';
    } elseif (in_array('rejected', $statusList)) {
        $newStatus = 'rejected';
    } elseif (in_array('pending', $statusList)) {
        $newStatus = 'in_progress';
    } else {
        $newStatus = 'approved';
    }

    // Cập nhật nếu cần
    $stmt = $this->conn->prepare("SELECT status FROM department_tasks WHERE id = ?");
    $stmt->execute([$taskId]);
    $currentStatus = $stmt->fetchColumn();
    if ($newStatus !== $currentStatus) {
        $this->updateStatus($taskId, $newStatus);
    }

    return $newStatus;
} 
public function getSubtaskIdsByTaskId($taskId) {
    $stmt = $this->conn->prepare("SELECT id FROM department_subtasks WHERE task_id = ?");
    $stmt->execute([$taskId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function getReportsBySubtask($subtaskId) {
    $stmt = $this->conn->prepare("SELECT status, user_id FROM department_subtask_reports WHERE subtask_id = ?");
    $stmt->execute([$subtaskId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Sinh mã tự động dạng GV001, GV002…
 * @return string
 */
public function generateCode(): string
{
    // Lấy 3 chữ số cuối lớn nhất
    $stmt = $this->conn->query("
        SELECT MAX(CAST(SUBSTRING(code, 3) AS UNSIGNED)) AS max_no
        FROM department_tasks
        WHERE code LIKE 'GV%'");
    $max = (int) $stmt->fetchColumn();
    $next = $max + 1;

    return 'GV' . str_pad($next, 3, '0', STR_PAD_LEFT); // GV001
}


public function getRelatedTasksForUser($userId) {
    $sql = "
        SELECT DISTINCT dt.id, dt.code, dt.title
        FROM department_tasks dt
        LEFT JOIN department_task_responsibles r ON dt.id = r.department_task_id
        LEFT JOIN department_task_related_users u ON dt.id = u.department_task_id
        LEFT JOIN department_task_followers f ON dt.id = f.task_id
        WHERE r.user_id = :uid OR u.user_id = :uid OR f.user_id = :uid
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['uid' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTitleById($id) {
    $stmt = $this->conn->prepare("SELECT title FROM department_tasks WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['title'] : null;
}


}
