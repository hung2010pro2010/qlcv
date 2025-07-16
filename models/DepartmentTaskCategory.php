<?php
class DepartmentTaskCategory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy tất cả danh mục
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM department_task_categories ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục theo ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM department_task_categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới danh mục
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO department_task_categories (name, description) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['description']]);
    }

    // Cập nhật danh mục
    public function update($id, $name, $description) {
        $stmt = $this->db->prepare("UPDATE department_task_categories SET name = :name, description = :description WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description
        ]);
    }

    // Xóa danh mục
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM department_task_categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
