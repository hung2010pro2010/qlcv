<?php
require_once 'config/db.php';

$db = (new DB())->connect();
$password = password_hash('123456', PASSWORD_BCRYPT);

$stmt = $db->prepare("INSERT INTO users (username, password, full_name, department, position, email, role)
                      VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->execute([
    'admin',
    $password,
    'Quản trị viên',
    'Phòng CNTT',
    'Admin hệ thống',
    'admin@example.com',
    'admin'
]);

echo "Tạo user demo thành công!";
