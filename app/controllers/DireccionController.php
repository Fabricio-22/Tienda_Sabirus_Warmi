<?php

require_once __DIR__ . '/../models/Direccion.php';

class DireccionController {

    private $direccionModel;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🔐 Validar sesión de usuario
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?controller=usuario&action=login");
            exit;
        }

        $this->direccionModel = new Direccion();
    }

    // =====================================================
    // 📍 LISTAR DIRECCIONES DEL USUARIO
    // URL: /?controller=direccion&action=lista
    // =====================================================
    public function lista() {

        $id_usuario = $_SESSION['usuario']['id_usuario'];

        $direcciones = $this->direccionModel->obtenerPorUsuario($id_usuario);

        require __DIR__ . '/../views/user/direcciones.php';
    }

    // =====================================================
    // ➕ FORMULARIO NUEVA DIRECCIÓN
    // URL: /?controller=direccion&action=nueva
    // =====================================================
    public function nueva() {

        require __DIR__ . '/../views/user/nueva_direccion.php';
    }

    // =====================================================
    // 💾 GUARDAR DIRECCIÓN
    // URL: /?controller=direccion&action=guardar
    // =====================================================
    public function guardar() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Método no permitido");
        }

        $data = [
            'id_usuario'    => $_SESSION['usuario']['id_usuario'],
            'direccion'     => $_POST['direccion'] ?? '',
            'ciudad'        => $_POST['ciudad'] ?? '',
            'provincia'     => $_POST['provincia'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? ''
        ];

        // Validación básica
        if (empty($data['direccion']) || empty($data['ciudad'])) {
            die("Dirección y ciudad son obligatorias");
        }

        $this->direccionModel->guardar($data);

        header("Location: /?controller=direccion&action=lista");
        exit;
    }

    // =====================================================
    // 🔁 ALIAS POR SI SE USA index
    // =====================================================
    public function index() {
        $this->lista();
    }
}
