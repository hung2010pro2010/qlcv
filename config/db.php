<?php

class DB {
    private $host = 'localhost';
    private $dbname = 'web5';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        if ($this->conn == null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Kết nối database thất bại: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
