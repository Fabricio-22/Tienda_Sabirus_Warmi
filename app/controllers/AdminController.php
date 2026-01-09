<?php

require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';

class AdminController {

    private $pedidoModel;
    private $usuarioModel;
    private $productoModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🔐 Validar admin
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_rol'] != 1) {
            die("Acceso no autorizado");
        }

        $this->pedidoModel   = new Pedido();
        $this->usuarioModel  = new Usuario();
        $this->productoModel = new Producto();
    }

    /* =====================================================
       🏠 DASHBOARD ADMIN
    ===================================================== */
    public function dashboard()
    {
        $totalUsuarios  = $this->usuarioModel->contarUsuarios();
        $totalProductos = $this->productoModel->contarProductos();
        $totalPedidos   = $this->pedidoModel->contarPedidos();
        $ultimosPedidos = $this->pedidoModel->ultimosPedidos(5);

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    /* =====================================================
       📦 PEDIDOS (ADMIN)
    ===================================================== */
    public function pedidos()
    {
        $pedidos = $this->pedidoModel->getAllAdmin();
        require __DIR__ . '/../views/admin/pedidos/index.php';
    }

    /* =====================================================
       ✅ APROBAR PAGO (TRANSFERENCIA)
    ===================================================== */
    public function aprobarPago()
    {
        if (!isset($_GET['id'])) {
            die("Pedido no válido");
        }

        $pedidoId = (int) $_GET['id'];

        // Cambiar estado a PAGADO (2)
        $this->pedidoModel->marcarComoPagado($pedidoId);

        header("Location: /?controller=admin&action=pedidos");
        exit;
    }

    /* =====================================================
       📦 PRODUCTOS
    ===================================================== */
    public function productos()
    {
        header("Location: /?controller=producto&action=adminIndex");
        exit;
    }

    /* =====================================================
       👤 USUARIOS
    ===================================================== */
    public function usuarios()
    {
        $usuarios = $this->usuarioModel->getAll();
        require __DIR__ . '/../views/admin/usuarios/index.php';
    }

    public function detallePedido()
{
    if (!isset($_GET['id'])) {
        die("ID de pedido no recibido");
    }

    $idPedido = (int) $_GET['id'];
    $pedidoModel = new Pedido();

    $pedido  = $pedidoModel->obtenerPedidoPorId($idPedido);
    $detalle = $pedidoModel->obtenerDetallePedido($idPedido);

    if (!$pedido) {
        die("Pedido no encontrado");
    }

    require __DIR__ . '/../views/admin/pedidos/detalle.php';
}

}
