<?php
$usuario = $_SESSION['usuario'] ?? null;

$title = $usuario
    ? "Inicio - " . htmlspecialchars($usuario['nombre'])
    : "Inicio - Tienda de Ropa";

ob_start();
?>


<style>
/* ==================== VARIABLES ==================== */
:root {
    --primary-color: #00eaff;
    --primary-dark: #00b8cc;
    --bg-dark: #0a0a14;
    --bg-card: #111827;
    --border-color: #374151;
    --text-primary: #ffffff;
    --text-secondary: #9ca3af;
    --shadow-md: 0 4px 16px rgba(0, 234, 255, 0.2);
    --radius-md: 12px;
    --transition: all 0.3s ease;
}

/* ==================== BIENVENIDA ==================== */
.welcome-section {
    background: linear-gradient(135deg, rgba(0, 234, 255, 0.1), rgba(0, 234, 255, 0.05));
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 3rem 2rem;
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.welcome-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(0, 234, 255, 0.15), transparent);
    border-radius: 50%;
    pointer-events: none;
}

.welcome-title {
    font-size: clamp(2rem, 5vw, 3rem);
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    animation: fadeInUp 0.6s ease;
}

.welcome-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    animation: fadeInUp 0.8s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ==================== DASHBOARD CARDS ==================== */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.dashboard-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 2rem;
    text-align: center;
    transition: var(--transition);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    transform: scaleX(0);
    transition: var(--transition);
}

.dashboard-card:hover::before {
    transform: scaleX(1);
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 24px rgba(0, 234, 255, 0.3);
    border-color: var(--primary-color);
}

.card-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    filter: drop-shadow(0 0 10px var(--primary-color));
}

.card-title {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
}

.card-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.card-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 234, 255, 0.4);
}

/* ==================== SECTION TITLE ==================== */
.section-title {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* ==================== CARRUSEL ==================== */
.carousel-section {
    margin-bottom: 4rem;
}

.carousel-container {
    position: relative;
    overflow: hidden;
    padding: 1rem 0;
}

.carousel-track {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0.5rem;
}

.carousel-item {
    min-width: 280px;
    flex-shrink: 0;
}

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: var(--bg-card);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-size: 1.5rem;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: var(--transition);
}

.carousel-btn:hover {
    background: var(--primary-color);
    color: #000;
    transform: translateY(-50%) scale(1.1);
}

.carousel-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.carousel-btn.prev {
    left: 10px;
}

.carousel-btn.next {
    right: 10px;
}

/* ==================== PRODUCT CARD ==================== */
.product-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: var(--transition);
    box-shadow: var(--shadow-md);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(0, 234, 255, 0.3);
    border-color: var(--primary-color);
}

.product-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: var(--bg-dark);
    position: relative;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-dark);
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.product-card h3 {
    padding: 1rem 1rem 0.5rem;
    color: var(--text-primary);
    font-size: 1.1rem;
    line-height: 1.3;
    min-height: 3rem;
}

.product-card .price {
    padding: 0 1rem;
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.btn-view {
    margin: 0 1rem 1rem;
    padding: 0.75rem;
    background: rgba(0, 234, 255, 0.15);
    border: 1px solid var(--primary-color);
    color: var(--primary-color);
    text-decoration: none;
    text-align: center;
    border-radius: var(--radius-md);
    font-weight: 600;
    transition: var(--transition);
}

.btn-view:hover {
    background: var(--primary-color);
    color: #000;
}

/* ==================== PRODUCTS GRID ==================== */
.products-section {
    margin-bottom: 4rem;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
}

.btn-primary {
    margin: 0 1rem 1rem;
    padding: 0.875rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    text-decoration: none;
    text-align: center;
    border-radius: var(--radius-md);
    font-weight: 700;
    transition: var(--transition);
    display: block;
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 234, 255, 0.4);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .welcome-section {
        padding: 2rem 1rem;
    }

    .carousel-item {
        min-width: 240px;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
    }

    .carousel-btn {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- ==================== BIENVENIDA ==================== -->
<div class="welcome-section">
    <h1 class="welcome-title">
        <?php if ($usuario): ?>
            ¡Hola, <?= htmlspecialchars($usuario['nombre']) ?>! 👋
        <?php else: ?>
            ¡Bienvenido a Tienda de Ropa! 👋
        <?php endif; ?>
    </h1>

    <p class="welcome-subtitle">
        <?php if ($usuario): ?>
            Bienvenido a tu panel de usuario
        <?php else: ?>
            Explora nuestros productos sin registrarte
        <?php endif; ?>
    </p>
</div>


</div>

<!-- ==================== TARJETAS PRINCIPALES ==================== -->
<div class="dashboard-grid">
    <div class="dashboard-card card-primary">
        <div class="card-icon">🛒</div>
        <h3 class="card-title">Explorar Productos</h3>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
            Descubre nuestra colección completa
        </p>
        <a href="/?controller=producto&action=index" class="card-btn">
            Ver catálogo →
        </a>
    </div>

    <div class="dashboard-card card-secondary">
        <div class="card-icon">🛍️</div>
        <h3 class="card-title">Mi Carrito</h3>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
            <?php 
            $cartCount = count($_SESSION['carrito'] ?? []);
            echo $cartCount > 0 ? "$cartCount producto(s) en tu carrito" : "Tu carrito está vacío";
            ?>
        </p>
        <a href="/?controller=pedido&action=carrito" class="card-btn">
            Ver carrito →
        </a>
    </div>

    <div class="dashboard-card card-accent">
        <div class="card-icon">📦</div>
        <h3 class="card-title">Mis Pedidos</h3>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
            Revisa el estado de tus compras
        </p>
        <a href="/?controller=pedido&action=historial" class="card-btn">
            Ver historial →
        </a>
    </div>
</div>

<!-- ==================== CARRUSEL DE DESTACADOS ==================== -->
<?php if (!empty($productos)): ?>
<section class="carousel-section">
    <h2 class="section-title">🔥 Productos Destacados</h2>

    <div class="carousel-container">
        <button class="carousel-btn prev" onclick="moveCarousel(-1)" id="prevBtn">
            ❮
        </button>

        <div class="carousel-track" id="carouselTrack">
            <?php foreach (array_slice($productos, 0, 10) as $p): ?>
                <div class="carousel-item">
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (!empty($p['imagen'])): ?>
                                <img src="<?= htmlspecialchars($p['imagen']) ?>" 
                                     alt="<?= htmlspecialchars($p['nombre']) ?>">
                            <?php else: ?>
                                <div class="no-image">📷 Sin imagen</div>
                            <?php endif; ?>
                        </div>

                        <h3><?= htmlspecialchars($p['nombre']) ?></h3>
                        <p class="price">$<?= number_format($p['precio'], 2) ?></p>

                        <a href="/?controller=producto&action=detalle&id=<?= $p['id_producto'] ?>" 
                           class="btn-view">
                            Ver detalles
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-btn next" onclick="moveCarousel(1)" id="nextBtn">
            ❯
        </button>
    </div>
</section>
<?php endif; ?>

<!-- ==================== CATÁLOGO COMPLETO ==================== -->
<section class="products-section">
    <h2 class="section-title">🛒 Todos los Productos</h2>

    <?php if (!empty($productos)): ?>
        <div class="products-grid">
            <?php foreach ($productos as $p): ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if (!empty($p['imagen'])): ?>
                            <img src="<?= htmlspecialchars($p['imagen']) ?>" 
                                 alt="<?= htmlspecialchars($p['nombre']) ?>">
                        <?php else: ?>
                            <div class="no-image">📷 Sin imagen</div>
                        <?php endif; ?>
                    </div>

                    <h3><?= htmlspecialchars($p['nombre']) ?></h3>
                    <p class="price">$<?= number_format($p['precio'], 2) ?></p>

                    <a href="/?controller=producto&action=detalle&id=<?= $p['id_producto'] ?>" 
                       class="btn-primary">
                        Ver producto
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Estado vacío -->
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3>No hay productos disponibles</h3>
            <p>Vuelve pronto para ver nuestras novedades</p>
        </div>
    <?php endif; ?>
</section>

<!-- ==================== JAVASCRIPT ==================== -->
<script>
// ==================== CARRUSEL ====================
let position = 0;
const track = document.getElementById('carouselTrack');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

if (track) {
    const items = track.querySelectorAll('.carousel-item');
    const itemWidth = 280 + 24; // width + gap
    const containerWidth = track.parentElement.offsetWidth;
    const visibleItems = Math.floor(containerWidth / itemWidth);
    const maxPosition = Math.max(0, items.length - visibleItems);

    function updateCarousel() {
        track.style.transform = `translateX(-${position * itemWidth}px)`;
        
        // Deshabilitar botones en los extremos
        if (prevBtn) prevBtn.disabled = position === 0;
        if (nextBtn) nextBtn.disabled = position >= maxPosition;
    }

    window.moveCarousel = function(direction) {
        const newPosition = position + direction;
        
        if (newPosition >= 0 && newPosition <= maxPosition) {
            position = newPosition;
            updateCarousel();
        }
    };

    // Inicializar
    updateCarousel();

    // Actualizar en redimensión
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            position = 0;
            updateCarousel();
        }, 250);
    });
}

// ==================== SMOOTH SCROLL ====================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// ==================== ANIMACIONES AL SCROLL ====================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
        }
    });
}, observerOptions);

// Observar cards y secciones
document.querySelectorAll('.dashboard-card, .product-card').forEach(el => {
    observer.observe(el);
});
</script>


<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>