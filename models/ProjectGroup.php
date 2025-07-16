<?php
//Models/ProjectGroup.php
class ProjectGroup {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM project_groups ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM project_groups WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO project_groups (name, description) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['description']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE project_groups SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['description'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM project_groups WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getGroupsByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT pg.*
            FROM project_groups pg
            JOIN tasks t ON t.project_group = pg.id
            WHERE t.assigned_to = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGroupsBySupervisor($userId) {
        $sql = "SELECT DISTINCT pg.*
                FROM project_groups pg
                JOIN tasks t ON t.project_group = pg.id
                JOIN task_supervisors ts ON ts.task_id = t.id
                WHERE ts.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
