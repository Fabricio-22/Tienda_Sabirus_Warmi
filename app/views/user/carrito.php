<?php
$title = "Mi Carrito de Compras";
ob_start();

if (isset($_SESSION['pedido_transferencia'])) {
    header('Location: ?controller=pedido&action=confirmado');
    exit;
}

$carrito = $_SESSION['carrito'] ?? [];
$usuario = $_SESSION['usuario'] ?? null;

// Calcular totales
$subtotal = 0;
foreach ($carrito as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}

$envio = $subtotal > 50 ? 0 : 5.00;
$total = $subtotal + $envio;
?>

<style>
/* ==================== CARRITO CONTAINER ==================== */
.carrito-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

/* ==================== HEADER ==================== */
.carrito-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    flex-wrap: wrap;
    gap: 1rem;
}

.carrito-header h1 {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    color: var(--primary-color);
    margin: 0;
    text-shadow: 0 0 20px rgba(0, 234, 255, 0.3);
}

.btn-back {
    padding: 0.8rem 1.5rem;
    background: var(--bg-dark);
    color: var(--text-primary);
    text-decoration: none;
    border: 2px solid var(--border-color);
    border-radius: 50px;
    font-weight: 600;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-back:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateX(-3px);
}

/* ==================== EMPTY STATE ==================== */
.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-card);
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-lg);
    margin: 2rem 0;
}

.empty-icon {
    font-size: 6rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.empty-cart h2 {
    color: var(--text-primary);
    font-size: 2rem;
    margin-bottom: 1rem;
}

.empty-cart p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.empty-cart .btn-primary {
    display: inline-block;
    padding: 1rem 2.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(0, 234, 255, 0.4);
}

.empty-cart .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* ==================== LAYOUT PRINCIPAL ==================== */
.carrito-layout {
    display: grid;
    grid-template-columns: 1fr 450px;
    gap: 2rem;
    align-items: start;
}

/* ==================== PRODUCTOS SECTION ==================== */
.productos-section {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-md);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
}

.section-header h2 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin: 0;
}





/* ==================== PRODUCTOS LIST ==================== */
.productos-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.producto-item {
    display: grid;
    grid-template-columns: 100px 1fr auto auto auto;
    gap: 1.5rem;
    align-items: center;
    padding: 1.5rem;
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: var(--transition);
    position: relative;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.producto-item:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 20px rgba(0, 234, 255, 0.2);
}

.producto-imagen {
    width: 100px;
    height: 100px;
    border-radius: var(--radius-sm);
    overflow: hidden;
    border: 2px solid var(--border-color);
}

.producto-imagen img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.producto-item:hover .producto-imagen img {
    transform: scale(1.1);
}

.producto-info {
    flex: 1;
}

.producto-nombre {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.producto-precio {
    color: var(--primary-color);
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
}

/* ==================== CANTIDAD CONTROLS ==================== */
.producto-cantidad {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    border-radius: 50px;
    padding: 0.3rem;
}

.btn-qty {
    width: 35px;
    height: 35px;
    background: var(--bg-dark);
    color: var(--primary-color);
    border: none;
    border-radius: 50%;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-qty:hover {
    background: var(--primary-color);
    color: #000;
    transform: scale(1.1);
}

.qty-input {
    width: 50px;
    text-align: center;
    background: transparent;
    border: none;
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 700;
}

/* ==================== SUBTOTAL ==================== */
.producto-subtotal {
    text-align: right;
    min-width: 100px;
}

.producto-subtotal .label {
    display: block;
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin-bottom: 0.3rem;
}

.producto-subtotal .precio {
    display: block;
    color: var(--primary-color);
    font-size: 1.4rem;
    font-weight: 800;
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
}

/* ==================== BOTÓN ELIMINAR ==================== */




/* ==================== CHECKOUT SECTION ==================== */
.checkout-section {
    position: sticky;
    top: 2rem;
}

.checkout-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md);
}

.card-title {
    color: var(--primary-color);
    font-size: 1.2rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
}

/* ==================== RESUMEN ==================== */
.resumen-linea {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 0;
    color: var(--text-secondary);
    font-size: 1rem;
}

.resumen-linea span:last-child {
    color: var(--text-primary);
    font-weight: 600;
}

.envio-gratis {
    color: #22c55e !important;
    font-weight: 700 !important;
}

.envio-info {
    background: rgba(251, 191, 36, 0.15);
    border: 1px solid rgba(251, 191, 36, 0.3);
    color: #fbbf24;
    padding: 0.8rem;
    border-radius: var(--radius-sm);
    font-size: 0.9rem;
    margin: 1rem 0;
    text-align: center;
}

.resumen-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
    margin: 1rem 0;
}

.resumen-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    font-size: 1.2rem;
    font-weight: 700;
}

.total-precio {
    color: var(--primary-color);
    font-size: 2rem;
    font-weight: 800;
    text-shadow: 0 0 20px rgba(0, 234, 255, 0.4);
}

/* ==================== FORMULARIO ==================== */
.form-group {
    margin-bottom: 1.2rem;
}

.form-group label {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.9rem 1.2rem;
    background: var(--bg-dark);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.1);
}

.form-group input[readonly] {
    opacity: 0.6;
    cursor: not-allowed;
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* ==================== MÉTODOS DE PAGO ==================== */
.metodos-pago {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.metodo-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--bg-dark);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: var(--transition);
}

.metodo-item:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.2);
}

.metodo-item input[type="radio"] {
    margin-right: 1rem;
    width: 20px;
    height: 20px;
    accent-color: var(--primary-color);
}

.metodo-item input[type="radio"]:checked + .metodo-content {
    color: var(--primary-color);
}

.metodo-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.metodo-icon {
    font-size: 2rem;
}

.metodo-nombre {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.2rem;
}

.metodo-desc {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

/* ==================== TÉRMINOS ==================== */
.terminos-check {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.terminos-check label {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    color: var(--text-secondary);
    cursor: pointer;
}

.terminos-check input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: var(--primary-color);
}

.terminos-check a {
    color: var(--primary-color);
    text-decoration: none;
}

.terminos-check a:hover {
    text-decoration: underline;
}

/* ==================== BOTÓN CONFIRMAR ==================== */
.btn-confirmar {
    width: 100%;
    padding: 1.2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    border: none;
    border-radius: var(--radius-md);
    font-size: 1.1rem;
    font-weight: 800;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(0, 234, 255, 0.4);
    margin-bottom: 1rem;
}

.btn-confirmar:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.seguridad-info {
    text-align: center;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1024px) {
    .carrito-layout {
        grid-template-columns: 1fr;
    }
    
    .checkout-section {
        position: static;
    }
}

@media (max-width: 768px) {
    .carrito-container {
        padding: 1rem;
    }
    
    .producto-item {
        grid-template-columns: 80px 1fr;
        gap: 1rem;
    }
    
    .producto-imagen {
        width: 80px;
        height: 80px;
    }
    
    .producto-cantidad,
    .producto-subtotal {
        grid-column: 2;
    }
    
    .btn-eliminar {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .carrito-header {
        flex-direction: column;
        text-align: center;
    }
    
    .producto-item {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .producto-imagen {
        margin: 0 auto;
    }
    
    .producto-cantidad {
        justify-content: center;
    }
}

/* REPARACIÓN DE CLIC PARA BOTONES */
.btn-vaciar, .btn-eliminar {
    cursor: pointer !important;
    position: relative;
    z-index: 50 !important; /* Elevamos el botón sobre cualquier otra capa */
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    pointer-events: auto !important; /* Forzamos que acepte eventos */
}

    /* El contenido interno NO debe interferir */
.btn-vaciar span, .btn-eliminar span {
    pointer-events: none !important;
}

/* Estilo específico para eliminar para que no se pierda en el grid */
.btn-eliminar {
    min-width: 45px;
    min-height: 45px;
}

</style>

<div class="carrito-container">
    
    <!-- Header -->
    <div class="carrito-header">
        <h1>🛒 Mi Carrito de Compras</h1>
        <a href="/?controller=producto&action=index" class="btn-back">
            ← Seguir comprando
        </a>
    </div>

    <?php if (empty($carrito)): ?>
        <!-- Carrito Vacío -->
        <div class="empty-cart">
            <div class="empty-icon">🛒</div>
            <h2>Tu carrito está vacío</h2>
            <p>¡Explora nuestros productos y empieza a llenar tu carrito!</p>
            <a href="/?controller=producto&action=index" class="btn-primary">
                🛍️ Ver Productos
            </a>
        </div>

    <?php else: ?>
        <!-- Layout Principal -->
        <div class="carrito-layout">
            
            <!-- Productos Section -->
            <div class="productos-section">
                <div class="section-header">
                    <h2>Productos (<?= count($carrito) ?>)</h2>
                   <a href="index.php?controller=pedido&action=vaciarCarrito" 
   class="btn-vaciar" 
   style="pointer-events: auto !important;"
   onclick="return confirm('¿Estás seguro de vaciar todo el carrito?')">
   <span>🗑️ Vaciar carrito</span>
</a>



                </div>

                <div class="productos-list">
                    <?php foreach ($carrito as $key => $item): ?>
                        <div class="producto-item" data-key="<?= $key ?>">
                            <!-- Imagen -->
                            <div class="producto-imagen">
                                <img src="<?= htmlspecialchars($item['imagen'] ?? '/img/no-image.png') ?>" 
                                     alt="<?= htmlspecialchars($item['nombre']) ?>">
                            </div>

                            <!-- Info -->
                            <div class="producto-info">
                                <h3 class="producto-nombre">
                                    <?= htmlspecialchars($item['nombre']) ?>
                                </h3>
                                <p class="producto-precio">
                                    $<?= number_format($item['precio'], 2) ?>
                                </p>
                            </div>

                            <!-- Cantidad -->
                            <div class="producto-cantidad">
                                <button class="btn-qty" onclick="cambiarCantidad(<?= $key ?>, -1)">−</button>
                                <input type="number" 
                                       value="<?= $item['cantidad'] ?>" 
                                       class="qty-input"
                                       readonly>
                                <button class="btn-qty" onclick="cambiarCantidad(<?= $key ?>, 1)">+</button>
                            </div>

                            <!-- Subtotal -->
                            <div class="producto-subtotal">
                                <span class="label">Subtotal:</span>
                                <span class="precio">
                                    $<?= number_format($item['precio'] * $item['cantidad'], 2) ?>
                                </span>
                            </div>

                            <!-- Eliminar -->
                            <a href="index.php?controller=pedido&action=eliminar&key=<?= $key ?>" 
   class="btn-eliminar" 
   style="text-decoration: none; display: flex; align-items: center; justify-content: center;"
   onclick="return confirm('¿Eliminar este producto?')">
   <span style="pointer-events: none;">🗑️</span>
</a>


                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Checkout Section -->
            <div class="checkout-section">
                <form method="POST"
                  action="/?controller=pedido&action=confirmar"
                  class="checkout-form"
                   id="checkoutForm"
                    enctype="multipart/form-data">


                    <!-- Resumen del Pedido -->
                    <div class="checkout-card">
                        <h3 class="card-title">📋 Resumen del Pedido</h3>
                        
                        <div class="resumen-linea">
                            <span>Subtotal</span>
                            <span>$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        
                        <div class="resumen-linea">
                            <span>Envío</span>
                            <span class="<?= $envio == 0 ? 'envio-gratis' : '' ?>">
                                <?= $envio == 0 ? '🎉 ¡GRATIS!' : '$' . number_format($envio, 2) ?>
                            </span>
                        </div>

                        <?php if ($subtotal < 50): ?>
                            <div class="envio-info">
                                💡 Agrega $<?= number_format(50 - $subtotal, 2) ?> más para envío gratis
                            </div>
                        <?php endif; ?>
                        
                        <div class="resumen-divider"></div>
                        
                        <div class="resumen-total">
                            <span>Total</span>
                            <span class="total-precio">$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>

                    <!-- Datos de Envío -->
                    <div class="checkout-card">
                        <h3 class="card-title">📍 Datos de Envío</h3>
                        
                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" 
                                   id="nombre"
                                   name="nombre"
                                   value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>"
                                   required
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" 
                                   id="telefono"
                                   name="telefono"
                                   value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"
                                   placeholder="+593 999 999 999"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección de entrega</label>
                            <textarea id="direccion"
                                      name="direccion"
                                      placeholder="Calle, número, barrio..."
                                      required></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" 
                                       id="ciudad"
                                       name="ciudad"
                                       placeholder="Ej: Ambato"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="codigo_postal">Código Postal</label>
                                <input type="text" 
                                       id="codigo_postal"
                                       name="codigo_postal"
                                       placeholder="Ej: 180101">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Método de Pago -->
                    
    
    <div class="checkout-card">
        <h3 class="card-title">💳 Método de Pago</h3>
        <div class="metodos-pago">

            <label class="metodo-item">
                <input type="radio" name="metodo_pago" value="paypal" id="pagoPaypal">
                <div class="metodo-content">
                    <span class="metodo-icon">🅿️</span>
                    <div>
                        <div class="metodo-nombre">PayPal</div>
                        <div class="metodo-desc">Pago seguro con PayPal</div>
                    </div>
                </div>
            </label>

            <div id="paypal-container" style="display:none; margin-top:15px;">
                <div id="paypal-button-container"></div>
            </div>

            <label class="metodo-item">
                <input type="radio" name="metodo_pago" value="transferencia" id="pagoTransferencia">
                <div class="metodo-content">
                    <span class="metodo-icon">🏦</span>
                    <div>
                        <div class="metodo-nombre">Transferencia Bancaria</div>
                        <div class="metodo-desc">Pago directo a cuenta</div>
                    </div>
                </div>
            </label>

           <!-- INFO TRANSFERENCIA -->
    <div id="transferencia-info" style="display:none; margin-top:15px;">
        <h4>Datos para Transferencia</h4>

        <p><strong>Banco:</strong> Banco Pichincha</p>
        <p><strong>Cuenta:</strong> 1234567890</p>
        <p><strong>Titular:</strong> Juan Pérez</p>

        <p><strong>Monto:</strong> $<?= number_format($total, 2) ?></p>

        <label>Subir comprobante:</label>
        <input type="file" name="comprobante" id="file-comprobante" accept="image/*">

    </div>
            <label class="metodo-item">
                <input type="radio" name="metodo_pago" value="contraentrega">
                <div class="metodo-content">
                    <span class="metodo-icon">💵</span>
                    <div>
                        <div class="metodo-nombre">Pago Contra Entrega</div>
                        <div class="metodo-desc">Paga al recibir tu pedido</div>
                    </div>
                </div>
            </label>
        </div>
    </div>



    <!-- BOTÓN ÚNICO -->
    <button type="submit" class="btn-confirmar">
        ✅ Confirmar Pedido
    </button>

</form>
    <?php endif; ?>

</div>

<script>
// Cambiar cantidad
function cambiarCantidad(key, cambio) {
    const input = document.querySelector(`[data-key="${key}"] .qty-input`);
    let cantidad = parseInt(input.value) + cambio;

    if (cantidad < 1) cantidad = 1;
    
    // Ruta corregida sin la barra inicial "/"
    window.location.href = `index.php?controller=pedido&action=actualizarCantidad&key=${key}&cantidad=${cantidad}`;
}

// Eliminar producto
function eliminarProducto(key) {
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        // Usamos la ruta relativa al archivo actual
        window.location.href = `?controller=pedido&action=eliminar&key=${key}`;
    }
}

function vaciarCarrito() {
    if (confirm('¿Estás seguro de vaciar todo el carrito?')) {
        window.location.href = `?controller=pedido&action=vaciarCarrito`;
    }
}

// ... El resto de tu código de validación del formulario se mantiene igual ...
const checkoutForm = document.getElementById('checkoutForm');
if (checkoutForm) {
    checkoutForm.addEventListener('submit', function (e) {
        // ... (tus validaciones existentes)
        return true;
    });
}

</script>
<!-- SDK PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id=ASuXch-VlMQcbRtg8oGtFygn11Fmmwa5-VQt6iA5zVI2JMWmrS63qtu06HZrhc4aQjORAEKWhSEXX8jX&currency=USD"></script>

<script>
let paypalRendered = false;

document.querySelectorAll('input[name="metodo_pago"]').forEach(radio => {
    radio.addEventListener('change', function () {

        const paypalContainer = document.getElementById('paypal-container');
        const btnConfirmar = document.querySelector('.btn-confirmar');

        if (this.value === 'paypal') {
            paypalContainer.style.display = 'block';
            btnConfirmar.style.display = 'none';

            if (!paypalRendered) {
                renderPaypal();
                paypalRendered = true;
            }

        } else {
            paypalContainer.style.display = 'none';
            btnConfirmar.style.display = 'block';
        }
    });
});

function renderPaypal() {

    if (typeof paypal === 'undefined') {
        console.error('PayPal SDK no cargado');
        return;
    }

    paypal.Buttons({

        createOrder() {
            return fetch('?controller=pago&action=crearOrden', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    total: <?= number_format($total, 2, '.', '') ?>
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log('RESPUESTA crearOrden:', data);

                if (!data.id) {
                    throw new Error(data.error || 'PayPal no devolvió orderID');
                }

                return data.id;
            })
            .catch(err => {
                console.error('ERROR crearOrden:', err);
                alert('Error PayPal:\n' + err.message);
                throw err;
            });
        },

        onApprove(data) {
            return fetch('?controller=pago&action=confirmarPago', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ orderID: data.orderID })
            })
            .then(res => res.json())
            .then(resp => {
                console.log('RESPUESTA confirmarPago:', resp);

                if (resp.status !== 'COMPLETED') {
                    throw new Error('Pago no completado');
                }

                window.location.href = '?controller=pedido&action=confirmado';
            })
            .catch(err => {
                console.error('ERROR confirmarPago:', err);
                alert('Error al confirmar pago\n' + err.message);
            });
        },

        onError(err) {
    console.error('PayPal onError DETALLE:', JSON.stringify(err, null, 2));
    alert('Error PayPal:\nRevisa la consola (F12)');
}


    }).render('#paypal-button-container');

    
}
</script>

<script>
document.querySelectorAll('input[name="metodo_pago"]').forEach(radio => {
    radio.addEventListener('change', function () {

        const transferenciaBox = document.getElementById('transferencia-info');
        const paypalBox = document.getElementById('paypal-container');
        const fileInput = document.getElementById('file-comprobante');
        const btnConfirmar = document.querySelector('.btn-confirmar');

        // Reset
        if (transferenciaBox) transferenciaBox.style.display = 'none';
        if (paypalBox) paypalBox.style.display = 'none';
        if (fileInput) fileInput.required = false;
        if (btnConfirmar) btnConfirmar.style.display = 'block';

        if (this.value === 'transferencia') {
            // Transferencia bancaria
            if (transferenciaBox) transferenciaBox.style.display = 'block';
            if (fileInput) fileInput.required = true;

        } else if (this.value === 'paypal') {
            // PayPal
            if (paypalBox) paypalBox.style.display = 'block';
            if (btnConfirmar) btnConfirmar.style.display = 'none';
        }
    });
});
</script>


<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>