<?php
$title = htmlspecialchars($producto['nombre']) . " | Tienda Online";
ob_start();
?>
<style>
/* ==================== VARIABLES ==================== */
:root {
    --primary-color: #00eaff;
    --primary-dark: #00b8cc;
    --bg-dark: #0a0a14;
    --bg-card: #111827;
    --bg-card-hover: #1f2937;
    --border-color: #374151;
    --text-primary: #ffffff;
    --text-secondary: #9ca3af;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
    --shadow-md: 0 4px 16px rgba(0, 234, 255, 0.2);
    --shadow-lg: 0 8px 24px rgba(0, 234, 255, 0.3);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --transition: all 0.3s ease;
}

/* ==================== BREADCRUMB ==================== */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
    transition: var(--transition);
}

.breadcrumb a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

.breadcrumb span {
    color: var(--text-secondary);
}

/* ==================== BACK BUTTON ==================== */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    color: var(--primary-color);
    border: 2px solid var(--border-color);
    padding: 0.75rem 1.25rem;
    border-radius: var(--radius-md);
    transition: var(--transition);
    text-decoration: none;
    font-weight: 500;
}

.btn-back:hover {
    background: rgba(0, 234, 255, 0.1);
    border-color: var(--primary-color);
    transform: translateX(-5px);
}

/* ==================== CONTENEDOR PRINCIPAL ==================== */
.product-detail-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.product-detail-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-top: 1rem;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}

/* ==================== GALERÍA DE IMÁGENES ==================== */
.product-gallery {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.product-main-image {
    position: relative;
    background: var(--bg-dark);
    border-radius: var(--radius-md);
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid var(--border-color);
}

.product-main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.product-main-image:hover img {
    transform: scale(1.05);
}

.image-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--primary-color);
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.875rem;
    box-shadow: var(--shadow-md);
}

.zoom-hint {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.7);
    color: var(--text-primary);
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* ==================== INFORMACIÓN DEL PRODUCTO ==================== */
.product-detail-info {
    display: flex;
    flex-direction: column;
}

.product-category {
    display: inline-block;
    color: var(--primary-color);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}

.product-detail-info h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    color: var(--text-primary);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.stars {
    color: #fbbf24;
    font-size: 1.1rem;
}

.rating-count {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.product-price-section {
    background: linear-gradient(135deg, rgba(0, 234, 255, 0.1), rgba(0, 234, 255, 0.05));
    border: 1px solid rgba(0, 234, 255, 0.3);
    border-radius: var(--radius-md);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.product-price {
    color: var(--primary-color);
    font-size: clamp(2rem, 5vw, 2.5rem);
    font-weight: 700;
    margin: 0;
}

.price-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.original-price {
    color: var(--text-secondary);
    text-decoration: line-through;
    font-size: 1.2rem;
    margin-left: 1rem;
}

.discount-badge {
    display: inline-block;
    background: #ef4444;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-left: 1rem;
}

/* ==================== DESCRIPCIÓN ==================== */
.product-description-section {
    margin-bottom: 2rem;
}

.section-title {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.product-description {
    font-size: 1rem;
    line-height: 1.8;
    color: var(--text-secondary);
}

/* ==================== CARACTERÍSTICAS ==================== */
.product-features {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--bg-dark);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-color);
}

.feature-icon {
    font-size: 1.5rem;
}

.feature-text {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

/* ==================== ACCIONES ==================== */
.product-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: auto;
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.quantity-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 0.25rem;
}

.quantity-btn {
    background: none;
    border: none;
    color: var(--primary-color);
    font-size: 1.5rem;
    width: 36px;
    height: 36px;
    cursor: pointer;
    border-radius: var(--radius-sm);
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background: rgba(0, 234, 255, 0.1);
}

.quantity-input {
    width: 60px;
    text-align: center;
    background: none;
    border: none;
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
}

.btn-primary-big {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    color: #000;
    padding: 1.25rem 2rem;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 1.1rem;
    transition: var(--transition);
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-primary-big::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
}

.btn-primary-big:hover::before {
    left: 100%;
}

.btn-primary-big:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-secondary {
    background: transparent;
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    padding: 1rem 2rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 1rem;
    transition: var(--transition);
    cursor: pointer;
    text-decoration: none;
    text-align: center;
}

.btn-secondary:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

/* ==================== INFO ADICIONAL ==================== */
.product-info-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 3rem;
}

.info-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 1.5rem;
    text-align: center;
    transition: var(--transition);
}

.info-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.info-card-icon {
    font-size: 2rem;
    margin-bottom: 0.75rem;
}

.info-card-title {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.info-card-text {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 968px) {
    .product-detail-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .product-info-cards {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .product-detail-wrapper {
        padding: 1rem;
    }

    .product-detail-container {
        padding: 1.5rem;
    }

    .product-features {
        grid-template-columns: 1fr;
    }

    .quantity-selector {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="product-detail-wrapper">
    <!-- Breadcrumb -->
<nav class="breadcrumb">
    <a href="/?controller=usuario&action=home">Inicio</a>
    <span>›</span>
    <a href="/?controller=usuario&action=home">Productos</a>
    <span>›</span>
    <span><?= htmlspecialchars($producto['nombre']) ?></span>
</nav>


    <a href="/?controller=usuario&action=home" class="btn-back">
    ← Volver al catálogo
</a>


    <!-- Contenedor Principal -->
    <div class="product-detail-container">
        
        <!-- Galería de Imágenes -->
        <div class="product-gallery">
            <div class="product-main-image">
                <img src="<?= htmlspecialchars($producto['imagen'] ?: '/img/no-image.png') ?>" 
                     alt="<?= htmlspecialchars($producto['nombre']) ?>">
                
                <!-- Badge de Nuevo/Oferta (opcional) -->
                <?php if (isset($producto['nuevo']) && $producto['nuevo']): ?>
                    <span class="image-badge">✨ Nuevo</span>
                <?php endif; ?>
                
                <div class="zoom-hint">
                    🔍 Hover para zoom
                </div>
            </div>
        </div>

        <!-- Información del Producto -->
        <div class="product-detail-info">
            
            <!-- Categoría -->
            <span class="product-category">
                <?= isset($producto['categoria']) ? htmlspecialchars($producto['categoria']) : 'Ropa' ?>
            </span>

            <!-- Título -->
            <h1><?= htmlspecialchars($producto['nombre']) ?></h1>

            <!-- Rating (opcional) -->
            <div class="product-rating">
                <span class="stars">★★★★★</span>
                <span class="rating-count">(48 valoraciones)</span>
            </div>

            <!-- Precio -->
            <div class="product-price-section">
                <div class="price-label">Precio</div>
                <div>
                    <span class="product-price">
                        $<?= number_format($producto['precio'], 2) ?>
                    </span>
                    <!-- Precio original y descuento (opcional) -->
                    <!-- <span class="original-price">$89.99</span>
                    <span class="discount-badge">-20%</span> -->
                </div>
            </div>

            <!-- Descripción -->
            <div class="product-description-section">
                <h3 class="section-title">Descripción</h3>
                <p class="product-description">
                    <?= nl2br(htmlspecialchars($producto['descripcion'] ?: 'Prenda de alta calidad, perfecta para cualquier ocasión. Confeccionada con materiales premium que garantizan comodidad y durabilidad.')) ?>
                </p>
            </div>

            <!-- Características -->
            <div class="product-features">
                <div class="feature-item">
                    <span class="feature-icon">✅</span>
                    <span class="feature-text">Envío gratis</span>
                </div>
                
                <div class="feature-item">
                    <span class="feature-icon">🏆</span>
                    <span class="feature-text">Calidad garantizada</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">📦</span>
                    <span class="feature-text">Disponible en stock</span>
                </div>
            </div>

            <!-- Acciones -->
            <div class="product-actions">
                <!-- Selector de Cantidad -->
                <div class="quantity-selector">
                    <span class="quantity-label">Cantidad:</span>
                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                        <input type="number" 
                               id="quantity" 
                               class="quantity-input" 
                               value="1" 
                               min="1" 
                               max="10" 
                               readonly>
                        <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                    </div>
                </div>

                <!-- Botones de Acción -->
<?php if (!isset($_SESSION['usuario'])): ?>
    <a href="/?controller=usuario&action=login" class="btn-primary-big">
        🔐 Inicia sesión para comprar
    </a>
<?php else: ?>
    <button class="btn-primary-big"
        onclick="addToCart(<?= $producto['id_producto'] ?>)">
    🛒 Agregar al carrito
</button>


    
<?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Tarjetas de Información Adicional -->
    <div class="product-info-cards">
        <div class="info-card">
            <div class="info-card-icon">🚚</div>
            <h4 class="info-card-title">Envío Rápido</h4>
            <p class="info-card-text">Entrega en 2-5 días hábiles</p>
        </div>
        
        <div class="info-card">
            <div class="info-card-icon">🔒</div>
            <h4 class="info-card-title">Pago Seguro</h4>
            <p class="info-card-text">Protección SSL en todas las transacciones</p>
        </div>
        
        <div class="info-card">
            <div class="info-card-icon">💬</div>
            <h4 class="info-card-title">Soporte 24/7</h4>
            <p class="info-card-text">Atención al cliente siempre disponible</p>
        </div>
    </div>
</div>

<script>
// ==================== CANTIDAD ====================
function increaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < parseInt(input.max)) {
        input.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > parseInt(input.min)) {
        input.value = currentValue - 1;
    }
}

// ==================== AÑADIR AL CARRITO ====================
function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    // Aquí puedes agregar la lógica para enviar la cantidad
    // Por ejemplo, modificar el href del botón o hacer una petición AJAX
    
    console.log(`Agregando ${quantity} unidad(es) del producto ${productId}`);
    
    // Mostrar notificación (opcional)
    showNotification('✅ Producto agregado al carrito');
    
    return true; // Permite que el enlace funcione normalmente
}

// ==================== FAVORITOS ====================
function toggleWishlist() {
    const btn = event.target;
    const isAdded = btn.textContent.includes('❤️');
    
    if (isAdded) {
        btn.textContent = '🤍 Añadir a favoritos';
        showNotification('Eliminado de favoritos');
    } else {
        btn.textContent = '❤️ En favoritos';
        showNotification('✅ Agregado a favoritos');
    }
}

// ==================== NOTIFICACIÓN ====================
function showNotification(message) {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #00eaff, #00b8cc);
        color: #000;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(0, 234, 255, 0.4);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Agregar estilos de animación
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>