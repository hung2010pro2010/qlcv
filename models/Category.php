<?php
class Category {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT c.*, p.name as project_group_name 
            FROM categories c
            JOIN project_groups p ON c.project_group_id = p.id
            ORDER BY c.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO categories (project_group_id, name, description) VALUES (?, ?, ?)");
        $stmt->execute([$data['project_group_id'], $data['name'], $data['description']]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE categories SET project_group_id = ?, name = ?, description = ? WHERE id = ?");
        $stmt->execute([$data['project_group_id'], $data['name'], $data['description'], $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    }
}
