<?php
require_once '../app/core/Database.php';

class Model {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::pdo();
    }

    // Ejecutar consultas genéricas (INSERT, UPDATE, DELETE)
    public function query(string $sql, array $params = []): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Obtener múltiples registros
    public function getAll(string $sql, array $params = []): array {
        return $this->query($sql, $params)->fetchAll();
    }

    // Obtener un solo registro (por ID, email, etc.)
    public function getOne(string $sql, array $params = []) {
        $result = $this->query($sql, $params)->fetch();
        return $result ?: null;
    }

    // Obtener el último ID insertado (muy útil para los AUTO_INCREMENT)
    public function getLastInsertId(): string {
        return $this->db->lastInsertId();
    }
}