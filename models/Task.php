<?php
//Models/task.php
class Task {
    private $db;
    private $conn;

    public function __construct($db) {
        $this->db = $db;
        $this->conn = $db;
    }
 
 
// Đếm số lượng công việc theo bộ lọc
 public function countFiltered($filters = []) {
    $sql = "SELECT COUNT(DISTINCT t.id) AS total
            FROM tasks t
            LEFT JOIN task_supervisors ts ON ts.task_id = t.id
            LEFT JOIN task_responsible tr ON tr.task_id = t.id
            WHERE 1=1";

    $params = [];

    if (!empty($filters['status'])) {
        $sql .= " AND t.task_status = :status";
        $params[':status'] = $filters['status'];
    }

    // ✅ Di chuyển đoạn này lên đây
    if (!empty($filters['exclude_status'])) {
        $sql .= " AND t.task_status != :exclude_status";
        $params[':exclude_status'] = $filters['exclude_status'];
    }

    if (!empty($filters['priority'])) {
        $sql .= " AND t.priority = :priority";
        $params[':priority'] = $filters['priority'];
    }

    if (!empty($filters['approval_status'])) {
        $sql .= " AND t.approval_status = :approval_status";
        $params[':approval_status'] = $filters['approval_status'];
    }

    if (!empty($filters['responsible_person'])) {
        $sql .= " AND ts.user_id = :responsible_person";
        $params[':responsible_person'] = $filters['responsible_person'];
    }

    if (!empty($filters['related_to_user'])) {
        $userId = $filters['related_to_user']['user_id'];
        $responsibleTaskIds = $filters['related_to_user']['responsible_task_ids'];

        $sql .= " AND (
            t.created_by = :user_id 
            OR t.assigned_to = :user_id 
            OR ts.user_id = :user_id 
            OR tr.user_id = :user_id";

        if (!empty($responsibleTaskIds)) {
            $placeholders = [];
            foreach ($responsibleTaskIds as $i => $taskId) {
                $ph = ":task_id_$i";
                $placeholders[] = $ph;
                $params[$ph] = $taskId;
            }
            $sql .= " OR t.id IN (" . implode(',', $placeholders) . ")";
        }

        $sql .= ")";
        $params[':user_id'] = $userId;
    }

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetchColumn();
}



    // Lấy danh sách công việc theo trang và bộ lọc
   public function getFilteredPaged($filters = [], $limit = 10, $offset = 0) {
   $sql = "SELECT 
                t.*, 
                pg.name AS project_group_name, 
                c.name AS category_name,
                u2.full_name AS creator_full_name,
                u3.full_name AS assigned_full_name,
                dt.code AS department_task_code,
                dt.title AS department_task_title,
                GROUP_CONCAT(DISTINCT ru.full_name ORDER BY ru.full_name ASC SEPARATOR ', ') AS responsible_usernames
            FROM tasks t
            LEFT JOIN project_groups pg ON pg.id = CAST(t.project_group AS UNSIGNED)
            LEFT JOIN categories c ON c.id = CAST(t.category AS UNSIGNED)
            LEFT JOIN users u2 ON u2.id = CAST(t.created_by AS UNSIGNED)
            LEFT JOIN users u3 ON u3.id = CAST(t.assigned_to AS UNSIGNED)
            LEFT JOIN task_supervisors ts ON ts.task_id = t.id
            LEFT JOIN task_responsible tr ON tr.task_id = t.id
            LEFT JOIN users ru ON ru.id = tr.user_id
            LEFT JOIN department_tasks dt ON dt.id = t.department_task_id
            WHERE 1=1";

    $params = [];

    if (!empty($filters['status'])) {
        $sql .= " AND t.task_status = :status";
        $params[':status'] = $filters['status'];
    }

    if (!empty($filters['exclude_status'])) {
    $sql .= " AND t.task_status != :exclude_status";
    $params[':exclude_status'] = $filters['exclude_status'];
}


    if (!empty($filters['priority'])) {
        $sql .= " AND t.priority = :priority";
        $params[':priority'] = $filters['priority'];
    }

    if (!empty($filters['approval_status'])) {
        $sql .= " AND t.approval_status = :approval_status";
        $params[':approval_status'] = $filters['approval_status'];
    }

    if (!empty($filters['responsible_person'])) {
        $sql .= " AND ts.user_id = :responsible_person";
        $params[':responsible_person'] = $filters['responsible_person'];
    }

    if (!empty($filters['related_to_user'])) {
        $userId = $filters['related_to_user']['user_id'];
        $responsibleTaskIds = $filters['related_to_user']['responsible_task_ids'];

        $sql .= " AND (
            t.created_by = :user_id 
            OR t.assigned_to = :user_id 
            OR ts.user_id = :user_id 
            OR tr.user_id = :user_id";

        if (!empty($responsibleTaskIds)) {
            $placeholders = [];
            foreach ($responsibleTaskIds as $i => $taskId) {
                $ph = ":task_id_$i";
                $placeholders[] = $ph;
                $params[$ph] = $taskId;
            }
            $sql .= " OR t.id IN (" . implode(',', $placeholders) . ")";
        }

        $sql .= ")";
        $params[':user_id'] = $userId;
    }

    
    $sql .= " GROUP BY t.id ORDER BY t.created_at DESC LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();



    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





public function getFiltered($filters = []) {
    $sql = "SELECT 
                tasks.*, 
                pg.name AS project_group_name, 
                c.name AS category_name,
                u1.username AS responsible_username,
                u2.full_name AS creator_full_name,
                u3.full_name AS assigned_full_name
            FROM tasks
            LEFT JOIN project_groups AS pg ON pg.id = CAST(tasks.project_group AS UNSIGNED)
            LEFT JOIN categories AS c ON c.id = CAST(tasks.category AS UNSIGNED)
            LEFT JOIN users AS u1 ON u1.id = CAST(tasks.responsible_person AS UNSIGNED)
            LEFT JOIN users AS u2 ON u2.id = CAST(tasks.created_by AS UNSIGNED)
            LEFT JOIN users AS u3 ON u3.id = CAST(tasks.assigned_to AS UNSIGNED)
            WHERE 1=1";

    $params = [];

    // ✅ Nếu lọc theo người phụ trách → lọc qua bảng task_supervisors
    if (!empty($filters['responsible_person'])) {
        $sql .= " AND EXISTS (
            SELECT 1 FROM task_supervisors ts
            WHERE ts.task_id = tasks.id AND ts.user_id = :responsible_person
        )";
        $params[':responsible_person'] = $filters['responsible_person'];
    }

    // ✅ Nếu KHÔNG lọc theo người phụ trách → lọc theo user thường (trừ admin)
    elseif (!empty($filters['current_user']) && !$filters['current_user']['is_admin']) {
        $userId = $filters['current_user']['id'];
        $taskIds = $filters['current_user']['supervisor_task_ids'] ?? [];

        $sql .= " AND (
            tasks.created_by = :user_id OR
            tasks.assigned_to = :user_id";

        $params[':user_id'] = $userId;

        if (!empty($taskIds)) {
            $placeholders = [];
            foreach ($taskIds as $i => $tid) {
                $ph = ":task_id_$i";
                $placeholders[] = $ph;
                $params[$ph] = $tid;
            }
            $sql .= " OR tasks.id IN (" . implode(',', $placeholders) . ")";
        }

        $sql .= ")";
    }

    // ✅ Các bộ lọc khác
    if (!empty($filters['status'])) {
        $sql .= " AND tasks.task_status = :status";
        $params[':status'] = $filters['status'];
    }

    if (!empty($filters['priority'])) {
        $sql .= " AND tasks.priority = :priority";
        $params[':priority'] = $filters['priority'];
    }

    if (!empty($filters['approval_status'])) {
        $sql .= " AND tasks.approval_status = :approval_status";
        $params[':approval_status'] = $filters['approval_status'];
    }

    if (!empty($filters['start_date_from'])) {
        $sql .= " AND tasks.start_date >= :start_date_from";
        $params[':start_date_from'] = $filters['start_date_from'];
    }

    if (!empty($filters['due_date_to'])) {
        $sql .= " AND tasks.due_date <= :due_date_to";
        $params[':due_date_to'] = $filters['due_date_to'];
    }

    if (!empty($filters['due_date_from'])) {
        $sql .= " AND tasks.due_date >= :due_date_from";
        $params[':due_date_from'] = $filters['due_date_from'];
    }

    if (!empty($filters['keyword'])) {
        $sql .= " AND tasks.detail LIKE :keyword";
        $params[':keyword'] = '%' . $filters['keyword'] . '%';
    }

    // ✅ Sắp xếp
    $sql .= " ORDER BY tasks.created_at DESC";

    // ✅ Thực thi
    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM tasks ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getById($id) {
    //     $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = ?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
    public function getById($id) {
    $stmt = $this->db->prepare("
        SELECT 
            t.*, 
            dt.code AS department_task_code,
            dt.title AS department_task_title
        FROM tasks t
        LEFT JOIN department_tasks dt ON dt.id = t.department_task_id
        WHERE t.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

 
    public function getByStatus($status) {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE task_status = ?");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// status_time
public function create($data) {
    $stmt = $this->db->prepare("
        INSERT INTO tasks (
            task_code, project_group, category, detail,
            requirements, priority, start_date, due_date,
            assigned_to, approval_status, task_status,
            status_time, attachment_path, created_by, approval_time,
            department_task_id
        ) VALUES (
            :task_code, :project_group, :category, :detail,
            :requirements, :priority, :start_date, :due_date,
            :assigned_to, :approval_status, :task_status,
            :status_time, :attachment_path, :created_by, :approval_time,
            :department_task_id
        )
    ");

    $stmt->execute([
        ':task_code'       => $data['task_code'],
        ':project_group'   => $data['project_group'],
        ':category'        => $data['category'],
        ':detail'          => $data['detail'],
        ':requirements'    => $data['requirements'],
        ':priority'        => $data['priority'],
        ':start_date'      => $data['start_date'],
        ':due_date'        => $data['due_date'],
        ':assigned_to'     => $data['assigned_to'],
        ':approval_status' => $data['approval_status'],
        ':task_status'     => $data['task_status'],
        ':status_time'     => $data['status_time'],
        ':attachment_path' => $data['attachment_path'],
        ':created_by'      => $data['created_by'],
        ':approval_time'   => $data['approval_time'],
        ':department_task_id' => $data['department_task_id']
    ]);

    return $this->db->lastInsertId();
}


public function update($data) {
    $sql = "UPDATE tasks SET
        task_code = ?, 
        project_group = ?, 
        category = ?,
        detail = ?,
        requirements = ?,
        priority = ?,
        start_date = ?, 
        due_date = ?, 
        assigned_to = ?,
        approval_status = ?,
        approval_time = ?,       
        task_status = ?,
        status_time = ?,           -- ✅ thêm dòng này
        attachment_path = ?,
        department_task_id = ?     -- ✅ thêm dòng này
        WHERE id = ?";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        $data['task_code'],
        $data['project_group'],
        $data['category'],
        $data['detail'],
        $data['requirements'],
        $data['priority'],
        $data['start_date'],
        $data['due_date'],
        $data['assigned_to'],
        $data['approval_status'],
        $data['approval_time'],
        $data['task_status'],
        $data['status_time'],         // ✅ bind thêm
        $data['attachment_path'],
        $data['department_task_id'],  // ✅ bind thêm
        $data['id']
    ]);
}



    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
    }



    public function getAllTasks($filters = []) {
    // $sql = "SELECT t.*, u1.name AS created_by, u2.name AS assigned_to
    //         FROM tasks t
    //         LEFT JOIN users u1 ON t.created_by = u1.id
    //         LEFT JOIN users u2 ON t.assigned_to = u2.id
    //         WHERE 1=1";
        $sql = "SELECT 
            t.*, 
            t.id AS task_id, 
            pg.name AS project_group_name,
            c.name AS category_name,
            u.full_name AS creator_full_name,
            GROUP_CONCAT(DISTINCT sup.full_name ORDER BY sup.full_name ASC SEPARATOR ', ') AS supervisor_names,
            GROUP_CONCAT(DISTINCT ru.full_name ORDER BY ru.full_name ASC SEPARATOR ', ') AS responsible_usernames
        FROM tasks t
        LEFT JOIN users u ON t.created_by = u.id
        LEFT JOIN project_groups pg ON t.project_group = pg.id
        LEFT JOIN categories c ON t.category = c.id
        LEFT JOIN task_supervisors ts ON ts.task_id = t.id
        LEFT JOIN users sup ON sup.id = ts.user_id
        LEFT JOIN task_responsible tr ON tr.task_id = t.id
        LEFT JOIN users ru ON ru.id = tr.user_id
        WHERE 1=1
";


    if (!empty($filters['status'])) {
        $sql .= " AND t.task_status = :status";
    }
    if (!empty($filters['priority'])) {
        $sql .= " AND t.priority = :priority";
    }
    if (!empty($filters['responsible_person'])) {
        $sql .= " AND EXISTS (
            SELECT 1 FROM task_supervisors ts 
            WHERE ts.task_id = t.id AND ts.user_id = :responsible_person
        )";
    }

    $stmt = $this->db->prepare($sql);
    if (!empty($filters['status'])) {
        $stmt->bindValue(':status', $filters['status']);
    }
    if (!empty($filters['priority'])) {
        $stmt->bindValue(':priority', $filters['priority']);
    }
    if (!empty($filters['responsible_person'])) {
        $stmt->bindValue(':responsible_person', $filters['responsible_person']);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getTasksByStatus($status)
        {
            $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE task_status = :status ORDER BY due_date DESC");
            $stmt->execute(['task_status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    // Khởi tạo mã công việc
      public function generateSequentialCode() {
            // Lấy ID lớn nhất hiện tại từ bảng tasks
            $stmt = $this->db->query("SELECT MAX(id) FROM tasks");
            $lastId = $stmt->fetchColumn();

            // Nếu chưa có task nào, bắt đầu từ 1
            $nextNumber = ($lastId !== null) ? ($lastId + 1) : 1;

            // Format lại mã: ví dụ TASK0001, TASK0002,...
            $code = 'TASK' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            return $code;
        }

// public function getByGroupId($groupId, $responsiblePersonId = null, $relatedUserId = null) {
//     $sql = "SELECT t.*, 
//                    pg.name AS project_group_name, 
//                    c.name AS category_name, 
//                    u.full_name AS creator_full_name, 
//                    a.full_name AS assigned_full_name,
//                    GROUP_CONCAT(DISTINCT r.full_name ORDER BY r.full_name SEPARATOR ', ') AS responsible_usernames
//             FROM tasks t
//             LEFT JOIN project_groups pg ON t.project_group = pg.id
//             LEFT JOIN categories c ON t.category = c.id
//             LEFT JOIN users u ON t.created_by = u.id
//             LEFT JOIN users a ON t.assigned_to = a.id
//             LEFT JOIN task_supervisors ts ON ts.task_id = t.id
//             LEFT JOIN users r ON ts.user_id = r.id
//             WHERE t.project_group = :group_id";

//     $params = ['group_id' => $groupId];

//     if ($responsiblePersonId !== null) {
//         $sql .= " AND ts.user_id = :responsible_person_id";
//         $params['responsible_person_id'] = $responsiblePersonId;
//     }

//     if ($relatedUserId !== null) {
//         $sql .= " AND (t.assigned_to = :related_user_id OR t.created_by = :related_user_id)";
//         $params['related_user_id'] = $relatedUserId;
//     }

//     $sql .= " GROUP BY t.id ORDER BY t.created_at DESC";

//     $stmt = $this->db->prepare($sql);
//     foreach ($params as $key => $value) {
//         $stmt->bindValue(":$key", $value, PDO::PARAM_INT);
//     }
//     $stmt->execute();

//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function getByGroupId($groupId, $responsiblePersonId = null, $relatedUserId = null) {
    $sql = "SELECT t.*, 
                   pg.name AS project_group_name, 
                   c.name AS category_name, 
                   u.full_name AS creator_full_name, 
                   a.full_name AS assigned_full_name,
                   GROUP_CONCAT(DISTINCT r.full_name ORDER BY r.full_name SEPARATOR ', ') AS supervisor_names
            FROM tasks t
            LEFT JOIN project_groups pg ON t.project_group = pg.id
            LEFT JOIN categories c ON t.category = c.id
            LEFT JOIN users u ON t.created_by = u.id
            LEFT JOIN users a ON t.assigned_to = a.id
            LEFT JOIN task_supervisors ts ON ts.task_id = t.id
            LEFT JOIN users r ON ts.user_id = r.id
            WHERE t.project_group = :group_id";

    $params = ['group_id' => $groupId];

    // Nếu lọc theo người chịu trách nhiệm
    if ($responsiblePersonId !== null) {
        $sql .= " AND ts.user_id = :responsible_person_id";
        $params['responsible_person_id'] = $responsiblePersonId;
    }

    // Nếu lọc theo người có liên quan (người giao hoặc tạo)
    if ($relatedUserId !== null) {
        $sql .= " AND (t.assigned_to = :related_user_id OR t.created_by = :related_user_id)";
        $params['related_user_id'] = $relatedUserId;
    }

    // Gom nhóm theo task ID và sắp xếp mới nhất
    // ✅ Sắp xếp: công việc chưa hoàn thành lên trước, đã hoàn thành xuống cuối
    $sql .= " GROUP BY t.id
              ORDER BY 
                CASE 
                    WHEN t.task_status = 'Đã hoàn thành' THEN 1 
                    ELSE 0 
                END,
                t.created_at DESC";

    $stmt = $this->db->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue(":$key", $value, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function getByGroupFilters($groupId, $filters = []) {
    $sql = "SELECT 
                t.*, 
                pg.name AS project_group_name, 
                c.name AS category_name, 
                u.full_name AS creator_full_name, 
                a.full_name AS assigned_full_name, 
                r.full_name AS responsible_username
            FROM tasks t
            LEFT JOIN project_groups pg ON t.project_group = pg.id
            LEFT JOIN categories c ON t.category = c.id
            LEFT JOIN users u ON t.created_by = u.id
            LEFT JOIN users a ON t.assigned_to = a.id
            LEFT JOIN task_supervisors ts ON ts.task_id = t.id
            LEFT JOIN users r ON ts.user_id = r.id
            WHERE t.project_group = :group_id";

    $params = [':group_id' => $groupId];

    if (!empty($filters['assigned_username'])) {
        $sql .= " AND a.username LIKE :assigned_username";
        $params[':assigned_username'] = '%' . $filters['assigned_username'] . '%';
    }

    if (!empty($filters['responsible_username'])) {
        $sql .= " AND r.username LIKE :responsible_username";
        $params[':responsible_username'] = '%' . $filters['responsible_username'] . '%';
    }

    $sql .= " ORDER BY t.created_at DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getTasksByGroupAndUser($groupId, $userId) {
    $sql = "SELECT t.*, p.name AS project_group_name, c.name AS category_name
            FROM tasks t
            LEFT JOIN project_groups p ON t.project_group = p.id
            LEFT JOIN categories c ON t.category = c.id
            LEFT JOIN task_supervisors ts ON ts.task_id = t.id
            WHERE t.project_group = :group_id
            AND (t.assigned_to = :user_id OR ts.user_id = :user_id)
            GROUP BY t.id
            ORDER BY t.created_at DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':group_id', $groupId, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getByGroupIdAndUser($groupId, $userId, $role = 'user') {
    $sql = "
        SELECT 
            t.*, 
            pg.name AS project_group_name,
            c.name AS category_name,
            MAX(creator.full_name) AS creator_full_name,
            MAX(assignee.full_name) AS assigned_full_name,
            GROUP_CONCAT(DISTINCT responsible.full_name SEPARATOR ', ') AS responsible_usernames
        FROM tasks t
        LEFT JOIN project_groups pg ON t.project_group = pg.id
        LEFT JOIN categories c ON t.category = c.id
        LEFT JOIN users creator ON t.created_by = creator.id
        LEFT JOIN users assignee ON t.assigned_to = assignee.id
        LEFT JOIN task_supervisors ts ON ts.task_id = t.id
        LEFT JOIN users responsible ON ts.user_id = responsible.id
        WHERE t.project_group = :groupId
    ";

    if ($role !== 'admin') {
        $sql .= "
            AND (
                t.created_by = :userId
                OR t.assigned_to = :userId
                OR ts.user_id = :userId
            )
        ";
    }

    // $sql .= " GROUP BY t.id";
    $sql .= " 
    GROUP BY t.id
    ORDER BY 
        CASE 
            WHEN t.task_status = 'Đã hoàn thành' THEN 1 
            ELSE 0 
        END,
        t.created_at DESC
";


    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':groupId', $groupId, PDO::PARAM_INT);
    if ($role !== 'admin') {
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function countNewTasksForGroupAndUser($groupId, $userId, $taskSupervisorModel) {
    // Nếu là admin → đếm toàn bộ task trong group đó
    $currentUser = $_SESSION['user'] ?? null;
    if ($currentUser && $currentUser['role'] === 'admin') {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tasks WHERE project_group = ?");
        $stmt->execute([$groupId]);
        return $stmt->fetchColumn();
    }

    // Với nhân viên → đếm task được giao (qua bảng task_supervisors)
    $taskIds = $taskSupervisorModel->getTaskIdsByUserId($userId);
    if (empty($taskIds)) {
        return 0;
    }

    $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
    $params = array_merge([$groupId], $taskIds);

    $sql = "SELECT COUNT(*) FROM tasks 
            WHERE project_group = ? 
              AND id IN ($placeholders)";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

public function countTasksForGroupAndUser($groupId, $userId) {
    $sql = "SELECT COUNT(DISTINCT t.id)
            FROM tasks t
            JOIN task_supervisors ts ON ts.task_id = t.id
            WHERE t.project_group = ?
              AND ts.user_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$groupId, $userId]);
    return $stmt->fetchColumn();
}


public function countNewTasksForUser($userId, $taskSupervisorModel) {
    $taskIds = $taskSupervisorModel->getTaskIdsByUserId($userId);
    $placeholders = implode(',', array_fill(0, count($taskIds), '?'));

    $sql = "SELECT COUNT(*) FROM tasks 
            WHERE task_status = 'Chưa nhận việc'
              AND (assigned_to = ?";

    $params = [$userId];

    if (!empty($taskIds)) {
        $sql .= " OR id IN ($placeholders)";
        $params = array_merge($params, $taskIds);
    }

    $sql .= ")";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

public function getAllUsers() {
    $sql = "SELECT id, full_name, username FROM users LIMIT 10";
    $stmt = $this->db->prepare($sql); 
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTasksByFilter(array $filters = []) {
    $sql = "
        SELECT 
            t.*, 
            creator.full_name AS creator_full_name,
            assignee.full_name AS assigned_full_name,
            pg.name AS project_group_name,
            c.name AS category_name,
            GROUP_CONCAT(DISTINCT sup.full_name SEPARATOR ', ') AS responsible_usernames
        FROM tasks t
        LEFT JOIN users creator ON t.created_by = creator.id
        LEFT JOIN users assignee ON t.assigned_to = assignee.id
        LEFT JOIN project_groups pg ON t.project_group = pg.id
        LEFT JOIN categories c ON t.category = c.id
        LEFT JOIN task_supervisors ts ON ts.task_id = t.id
        LEFT JOIN users sup ON ts.user_id = sup.id
        WHERE 1=1
    ";

    $params = [];

    if (!empty($filters['status'])) {
        $sql .= " AND t.task_status = :status";
        $params[':status'] = $filters['status'];
    }

    if (!empty($filters['priority'])) {
        $sql .= " AND t.priority = :priority";
        $params[':priority'] = $filters['priority'];
    }

    if (!empty($filters['approval_status'])) {
        $sql .= " AND t.approval_status = :approval_status";
        $params[':approval_status'] = $filters['approval_status'];
    }

    if (!empty($filters['responsible_person'])) {
        $sql .= " AND (t.assigned_to = :responsible_person OR ts.user_id = :responsible_person)";
        $params[':responsible_person'] = $filters['responsible_person'];
    }

    if (!empty($filters['related_to_user'])) {
        $userId = $filters['related_to_user']['user_id'];
        $supervisorTaskIds = $filters['related_to_user']['supervisor_task_ids'] ?? [];

        $sql .= " AND (
            t.created_by = :userId
            OR t.assigned_to = :userId
        ";

        if (!empty($supervisorTaskIds)) {
            $inClause = implode(',', array_map('intval', $supervisorTaskIds));
            $sql .= " OR t.id IN ($inClause)";
        }

        $sql .= ")";
        $params[':userId'] = $userId;
    }

    $sql .= "
        GROUP BY 
            t.id, t.task_code, t.created_at, t.detail, t.expected_result, t.requirements,
            t.result_link, t.priority, t.start_date, t.due_date, t.created_by, t.assigned_to, 
            t.category, t.project_group, t.task_status, t.approval_status,
            pg.name, c.name, creator.full_name, assignee.full_name
    ";

    $stmt = $this->connection->prepare($sql);
    foreach ($params as $key => &$value) {
        $stmt->bindParam($key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateTaskStatus($taskId, $status, $statusTime = null) {
    $statusTime = $statusTime ?? date('Y-m-d H:i:s');

    $stmt = $this->db->prepare("UPDATE tasks SET task_status = :status, status_time = :status_time WHERE id = :id");
    return $stmt->execute([
        ':status' => $status,
        ':status_time' => $statusTime,
        ':id' => $taskId
    ]);
}

public function getByAssignedUser($userId) {
    $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE assigned_to = :user_id ORDER BY created_at DESC");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getSupervisorIdsByTask($taskId) {
    $stmt = $this->db->prepare("SELECT user_id FROM task_supervisors WHERE task_id = ?");
    $stmt->execute([$taskId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function countTasksByGroupId($groupId) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM tasks WHERE project_group = ?");
    $stmt->execute([$groupId]);
    return $stmt->fetchColumn();
}
public function updateStatus($id, $status) {
    $stmt = $this->pdo->prepare("UPDATE tasks SET task_status = :status WHERE id = :id");
    return $stmt->execute([':status' => $status, ':id' => $id]);
}
public function getByGroupIdOrderedByNewest($groupId) {
    $stmt = $this->db->prepare("SELECT * FROM tasks WHERE project_group = :groupId ORDER BY created_at DESC");
    $stmt->execute(['groupId' => $groupId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getByGroupIdAndUserOrderedByNewest($groupId, $userId, $userRole) {
    $sql = "SELECT DISTINCT t.* FROM tasks t
            LEFT JOIN task_responsible r ON t.id = r.task_id
            LEFT JOIN task_supervisors s ON t.id = s.task_id
            WHERE t.project_group = :groupId AND (r.user_id = :userId OR s.user_id = :userId)
            ORDER BY t.created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'groupId' => $groupId,
        'userId' => $userId
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
