<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'markdown2video';
    private $username = 'root';
    private $password = '';
    private $port = '3306';
    private $conn = null;

    public function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
            return $this->conn;
        } catch(PDOException $e) {
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }

    public function disconnect() {
        $this->conn = null;
    }

    // Método para obtener una instancia de conexión
    public static function getInstance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }

    // Método para realizar consultas preparadas SELECT
    public function select($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    // Método para realizar consultas INSERT
    public function insert($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $this->conn->lastInsertId();
        } catch(PDOException $e) {
            throw new Exception("Error al insertar: " . $e->getMessage());
        }
    }

    // Método para realizar consultas UPDATE
    public function update($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            throw new Exception("Error al actualizar: " . $e->getMessage());
        }
    }

    // Método para realizar consultas DELETE
    public function delete($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            throw new Exception("Error al eliminar: " . $e->getMessage());
        }
    }

    // Método para iniciar una transacción
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    // Método para confirmar una transacción
    public function commit() {
        return $this->conn->commit();
    }

    // Método para revertir una transacción
    public function rollback() {
        return $this->conn->rollBack();
    }
}