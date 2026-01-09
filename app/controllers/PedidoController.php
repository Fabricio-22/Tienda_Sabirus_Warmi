<?php

require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Direccion.php';

class PedidoController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->pedidoModel   = new Pedido();
        $this->productoModel = new Producto();
        $this->direccionModel = new Direccion();
    }

    private function verificarLogin() {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?controller=usuario&action=login");
            exit;
        }
    }

    public function agregar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        die("ID de producto no recibido");
    }

    require_once __DIR__ . '/../models/Producto.php';
    $productoModel = new Producto();
    $producto = $productoModel->getById($id);

    if (!$producto) {
        die("Producto no encontrado");
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad']++;
    } else {
        $_SESSION['carrito'][$id] = [
            'id'       => $producto['id_producto'],
            'nombre'   => $producto['nombre'],
            'precio'   => $producto['precio'],
            'cantidad' => 1
        ];
    }

    header("Location: /?controller=pedido&action=carrito");
    exit;
}
public function agregarAjax()
{
    header('Content-Type: application/json');

    if (!isset($_SESSION['usuario'])) {
        echo json_encode(['success' => false, 'login' => true]);
        return;
    }

    $id = $_POST['id'] ?? null;
    if (!$id) {
        echo json_encode(['success' => false]);
        return;
    }

    require_once __DIR__ . '/../models/Producto.php';
    $productoModel = new Producto();
    $producto = $productoModel->getById($id);

    if (!$producto) {
        echo json_encode(['success' => false]);
        return;
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad']++;
    } else {
        $_SESSION['carrito'][$id] = [
            'id' => $producto['id_producto'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => 1,
            'imagen' => $producto['imagen'] ?? null
        ];
    }

    echo json_encode([
        'success' => true,
        'totalItems' => array_sum(array_column($_SESSION['carrito'], 'cantidad'))
    ]);
}



public function carrito()
    {
        // 1. Verificar login
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?controller=usuario&action=login");
            exit;
        }

        $usuario = $_SESSION['usuario'];
        $carrito = $_SESSION['carrito'] ?? [];

        // 2. CALCULAR TOTALES (Vital para que la vista no falle)
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        // Lógica de envío (Ejemplo: Gratis si compra más de $50)
        $envio = ($subtotal > 50 || $subtotal == 0) ? 0 : 5.00; 
        $total = $subtotal + $envio;

        // 3. Cargar la vista con todas las variables necesarias
        require __DIR__ . '/../views/user/carrito.php';
    }
   public function eliminar() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    $key = $_GET['key'] ?? null;

    if ($key !== null && isset($_SESSION['carrito'][$key])) {
        unset($_SESSION['carrito'][$key]);
    }

    // IMPORTANTE: Forzar el guardado de sesión antes del redireccionamiento
    session_write_close();
    
    header("Location: index.php?controller=pedido&action=carrito");
    exit;
}

public function vaciarCarrito() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    unset($_SESSION['carrito']);
    
    session_write_close();
    
    header("Location: index.php?controller=pedido&action=carrito");
    exit;
}

    public function actualizarCantidad()
    {
        if (isset($_GET['key']) && isset($_GET['cantidad'])) {
            $key = $_GET['key'];
            $cantidad = (int) $_GET['cantidad'];

            if ($cantidad < 1) $cantidad = 1;

            if (isset($_SESSION['carrito'][$key])) {
                $_SESSION['carrito'][$key]['cantidad'] = $cantidad;
            }
        }

        header("Location: /?controller=pedido&action=carrito");
        exit;
    }

     


 public function confirmar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header("Location: /?controller=usuario&action=login");
        exit;
    }

    if (empty($_SESSION['carrito'])) {
        header("Location: /?controller=pedido&action=carrito");
        exit;
    }

    if (!isset($_POST['metodo_pago'])) {
        die("Método de pago no seleccionado");
    }

    // =========================
    // CONEXIÓN BD
    // =========================
    $db = new PDO(
        "sqlite:" . __DIR__ . "/../../database/tienda_online.db"
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $db->beginTransaction();

        // =========================
        // 1️⃣ GUARDAR DIRECCIÓN
        // =========================
        $stmtDir = $db->prepare("
            INSERT INTO direcciones (id_usuario, direccion, ciudad, codigo_postal)
            VALUES (?, ?, ?, ?)
        ");
        $stmtDir->execute([
            $_SESSION['usuario']['id_usuario'],
            $_POST['direccion'],
            $_POST['ciudad'],
            $_POST['codigo_postal'] ?? null
        ]);

        $idDireccion = $db->lastInsertId();

        // =========================
        // 2️⃣ CALCULAR TOTAL (CORRECTO)
        // =========================
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // =========================
        // 3️⃣ CREAR PEDIDO (PENDIENTE)
        // =========================
        $stmtPedido = $db->prepare("
            INSERT INTO pedidos (id_usuario, id_direccion, total, id_estado)
            VALUES (?, ?, ?, 1)
        ");
        $stmtPedido->execute([
            $_SESSION['usuario']['id_usuario'],
            $idDireccion,
            $total
        ]);

        $idPedido = $db->lastInsertId();

        // =========================
        // 4️⃣ DETALLE DEL PEDIDO
        // =========================
        $stmtDetalle = $db->prepare("
            INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($_SESSION['carrito'] as $idProducto => $item) {
    $stmtDetalle->execute([
        $idPedido,
        $idProducto,          // ← AQUÍ ESTÁ EL ID REAL
        $item['cantidad'],
        $item['precio']
    ]);
}


        // =========================
        // 5️⃣ SUBIR COMPROBANTE (TRANSFERENCIA)
        // =========================
        $comprobantePath = null;

        if ($_POST['metodo_pago'] === 'transferencia' && isset($_FILES['comprobante'])) {
        $nombre = uniqid('trx_') . '.' . pathinfo($_FILES['comprobante']['name'], PATHINFO_EXTENSION);
        $ruta = "/uploads/comprobantes/" . $nombre;

        move_uploaded_file(
        $_FILES['comprobante']['tmp_name'],
        __DIR__ . "/../../public" . $ruta
        );

        $comprobantePath = $ruta;
}


        // =========================
        // 6️⃣ REGISTRAR PAGO
        // =========================
       $stmtPago = $db->prepare("
       INSERT INTO pagos (id_pedido, metodo_pago, monto, comprobante)
       VALUES (?, ?, ?, ?)
       ");

       $stmtPago->execute([
       $idPedido,
       $_POST['metodo_pago'],
       $total,
       $comprobantePath
       ]);


        // =========================
        // 7️⃣ LIMPIAR CARRITO
        // =========================
        unset($_SESSION['carrito']);

        $db->commit();

        // =========================
        // 8️⃣ REDIRIGIR A HISTORIAL
        // =========================
        header("Location: /?controller=pedido&action=historial");
        exit;

    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        die("Error al confirmar pedido: " . $e->getMessage());
    }
}

public function historial()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Usuario debe estar logueado
    if (!isset($_SESSION['usuario'])) {
        header("Location: /?controller=usuario&action=login");
        exit;
    }

    require_once __DIR__ . '/../models/Pedido.php';
    $pedidoModel = new Pedido(); // ✅ Usamos el modelo tal cual, no $this->db

    $id_usuario = $_SESSION['usuario']['id_usuario'];
    $pedidos = $pedidoModel->obtenerHistorial($id_usuario);

    require __DIR__ . '/../views/pedidos/historial.php';
}

public function detalle()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header("Location: /?controller=usuario&action=login");
        exit;
    }

    $idPedido = $_GET['id'] ?? null;
    if (!$idPedido) {
        die("Pedido no válido");
    }

    require_once __DIR__ . '/../models/Pedido.php';
    $pedidoModel = new Pedido(); // ✅ Usamos el modelo tal cual

    $pedido = $pedidoModel->obtenerPedidoPorId($idPedido);
    if (!$pedido) {
        die("Pedido no encontrado");
    }

    // Seguridad: solo dueño o admin
    if ($_SESSION['usuario']['id_rol'] != 1 && $pedido['id_usuario'] != $_SESSION['usuario']['id_usuario']) {
        die("Acceso denegado");
    }

    $detalle = $pedidoModel->obtenerDetallePedido($idPedido);

    require __DIR__ . '/../views/pedidos/detalle.php';
}


    
}

