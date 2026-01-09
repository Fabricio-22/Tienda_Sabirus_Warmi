<?php

require_once __DIR__ . '/../config/database.php';

class Pedido {

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* =====================================================
       📊 MÉTRICAS PARA DASHBOARD ADMIN
    ===================================================== */

    public function contarPedidos()
    {
        return $this->db->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
    }

    public function ultimosPedidos($limite = 5)
{
    $sql = "
        SELECT
            p.id_pedido,
            p.total,
            p.fecha_pedido,
            u.nombre AS nombre_usuario
        FROM pedidos p
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario
        ORDER BY p.fecha_pedido DESC
        LIMIT :limite
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /* =====================================================
       📦 PEDIDOS ADMIN
    ===================================================== */

    public function getAllAdmin()
    {
    $sql = "
        SELECT 
            p.id_pedido,
            p.total,
            p.fecha_pedido,
            u.nombre AS usuario,
            e.nombre AS estado,
            pg.metodo_pago,
            pg.comprobante
        FROM pedidos p
        JOIN usuarios u ON u.id_usuario = p.id_usuario
        JOIN estado_pedido e ON e.id_estado = p.id_estado
        LEFT JOIN pagos pg ON pg.id_pedido = p.id_pedido
        ORDER BY p.fecha_pedido DESC
    ";

    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =====================================================
       🛒 CREAR PEDIDO (USUARIO)
    ===================================================== */

    public function crearPedido($id_usuario, $id_direccion, $total)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pedidos (id_usuario, id_direccion, total, id_estado)
            VALUES (?, ?, ?, 1)
        ");

        $stmt->execute([$id_usuario, $id_direccion, $total]);
        return $this->db->lastInsertId();
    }

    public function agregarDetalle($id_pedido, $id_producto, $cantidad, $precio)
    {
        $stmt = $this->db->prepare("
            INSERT INTO detalle_pedido 
            (id_pedido, id_producto, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $id_pedido,
            $id_producto,
            $cantidad,
            $precio
        ]);
    }

    /* =====================================================
       👤 PEDIDOS DEL USUARIO
    ===================================================== */

    public function obtenerPedidos($id_usuario) 
{
    $sql = "
        SELECT 
            p.id_pedido,
            p.total,
            p.fecha_pedido,
            e.nombre AS estado,
            pg.metodo_pago,
            d.direccion || ', ' || d.ciudad AS direccion
        FROM pedidos p
        JOIN estado_pedido e ON e.id_estado = p.id_estado
        LEFT JOIN pagos pg ON pg.id_pedido = p.id_pedido
        LEFT JOIN direcciones d ON d.id_direccion = p.id_direccion
        WHERE p.id_usuario = ?
        ORDER BY p.fecha_pedido DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id_usuario]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function obtenerHistorial($id_usuario)
    {
        return $this->obtenerPedidos($id_usuario);
    }

    /* =====================================================
       🛠️ ADMIN — ESTADOS
    ===================================================== */

    public function actualizarEstado($id_pedido, $id_estado)
    {
        $stmt = $this->db->prepare("
            UPDATE pedidos
            SET id_estado = ?
            WHERE id_pedido = ?
        ");

        return $stmt->execute([$id_estado, $id_pedido]);
    }

    public function marcarComoPagado($idPedido)
    {
        $stmt = $this->db->prepare("
            UPDATE pedidos
            SET id_estado = 2
            WHERE id_pedido = ?
        ");

        return $stmt->execute([$idPedido]);
    }
/* =====================================================
   📄 DETALLE DE PEDIDO (USUARIO / ADMIN)
===================================================== */

public function obtenerPedidoPorId($idPedido)
{
    $stmt = $this->db->prepare("
        SELECT 
            p.id_pedido,
            p.total,
            p.fecha_pedido,
            e.nombre AS estado,
            u.nombre AS usuario,
            u.correo,
            d.direccion,
            d.ciudad,
            d.codigo_postal,
            pg.metodo_pago,
            pg.comprobante
        FROM pedidos p
        JOIN usuarios u ON u.id_usuario = p.id_usuario
        JOIN estado_pedido e ON e.id_estado = p.id_estado
        JOIN direcciones d ON d.id_direccion = p.id_direccion
        LEFT JOIN pagos pg ON pg.id_pedido = p.id_pedido
        WHERE p.id_pedido = ?
    ");
    $stmt->execute([$idPedido]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function obtenerDetallePedido($idPedido)
{
    $stmt = $this->db->prepare("
        SELECT 
            pr.nombre,
            dp.cantidad,
            dp.precio_unitario,
            dp.subtotal
        FROM detalle_pedido dp
        JOIN productos pr ON pr.id_producto = dp.id_producto
        WHERE dp.id_pedido = ?
    ");
    $stmt->execute([$idPedido]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerUltimosPedidos($limite = 5)
{
    $sql = "
        SELECT
            p.id_pedido,
            p.total,
            p.fecha_pedido,
            u.nombre AS nombre_usuario
        FROM pedidos p
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario
        ORDER BY p.fecha_pedido DESC
        LIMIT :limite
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

  
}
