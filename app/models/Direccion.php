<?php

require_once __DIR__ . '/../config/database.php';

class Direccion {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Obtener direcciones del usuario
    public function obtenerPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM direcciones WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nueva dirección
    public function crear($id_usuario, $direccion, $ciudad, $provincia, $codigo) {
        $stmt = $this->db->prepare("
            INSERT INTO direcciones (id_usuario, direccion, ciudad, provincia, codigo_postal)
            VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([$id_usuario, $direccion, $ciudad, $provincia, $codigo]);
    }
}
