<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Direccion.php';

class UsuarioController {

    private $usuarioModel;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->usuarioModel = new Usuario();
    }

    // ===============================
// ADMIN - LISTADO DE USUARIOS
// ===============================
public function index()
{
    // Seguridad: solo admin
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_rol'] != 1) {
        header("Location: /?controller=usuario&action=login");
        exit;
    }

    // Obtener usuarios
    $usuarios = $this->usuarioModel->getAll();

    // Cargar vista admin
    require __DIR__ . '/../views/admin/usuarios/index.php';
}


    // ===============================
    // LOGIN (SOLO MUESTRA LA VISTA)
    // ===============================
    public function login() {
        require __DIR__ . '/../views/auth/login.php';
    }

    // ===============================
    // AUTENTICAR LOGIN (PROCESA FORM)
    // ===============================
    public function autenticar() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /?controller=usuario&action=login");
            exit;
        }

        $correo     = $_POST['correo'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        $usuario = $this->usuarioModel->login($correo, $contrasena);

        if ($usuario) {

            $_SESSION['usuario'] = $usuario;

            // 🔁 Redirigir según rol
            if ($usuario['id_rol'] == 1) {
                header("Location: /?controller=admin&action=dashboard");
            } else {
                header("Location: /?controller=usuario&action=home");

            }
            exit;
        }

        // ❌ Login incorrecto
        header("Location: /?controller=usuario&action=login&error=1");
        exit;
    }

    // ===============================
    // HOME DEL USUARIO LOGUEADO
    // ===============================
    public function home() {

    $productoModel = new Producto();
    $productos = $productoModel->getAll();

    // usuario puede existir o no
    $usuario = $_SESSION['usuario'] ?? null;

    require __DIR__ . '/../views/user/home.php';
}


    // ===============================
    // REGISTRO
    // ===============================
    public function registro() {
        require __DIR__ . '/../views/auth/registro.php';
    }

    public function guardar() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 1. Recoger datos del formulario
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $password = $_POST['contrasena'];

        // 2. Encriptar la contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // 3. ¡ESTA ES LA PARTE CLAVE! 
        // Creamos el arreglo $data con las llaves que tu modelo espera
        $data = [
            'nombre'     => $nombre,
            'correo'     => $correo,
            'contrasena' => $passwordHash,
            'telefono'   => $telefono,
            'id_rol'     => 2 // Rol por defecto (Usuario)
        ];

        // 4. Llamar al modelo pasando SOLAMENTE el arreglo $data
        $usuario = new Usuario();
        $resultado = $usuario->registrar($data);

        if ($resultado) {
            // Éxito: Redirigir al login
            header("Location: index.php?controller=usuario&action=login&registro=exito");
            exit;
        } else {
            // Error: El correo ya existe o falló la DB
            // En lugar de un die, podrías redirigir con error
            header("Location: index.php?controller=usuario&action=registro&error=duplicado");
            exit;
        }
    }
}

    // ===============================
    // PERFIL
    // ===============================
    public function perfil() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: /?controller=usuario&action=login");
            exit;
        }

        require __DIR__ . '/../views/user/perfil.php';
    }

    public function actualizar() {

        if (!isset($_SESSION['usuario'])) {
            die("No autorizado");
        }

        $id = $_SESSION['usuario']['id_usuario'];

        $this->usuarioModel->actualizarPerfil(
            $id,
            $_POST['nombre'],
            $_POST['telefono']
        );

        $_SESSION['usuario']['nombre']   = $_POST['nombre'];
        $_SESSION['usuario']['telefono'] = $_POST['telefono'];

        header("Location: /?controller=usuario&action=perfil&ok=1");
        exit;
    }

    // ===============================
    // LOGOUT
    // ===============================
    public function logout() {
        session_destroy();
        header("Location: /");
        exit;
    }
}
