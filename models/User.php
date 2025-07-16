<?php
// models/User.php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Không trả lại mật khẩu
            return $user;
        }

        return false;
    }

 
    public function getAll() {
        $sql = "SELECT users.*, departments.name AS department_name
                FROM users
                LEFT JOIN departments ON users.department_id = departments.id
                ORDER BY users.id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO users (username, password, full_name, email, department_id, position, role)
            VALUES (:username, :password, :full_name, :email, :department_id, :position, :role)
        ");

        return $stmt->execute([
            ':username'      => $data['username'],
            ':password'      => password_hash($data['password'], PASSWORD_DEFAULT),
            ':full_name'     => $data['full_name'],
            ':email'         => $data['email'],
            ':department_id' => $data['department_id'],
            ':position'      => $data['position'],
            ':role'          => $data['role'],
        ]);
    }


public function getById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getManagers() {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE role = 'manager'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

  
public function update($data) {
        $sql = "UPDATE users SET 
                    username = :username,
                    full_name = :full_name,
                    email = :email,
                    department_id = :department_id,
                    position = :position,
                    role = :role";

        if (!empty($data['password'])) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $params = [
            ':username'      => $data['username'],
            ':full_name'     => $data['full_name'],
            ':email'         => $data['email'],
            ':department_id' => $data['department_id'],
            ':position'      => $data['position'],
            ':role'          => $data['role'],
            ':id'            => $data['id'],
        ];

        if (!empty($data['password'])) {
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $stmt->execute($params);
    }

   public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }



public function getByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
public function getByRole($role) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE role = ?");
    $stmt->execute([$role]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getDepartmentsByUserIds(array $userIds): array {
    if (empty($userIds)) return [];

    $placeholders = implode(',', array_fill(0, count($userIds), '?'));
    $stmt = $this->conn->prepare("SELECT DISTINCT department_id FROM users WHERE id IN ($placeholders)");
    $stmt->execute($userIds);
    $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $rows; // mảng các department_id
}


}
