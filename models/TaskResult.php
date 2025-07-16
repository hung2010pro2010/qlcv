<?php
class TaskResult {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($taskId, $description, $result_link) {
        $stmt = $this->db->prepare("INSERT INTO task_results (task_id, description, result_link) VALUES (?, ?, ?)");
        return $stmt->execute([$taskId, $description, $result_link]);
    }

    public function deleteByTaskId($taskId) {
        $stmt = $this->db->prepare("DELETE FROM task_results WHERE task_id = ?");
        return $stmt->execute([$taskId]);
    }

    public function getByTaskId($taskId) {
        $stmt = $this->db->prepare("SELECT * FROM task_results WHERE task_id = ?");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function updateResults($taskId, $descriptions, $links) {
    // Xóa toàn bộ kết quả cũ
    $stmt = $this->db->prepare("DELETE FROM task_results WHERE task_id = ?");
    $stmt->execute([$taskId]);

    // Thêm mới lại toàn bộ
    foreach ($descriptions as $i => $desc) {
        $link = $links[$i] ?? '';
        if (trim($desc) !== '' || trim($link) !== '') {
            $this->add($taskId, $desc, $link);
        }
    }
}

}
