<?php
require_once __DIR__ . '/../config/database.php';

class ChatService
{
    private PDO $db;
    private $usuario;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = Database::getInstance();
        $this->usuario = $_SESSION['usuario'] ?? null;
    }

    /* =====================================================
       🎯 MÉTODO PRINCIPAL
    ===================================================== */
    public function responder(string $mensaje): string
    {
        $m = strtolower(trim($mensaje));

        /* ================== SALUDOS ================== */
        if ($this->contiene($m, ['hola','buenas','hey','saludos'])) {
            return "👋 ¡Hola! Bienvenido a nuestra tienda de artesanías.
Puedo ayudarte con:
• precios de productos
• estado de pedidos
• gastos realizados
• información de la tienda
¿En qué te ayudo hoy?";
        }

        /* ================== PRECIO PRODUCTO ================== */
        if ($this->contiene($m, ['precio','cuesta','valor'])) {
            return $this->precioProducto($m);
        }

        /* ================== PRODUCTO MÁS / MENOS VENDIDO ================== */
        if ($this->contiene($m, ['mas vendido','más vendido'])) {
            return $this->productoMasVendido();
        }

        if ($this->contiene($m, ['menos vendido','menos comprado'])) {
            return $this->productoMenosVendido();
        }

        /* ================== GASTOS DEL USUARIO ================== */
        if ($this->contiene($m, ['cuanto he gastado','gaste','total gastado'])) {
            return $this->totalGastado();
        }

        /* ================== ESTADO DEL PEDIDO ================== */
        if ($this->contiene($m, ['estado','pedido','revisado','admin'])) {
            return $this->estadoPedido();
        }

        /* ================== INFO TIENDA ================== */
        if ($this->contiene($m, ['tienda','horario','envio','pago','ubicacion'])) {
            return $this->infoTienda();
        }

        /* ================== AYUDA ================== */
        if ($this->contiene($m, ['ayuda','puedes','opciones'])) {
            return "🤖 Puedo ayudarte con:
• Precios de productos
• Estado de pedidos
• Gastos realizados
• Productos más vendidos
• Información de la tienda

Escribe tu pregunta 😊";
        }

        return "🤔 No entendí del todo.
Puedes preguntarme por:
• precios
• pedidos
• gastos
• productos más vendidos
• información de la tienda";
    }

    /* =====================================================
       🔎 FUNCIONES DE SOPORTE
    ===================================================== */
    private function contiene(string $texto, array $palabras): bool
    {
        foreach ($palabras as $p) {
            if (str_contains($texto, $p)) return true;
        }
        return false;
    }

    /* =====================================================
       💰 PRECIO DE PRODUCTO
    ===================================================== */
    private function precioProducto(string $mensaje): string
    {
        $stmt = $this->db->query("SELECT nombre, precio FROM productos");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productos as $p) {
            if (str_contains($mensaje, strtolower($p['nombre']))) {
                return "💎 El precio de **{$p['nombre']}** es **$" . number_format($p['precio'],2) . "**.";
            }
        }

        return "No encontré ese producto 😕. Intenta escribir el nombre completo.";
    }

    /* =====================================================
       📊 PRODUCTO MÁS VENDIDO
    ===================================================== */
    private function productoMasVendido(): string
    {
        $stmt = $this->db->query("
            SELECT pr.nombre, SUM(dp.cantidad) total
            FROM detalle_pedido dp
            JOIN productos pr ON pr.id_producto = dp.id_producto
            GROUP BY pr.id_producto
            ORDER BY total DESC
            LIMIT 1
        ");

        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r
            ? "🔥 El producto más vendido es **{$r['nombre']}**."
            : "Aún no hay ventas registradas.";
    }

    /* =====================================================
       📉 PRODUCTO MENOS VENDIDO
    ===================================================== */
    private function productoMenosVendido(): string
    {
        $stmt = $this->db->query("
            SELECT pr.nombre, SUM(dp.cantidad) total
            FROM detalle_pedido dp
            JOIN productos pr ON pr.id_producto = dp.id_producto
            GROUP BY pr.id_producto
            ORDER BY total ASC
            LIMIT 1
        ");

        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r
            ? "📉 El producto menos comprado es **{$r['nombre']}**."
            : "Aún no hay datos suficientes.";
    }

    /* =====================================================
       🧾 TOTAL GASTADO
    ===================================================== */
    private function totalGastado(): string
    {
        if (!$this->usuario) {
            return "Debes iniciar sesión para ver tus gastos.";
        }

        $stmt = $this->db->prepare("
            SELECT SUM(total) FROM pedidos WHERE id_usuario = ?
        ");
        $stmt->execute([$this->usuario['id_usuario']]);
        $total = $stmt->fetchColumn();

        return "💰 Has gastado un total de **$" . number_format($total ?? 0,2) . "** en la tienda.";
    }

    /* =====================================================
       📦 ESTADO DEL PEDIDO
    ===================================================== */
    private function estadoPedido(): string
    {
        if (!$this->usuario) {
            return "Debes iniciar sesión para consultar tus pedidos.";
        }

        $stmt = $this->db->prepare("
            SELECT p.id_pedido, e.nombre
            FROM pedidos p
            JOIN estado_pedido e ON e.id_estado = p.id_estado
            WHERE p.id_usuario = ?
            ORDER BY p.fecha_pedido DESC
            LIMIT 1
        ");
        $stmt->execute([$this->usuario['id_usuario']]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$p) return "Aún no tienes pedidos.";

        return "📦 Tu último pedido (#{$p['id_pedido']}) está en estado **{$p['nombre']}**.";
    }

    /* =====================================================
       🏪 INFORMACIÓN DE LA TIENDA
    ===================================================== */
    private function infoTienda(): string
    {
        return "🏪 **Nuestra tienda de artesanías**
📍 Ubicación: Ecuador
🕒 Horario: Lunes a Sábado 9:00–18:00
💳 Pagos: Transferencia y PayPal
🚚 Envíos a todo el país

Gracias por apoyar el trabajo artesanal 💖";
    }
}
