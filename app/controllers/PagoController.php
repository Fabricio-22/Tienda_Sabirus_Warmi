<?php

class PagoController
{
    private $clientId = "ASuXch-VlMQcbRtg8oGtFygn11Fmmwa5-VQt6iA5zVI2JMWmrS63qtu06HZrhc4aQjORAEKWhSEXX8jX";
    private $secret   = "EK-WNBmAP39x8p2MxZmS82HpEnJCwJ7q9jz_fgqiGLMallyIIF1QY0gy_AJp_T2H78p0fYslYDHJGiFT";
    private $baseUrl  = "https://api-m.sandbox.paypal.com";

    /* ===============================
       Obtener token PayPal (CORREGIDO)
    =============================== */
    private function getAccessToken()
    {
        $ch = curl_init($this->baseUrl . "/v1/oauth2/token");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_USERPWD => $this->clientId . ":" . $this->secret,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Accept-Language: en_US",
                "Content-Type: application/x-www-form-urlencoded"
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            error_log("PAYPAL TOKEN ERROR ($httpCode): $response");
            return null;
        }

        $data = json_decode($response, true);
        return $data['access_token'] ?? null;
    }

    /* ===============================
       Crear orden
    =============================== */
    public function crearOrden()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);
        $total = floatval($input['total'] ?? 0);

        if ($total <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Total inválido"]);
            exit;
        }

        $token = $this->getAccessToken();
        if (!$token) {
            http_response_code(500);
            echo json_encode(["error" => "No se pudo obtener token PayPal"]);
            exit;
        }

        $orderData = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($total, 2, '.', '')
                ]
            ]]
        ];

        $ch = curl_init($this->baseUrl . "/v2/checkout/orders");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer $token"
            ],
            CURLOPT_POSTFIELDS => json_encode($orderData)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }

    /* ===============================
       Confirmar pago
    =============================== */
    public function confirmarPago()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json');

    $input = json_decode(file_get_contents("php://input"), true);
    $orderID = $input['orderID'] ?? null;

    if (!$orderID) {
        http_response_code(400);
        echo json_encode(["error" => "OrderID no recibido"]);
        exit;
    }

    $token = $this->getAccessToken();
    if (!$token) {
        http_response_code(500);
        echo json_encode(["error" => "Token PayPal inválido"]);
        exit;
    }

    // CAPTURA DEL PAGO
    $ch = curl_init($this->baseUrl . "/v2/checkout/orders/$orderID/capture");
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ],
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (!isset($result['status']) || $result['status'] !== 'COMPLETED') {
        http_response_code(400);
        echo json_encode(["error" => "Pago no completado"]);
        exit;
    }

    // DATOS DEL PAGO
    $monto = $result['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
    $transaccionId = $result['purchase_units'][0]['payments']['captures'][0]['id'];

    // DATOS DE SESIÓN
    $idUsuario   = $_SESSION['usuario']['id_usuario'];
    $idDireccion = $_SESSION['direccion_seleccionada'];
    $carrito     = $_SESSION['carrito'];

    // CONEXIÓN SQLITE
    $db = new PDO("sqlite:database.sqlite");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();

    try {
        // 1️⃣ CREAR PEDIDO
        $stmt = $db->prepare("
            INSERT INTO pedidos (id_usuario, id_direccion, total, id_estado, paypal_order_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $idUsuario,
            $idDireccion,
            $monto,
            2, // PAGADO
            $orderID
        ]);

        $idPedido = $db->lastInsertId();

        // 2️⃣ INSERTAR DETALLE PEDIDO
        $stmtDetalle = $db->prepare("
            INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($carrito as $item) {
            $stmtDetalle->execute([
                $idPedido,
                $item['id_producto'],
                $item['cantidad'],
                $item['precio']
            ]);
        }

        // 3️⃣ REGISTRAR PAGO
        $stmtPago = $db->prepare("
            INSERT INTO pagos (id_pedido, metodo_pago, monto, transaccion_id)
            VALUES (?, ?, ?, ?)
        ");
        $stmtPago->execute([
            $idPedido,
            'paypal',
            $monto,
            $transaccionId
        ]);

        // 4️⃣ VACIAR CARRITO
        unset($_SESSION['carrito']);
        unset($_SESSION['total']);

        $db->commit();

        // MARCAR PAGO EN SESIÓN (CLAVE)
        $_SESSION['pedido_pagado'] = true;
        $_SESSION['pedido_id'] = $idPedido;


        echo json_encode([
            "status" => "COMPLETED",
            "id_pedido" => $idPedido
        ]);
    } catch (Exception $e) {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
public function subirComprobante()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    // 1. Validar si existe el ID del pedido en la sesión
    // Nota: Asegúrate que en la función anterior guardaste: $_SESSION['pedido_id'] = $idPedido;
    $pedidoId = $_SESSION['pedido_id'] ?? null;

    if (!$pedidoId) {
        die('Error: No se encontró un pedido activo para vincular el comprobante.');
    }

    if (!isset($_FILES['comprobante']) || $_FILES['comprobante']['error'] !== 0) {
        die('Error: El archivo del comprobante es requerido.');
    }

    // 2. Preparar ruta (basado en tu carpeta public/uploads)
    $nombre = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['comprobante']['name']);
    $rutaCarpeta = 'public/uploads/comprobantes/';
    $rutaDB = $rutaCarpeta . $nombre; // Lo que se guarda en la base de datos

    if (!is_dir($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);
    }

    if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $rutaCarpeta . $nombre)) {
        
        try {
            // 3. Conexión a tu base de datos REAL [cite: 1]
            $db = new PDO("sqlite:database/tienda_online.db");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 4. Actualizar la tabla 'pagos' con el nombre del archivo [cite: 5, 7]
            // Nota: Tu tabla pagos tiene la columna 'comprobante' 
            $stmt = $db->prepare("UPDATE pagos SET comprobante = ? WHERE id_pedido = ?");
            $stmt->execute([$nombre, $pedidoId]);

            // 5. Limpiar carrito y variables temporales
            unset($_SESSION['carrito']);
            unset($_SESSION['pedido_id']);

            // 6. Redirección final
            header('Location: ?controller=pedido&action=confirmado');
            exit;

        } catch (Exception $e) {
            die('Error en Base de Datos: ' . $e->getMessage());
        }
    } else {
        die('Error: No se pudo mover el archivo al servidor.');
    }
    require __DIR__ . '/../views/user/carrito.php';
}
public function transferencia() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Gestión de la Imagen
        $nombreFoto = null;
        if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === 0) {
            $nombreFoto = time() . "_" . $_FILES['comprobante']['name'];
            $rutaDestino = 'public/uploads/comprobantes/' . $nombreFoto;
            
            if (!is_dir('public/uploads/comprobantes/')) {
                mkdir('public/uploads/comprobantes/', 0777, true);
            }
            move_uploaded_file($_FILES['comprobante']['tmp_name'], $rutaDestino);
        }

        try {
            $db = new PDO("sqlite:database/tienda_online.db");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();

            // 2. Crear Pedido (id_estado 1 = Pendiente)
            $stmt = $db->prepare("INSERT INTO pedidos (id_usuario, id_direccion, total, id_estado, paypal_order_id) VALUES (?, ?, ?, 1, ?)");
            $stmt->execute([
                $_SESSION['usuario']['id_usuario'], 
                $_SESSION['direccion_seleccionada'] ?? 1, 
                $_POST['monto'], 
                $_POST['referencia']
            ]);
            $idPedido = $db->lastInsertId();

            // 3. Registrar Pago con el nombre de la foto
            $stmtPago = $db->prepare("INSERT INTO pagos (id_pedido, metodo_pago, monto, comprobante) VALUES (?, 'transferencia', ?, ?)");
            $stmtPago->execute([$idPedido, $_POST['monto'], $nombreFoto]);

            $db->commit();

            // 4. EL PASO QUE BUSCAS: VACIAR CARRITO Y REDIRIGIR
            unset($_SESSION['carrito']);
            unset($_SESSION['total_carrito']);

            // Redirigir al historial para que vea su pedido "Pendiente"
            header("Location: index.php?controller=pedido&action=historial&msg=espera");
            exit();

        } catch (Exception $e) {
            if (isset($db)) $db->rollBack();
            die("Error técnico: " . $e->getMessage());
        }
    }
    require __DIR__ . '/../views/user/carrito.php';
}

}
