<?php
require_once __DIR__ . '../../Config/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->connect();
    }

    public function getUserById($userId) {
        $query = "SELECT id, nombre_usuario, correo, telefono, nombre, apellido, fecha_nacimiento, dni, estado FROM usuarios WHERE id = :id";
        return Database::getInstance()->select($query, [':id' => $userId])[0] ?? null;
    }

    public function updateUser($userId, $data) {
        $query = "UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono,  dni = :dni WHERE id = :id";
        return Database::getInstance()->update($query, [
            ':id' => $userId,
            ':nombre' => $data['nombre'],
            ':correo' => $data['correo'],
            ':telefono' => $data['telefono'],
            ':dni' => $data['dni']
        ]);
    }
    
}
