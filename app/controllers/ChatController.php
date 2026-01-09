<?php

class ChatbotController {

    public function responder() {
        $data = json_decode(file_get_contents("php://input"), true);
        $mensaje = strtolower($data['mensaje']);

        if (str_contains($mensaje, 'precio')) {
            $this->precioProducto($mensaje);
            return;
        }

        if (str_contains($mensaje, 'más vendido')) {
            $this->productoMasVendido();
            return;
        }

        if (str_contains($mensaje, 'menos vendido')) {
            $this->productoMenosVendido();
            return;
        }

        if (str_contains($mensaje, 'pedido')) {
            echo json_encode([
                "respuesta" => "Tu pedido ya fue revisado por el administrador."
            ]);
            return;
        }

        if (str_contains($mensaje, 'gasto') || str_contains($mensaje, 'ventas')) {
            $this->totalVentas();
            return;
        }

        if (str_contains($mensaje, 'tienda')) {
            echo json_encode([
                "respuesta" => "Somos una tienda de artesanías comprometida con la calidad."
            ]);
            return;
        }

        echo json_encode([
            "respuesta" => "No entendí tu consulta."
        ]);
    }

    /* =======================
       6. PRECIO DE PRODUCTO
       ======================= */
    private function precioProducto($mensaje) {
        $producto = trim(str_replace("precio", "", $mensaje));

        $db = Database::connect();
        $sql = "SELECT precio FROM productos WHERE nombre LIKE ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(["%$producto%"]);
        $res = $stmt->fetch();

        echo json_encode([
            "respuesta" => $res
                ? "El precio del producto es $" . $res['precio']
                : "No encontré ese producto."
        ]);
    }

    /* ==========================
       7. PRODUCTO MÁS VENDIDO
       ========================== */
    private function productoMasVendido() {
        $db = Database::connect();

        $sql = "SELECT p.nombre, SUM(d.cantidad) total
                FROM detalle_pedido d
                JOIN productos p ON d.producto_id = p.id
                GROUP BY p.id
                ORDER BY total DESC
                LIMIT 1";

        $res = $db->query($sql)->fetch();

        echo json_encode([
            "respuesta" => "El producto más vendido es: " . $res['nombre']
        ]);
    }

    /* ==========================
       8. PRODUCTO MENOS VENDIDO
       ========================== */
    private function productoMenosVendido() {
        $db = Database::connect();

        $sql = "SELECT p.nombre, SUM(d.cantidad) total
                FROM detalle_pedido d
                JOIN productos p ON d.producto_id = p.id
                GROUP BY p.id
                ORDER BY total ASC
                LIMIT 1";

        $res = $db->query($sql)->fetch();

        echo json_encode([
            "respuesta" => "El producto menos comprado es: " . $res['nombre']
        ]);
    }

    /* =======================
       9. TOTAL DE VENTAS
       ======================= */
    private function totalVentas() {
        $db = Database::connect();
        $sql = "SELECT SUM(total) total FROM pedidos";
        $res = $db->query($sql)->fetch();

        echo json_encode([
            "respuesta" => "El monto total gastado es $" . ($res['total'] ?? 0)
        ]);
    }
}
