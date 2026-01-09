<?php
/**
 * AuthController - Controlador de Autenticación
 * Versión mejorada manteniendo la funcionalidad original
 */

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    private $usuario;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->usuario = new Usuario();
    }

    /* ============================================================
       🔐 LOGIN
    ============================================================ */

    /**
     * Muestra el formulario de login
     */
    public function login() {
        // Si ya está logueado, redirigir según rol
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['usuario']['id_rol'] == 1) {
                header("Location: /?controller=admin&action=dashboard");
            } else {
                header("Location: /?controller=usuario&action=home");
            }
            exit;
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Procesa el login del usuario
     */
    public function autenticar() {
        // Verificar que sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /?controller=auth&action=login");
            exit;
        }

        // Obtener datos
        $correo = trim($_POST['correo'] ?? '');
        $pass = $_POST['contrasena'] ?? '';

        // Validar campos vacíos
        if (empty($correo) || empty($pass)) {
    header("Location: /?controller=auth&action=login&error=credenciales");
    exit;
}
        

        // Intentar autenticar
        $usuario = $this->usuario->login($correo, $pass);

        if (!$usuario) {
    header("Location: /?controller=auth&action=login&error=credenciales");
    exit;
}

        // Guardar en sesión
        $_SESSION['usuario'] = $usuario;

        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Redirigir según rol
        if ($usuario['id_rol'] == 1) {
            // ADMIN → DASHBOARD
            header("Location: /?controller=admin&action=dashboard");
        } else {
            // USUARIO NORMAL → HOME
            header("Location: /?controller=usuario&action=home");
        }
        exit;
    }

    /* ============================================================
       📝 REGISTRO
    ============================================================ */

    /**
     * Muestra el formulario de registro
     */
    public function registro() {
        // Si ya está logueado, redirigir
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['usuario']['id_rol'] == 1) {
                header("Location: /?controller=admin&action=dashboard");
            } else {
                header("Location: /?controller=usuario&action=home");
            }
            exit;
        }

        require __DIR__ . '/../views/auth/registro.php';
    }

    /**
     * Procesa el registro de nuevo usuario
     * Nota: Mantiene el nombre original 'guardarRegistro' para compatibilidad
     */
    public function guardarRegistro()
{
    // Verificar que sea POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /?controller=auth&action=registro");
        exit;
    }

    // Obtener y limpiar datos
    $nombre     = trim($_POST['nombre'] ?? '');
    $correo     = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $telefono   = trim($_POST['telefono'] ?? '');

    /* ===============================
       VALIDACIONES BACKEND
    =============================== */

    // Campos obligatorios
    if (empty($nombre) || empty($correo) || empty($contrasena)) {
        header("Location: /?controller=auth&action=registro&error=campos_vacios");
        exit;
    }

    // Nombre: solo letras y espacios
    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
        header("Location: /?controller=auth&action=registro&error=nombre_invalido");
        exit;
    }

    // Correo válido
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: /?controller=auth&action=registro&error=correo_invalido");
        exit;
    }

    // Contraseña mínima
    if (strlen($contrasena) < 6) {
        header("Location: /?controller=auth&action=registro&error=contrasena_corta");
        exit;
    }

    // Teléfono (opcional pero validado)
    if (!empty($telefono)) {
        // Solo números y exactamente 10 dígitos
        if (!preg_match('/^\d{10}$/', $telefono)) {
            header("Location: /?controller=auth&action=registro&error=telefono_invalido");
            exit;
        }
    }

    // Verificar si el correo ya existe
    if ($this->usuario->existeCorreo($correo)) {
        header("Location: /?controller=auth&action=registro&error=correo_existe");
        exit;
    }

    /* ===============================
       REGISTRO DE USUARIO
    =============================== */

    $data = [
        'nombre'     => $nombre,
        'correo'     => $correo,
        'contrasena' => password_hash($contrasena, PASSWORD_BCRYPT),
        'telefono'   => $telefono,
        'id_rol'     => 2 // Usuario normal
    ];

    $resultado = $this->usuario->registrar($data);

    if ($resultado) {
        // Registro exitoso → login
        header("Location: /?controller=auth&action=login&registro=exitoso");
    } else {
        // Error al registrar
        header("Location: /?controller=auth&action=registro&error=registro_fallido");
    }
    exit;
}


    /**
     * Alias para mantener compatibilidad con nuevas rutas
     */
    public function guardar() {
        $this->guardarRegistro();
    }

    /* ============================================================
       🚪 LOGOUT
    ============================================================ */

    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        // Limpiar variables de sesión
        $_SESSION = [];

        // Destruir cookie de sesión si existe
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Destruir sesión
        session_destroy();

        // Redirigir al login
        header("Location: /?controller=auth&action=login&sesion=cerrada");
        exit;
    }
}
?>