<?php
$title = "Productos";
ob_start();
?>

<style>
/* ==================== HERO CAROUSEL ==================== */
.hero-carousel {
    position: relative;
    height: 500px;
    overflow: hidden;
    border-radius: var(--radius-lg);
    margin: 2rem 0 3rem;
    box-shadow: var(--shadow-lg);
}

.carousel-slide {
    display: none;
    width: 100%;
    height: 100%;
    position: relative;
}

.carousel-slide.active {
    display: block;
    animation: fadeInSlide 0.6s ease-in;
}

@keyframes fadeInSlide {
    from { 
        opacity: 0;
        transform: scale(1.05);
    }
    to { 
        opacity: 1;
        transform: scale(1);
    }
}

.carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.carousel-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10, 10, 20, 0.85) 0%, rgba(0, 234, 255, 0.2) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.carousel-content {
    text-align: center;
    max-width: 800px;
}

.carousel-content h2 {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--primary-color);
    text-shadow: 0 0 30px rgba(0, 234, 255, 0.5);
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from {
        text-shadow: 0 0 20px rgba(0, 234, 255, 0.5), 0 0 30px rgba(0, 234, 255, 0.3);
    }
    to {
        text-shadow: 0 0 30px rgba(0, 234, 255, 0.8), 0 0 40px rgba(0, 234, 255, 0.5);
    }
}

.carousel-content p {
    font-size: clamp(1.1rem, 2.5vw, 1.5rem);
    margin-bottom: 2rem;
    color: var(--text-secondary);
}

.carousel-cta {
    display: inline-block;
    padding: 1rem 2.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    font-weight: 700;
    text-decoration: none;
    border-radius: 50px;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(0, 234, 255, 0.4);
}

.carousel-cta:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: var(--shadow-lg);
}

.carousel-controls {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 10;
}

.carousel-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    border: 2px solid rgba(0, 234, 255, 0.5);
    cursor: pointer;
    transition: var(--transition);
}

.carousel-dot.active {
    background: var(--primary-color);
    width: 40px;
    border-radius: 6px;
    box-shadow: 0 0 15px var(--primary-color);
}

.carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: var(--bg-card);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    width: 55px;
    height: 55px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    z-index: 10;
}

.carousel-arrow:hover {
    background: var(--primary-color);
    color: #000;
    transform: translateY(-50%) scale(1.15);
    box-shadow: 0 0 25px rgba(0, 234, 255, 0.6);
}

.carousel-arrow.prev { left: 30px; }
.carousel-arrow.next { right: 30px; }

/* ==================== FILTROS MEJORADOS ==================== */
.filters-section {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    padding: 2rem;
    border-radius: var(--radius-lg);
    margin-bottom: 3rem;
    box-shadow: var(--shadow-md);
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.filters-header h3 {
    color: var(--primary-color);
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.category-filters {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}

.filter-btn {
    padding: 0.7rem 1.5rem;
    background: var(--bg-dark);
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
    border-radius: 50px;
    cursor: pointer;
    transition: var(--transition);
    font-weight: 600;
    font-size: 0.95rem;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 234, 255, 0.2);
}

.filter-btn.active {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    border-color: var(--primary-color);
    box-shadow: 0 0 20px rgba(0, 234, 255, 0.4);
}

.sort-controls {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.sort-controls label {
    color: var(--text-secondary);
    font-weight: 600;
}

.sort-controls select {
    background: var(--bg-dark);
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    padding: 0.7rem 1.2rem;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 500;
    transition: var(--transition);
}

.sort-controls select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.1);
}

/* ==================== HEADER DE PRODUCTOS ==================== */
.productos-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.productos-header h2 {
    color: var(--primary-color);
    font-size: clamp(1.8rem, 3vw, 2.2rem);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
    background: var(--bg-card);
    padding: 0.4rem;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
}

.view-btn {
    background: transparent;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: var(--transition);
    font-size: 1.3rem;
    color: var(--text-secondary);
}

.view-btn:hover {
    background: var(--bg-dark);
    color: var(--primary-color);
}

.view-btn.active {
    background: var(--primary-color);
    color: #000;
    box-shadow: 0 0 15px rgba(0, 234, 255, 0.4);
}

/* ==================== GRID DE PRODUCTOS MEJORADO ==================== */
.productos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.producto-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
    position: relative;
    cursor: pointer;
}

.producto-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-color);
}

.producto-image-container {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: linear-gradient(135deg, var(--bg-dark) 0%, #1a1a2e 100%);
}

.producto-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.producto-card:hover img {
    transform: scale(1.15) rotate(2deg);
}

.producto-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.4);
    z-index: 5;
}

.producto-quick-view {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: all 0.4s ease;
    z-index: 10;
}

.producto-card:hover .producto-quick-view {
    opacity: 1;
}

.quick-view-btn {
    background: var(--bg-card);
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    padding: 0.9rem 1.8rem;
    border-radius: 50px;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
}

.quick-view-btn:hover {
    background: var(--primary-color);
    color: #000;
    transform: scale(1.1);
    box-shadow: 0 0 30px rgba(0, 234, 255, 0.6);
}

.producto-info {
    padding: 1.5rem;
}

.producto-categoria {
    color: var(--primary-color);
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.producto-card h3 {
    font-size: 1.2rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 600;
    line-height: 1.4;
    height: 2.8em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.producto-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.stars {
    color: var(--primary-color);
    font-size: 0.9rem;
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.5);
}

.rating-count {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.producto-precio-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}

.precio {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-color);
    margin: 0;
    text-shadow: 0 0 15px rgba(0, 234, 255, 0.3);
}

.precio-anterior {
    color: var(--text-secondary);
    text-decoration: line-through;
    font-size: 1.1rem;
    opacity: 0.7;
}

.stock-indicator {
    font-size: 0.85rem;
    color: var(--primary-color);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.stock-indicator::before {
    content: '●';
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.stock-indicator.low-stock {
    color: #ff4757;
}

.producto-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-primary {
    flex: 1;
    padding: 0.9rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    text-align: center;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn-icon {
    background: var(--bg-dark);
    border: 2px solid var(--border-color);
    width: 50px;
    height: 50px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 1.3rem;
    color: var(--text-secondary);
}

.btn-icon:hover {
    background: var(--primary-color);
    color: #000;
    border-color: var(--primary-color);
    transform: scale(1.1);
    box-shadow: 0 0 20px rgba(0, 234, 255, 0.4);
}

/* ==================== VISTA LISTA ==================== */
.productos-grid.list-view {
    grid-template-columns: 1fr;
}

.productos-grid.list-view .producto-card {
    display: flex;
    flex-direction: row;
}

.productos-grid.list-view .producto-image-container {
    width: 350px;
    height: auto;
    flex-shrink: 0;
}

.productos-grid.list-view .producto-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* ==================== ANIMACIONES DE ENTRADA ==================== */
.fade-in {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .hero-carousel {
        height: 350px;
        margin: 1rem 0 2rem;
    }

    .carousel-arrow {
        width: 45px;
        height: 45px;
        font-size: 1.5rem;
    }

    .carousel-arrow.prev { left: 15px; }
    .carousel-arrow.next { right: 15px; }

    .filters-section {
        padding: 1.5rem;
    }

    .productos-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .productos-grid.list-view .producto-card {
        flex-direction: column;
    }

    .productos-grid.list-view .producto-image-container {
        width: 100%;
        height: 250px;
    }
}

@media (max-width: 480px) {
    .productos-grid {
        grid-template-columns: 1fr;
    }

    .filters-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .sort-controls {
        width: 100%;
    }

    .sort-controls select {
        flex: 1;
    }
}
</style>

<!-- Hero Carousel -->
<div class="hero-carousel" id="heroCarousel">
    <div class="carousel-slide active">
        <img src="/img/hero1.jpg" alt="Oferta especial">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h2>✨ Nuevos Productos</h2>
                <p>Descubre nuestra última colección con tecnología de vanguardia</p>
                <a href="#productos" class="carousel-cta">Explorar Ahora</a>
            </div>
        </div>
    </div>

    <div class="carousel-slide">
        <img src="/img/hero2.jpg" alt="Promoción">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h2>🔥 Ofertas Exclusivas</h2>
                <p>Hasta 50% de descuento en productos seleccionados</p>
                <a href="#productos" class="carousel-cta">Ver Ofertas</a>
            </div>
        </div>
    </div>

    <div class="carousel-slide">
        <img src="/img/hero3.jpg" alt="Envío gratis">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h2>🚀 Envío Gratis</h2>
                <p>En compras superiores a $50 - Entrega rápida garantizada</p>
                <a href="#productos" class="carousel-cta">Comprar Ahora</a>
            </div>
        </div>
    </div>
</div>

    
    <button class="carousel-arrow prev" onclick="changeSlide(-1)">‹</button>
    <button class="carousel-arrow next" onclick="changeSlide(1)">›</button>
    
    <div class="carousel-controls">
        <button class="carousel-dot active" onclick="goToSlide(0)"></button>
        <button class="carousel-dot" onclick="goToSlide(1)"></button>
        <button class="carousel-dot" onclick="goToSlide(2)"></button>
    </div>
</div>

<!-- Filtros y Ordenamiento -->
<div class="filters-section">
    <div class="filters-header">
        <h3>🎯 Categorías</h3>
        <div class="sort-controls">
            <label for="sortProducts">Ordenar:</label>
            <select id="sortProducts" onchange="sortProducts(this.value)">
                <option value="default">Predeterminado</option>
                <option value="price-asc">Precio: Menor a Mayor</option>
                <option value="price-desc">Precio: Mayor a Menor</option>
                <option value="name-asc">Nombre: A-Z</option>
                <option value="newest">Más Recientes</option>
            </select>
        </div>
    </div>
    
   <div class="category-filters">

    <a href="/index.php?controller=producto&action=buscar"
       class="filter-btn <?= empty($_GET['categoria']) ? 'active' : '' ?>">
        Todos los Productos
    </a>

    <a href="/index.php?controller=producto&action=buscar&categoria=3"
       class="filter-btn <?= ($_GET['categoria'] ?? '') == 3 ? 'active' : '' ?>">
        Bisutería
    </a>

    <a href="/index.php?controller=producto&action=buscar&categoria=2"
       class="filter-btn <?= ($_GET['categoria'] ?? '') == 2 ? 'active' : '' ?>">
        Collares
    </a>

    <a href="/index.php?controller=producto&action=buscar&categoria=1"
       class="filter-btn <?= ($_GET['categoria'] ?? '') == 1 ? 'active' : '' ?>">
        Aretes
    </a>

    <a href="/index.php?controller=producto&action=buscar&categoria=4"
       class="filter-btn <?= ($_GET['categoria'] ?? '') == 4 ? 'active' : '' ?>">
        Manillas
    </a>

</div>

</div>

<!-- Header de Productos -->
<div class="productos-header" id="productos">
    <h2>🛍️ Nuestros Productos</h2>
    <div class="view-toggle">
        <button class="view-btn active" onclick="toggleView('grid')" title="Vista de cuadrícula">⊞</button>
        <button class="view-btn" onclick="toggleView('list')" title="Vista de lista">☰</button>
    </div>
</div>

<!-- Grid de Productos -->
<div class="productos-grid" id="productosGrid">
    <?php foreach ($productos as $p): ?>
        <div class="producto-card fade-in" 
             data-categoria="<?= htmlspecialchars($p['categoria'] ?? 'general') ?>" 
             data-precio="<?= $p['precio'] ?>" 
             data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
             style="animation-delay: <?= (array_search($p, $productos) * 0.05) ?>s">
            
            <div class="producto-image-container">
                <img src="<?= $p['imagen'] ?? '/img/no-image.png' ?>" 
                     alt="<?= htmlspecialchars($p['nombre']) ?>"
                     loading="lazy">
                
                <?php if (isset($p['descuento']) && $p['descuento'] > 0): ?>
                    <span class="producto-badge">-<?= $p['descuento'] ?>% OFF</span>
                <?php elseif (isset($p['nuevo']) && $p['nuevo']): ?>
                    <span class="producto-badge">✨ Nuevo</span>
                <?php endif; ?>
                
                <div class="producto-quick-view">
                    <button class="quick-view-btn" 
                            onclick="window.location.href='/?controller=producto&action=detalle&id=<?= $p['id_producto'] ?>'">
                        👁️ Vista Rápida
                    </button>
                </div>
            </div>
            
            <div class="producto-info">
                <?php if (isset($p['categoria_nombre'])): ?>
                    <div class="producto-categoria"><?= htmlspecialchars($p['categoria_nombre']) ?></div>
                <?php endif; ?>
                
                <h3><?= htmlspecialchars($p['nombre']) ?></h3>
                
                <div class="producto-rating">
                    <div class="stars">★★★★★</div>
                    <span class="rating-count">(<?= rand(10, 200) ?>)</span>
                </div>
                
                <div class="producto-precio-container">
                    <div>
                        <p class="precio">$<?= number_format($p['precio'], 2) ?></p>
                        <?php if (isset($p['precio_anterior'])): ?>
                            <span class="precio-anterior">$<?= number_format($p['precio_anterior'], 2) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="stock-indicator <?= $p['stock'] < 10 ? 'low-stock' : '' ?>">
                        <?php if ($p['stock'] > 0): ?>
                            <?= $p['stock'] < 10 ? '¡Últimas unidades!' : 'En stock' ?>
                        <?php else: ?>
                            Agotado
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="producto-actions">
                    <a href="/?controller=producto&action=detalle&id=<?= $p['id_producto'] ?>" 
                       class="btn-primary">
                        🛒 Ver Detalle
                    </a>
                    <button class="btn-icon" title="Agregar a favoritos">♡</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<script>
// ==================== CARRUSEL ====================
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');

function showSlide(n) {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    if (n >= slides.length) currentSlide = 0;
    if (n < 0) currentSlide = slides.length - 1;
    
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
}

function changeSlide(n) {
    currentSlide += n;
    showSlide(currentSlide);
}

function goToSlide(n) {
    currentSlide = n;
    showSlide(currentSlide);
}

// Auto-play del carrusel cada 5 segundos
setInterval(() => {
    currentSlide++;
    showSlide(currentSlide);
}, 5000);

// ==================== FILTRADO POR CATEGORÍA ====================
function filterCategory(categoria) {
    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.producto-card');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    cards.forEach((card, index) => {
        if (categoria === 'all' || card.dataset.categoria === categoria) {
            card.style.display = 'block';
            card.style.animation = `fadeInUp 0.6s ease forwards ${index * 0.05}s`;
        } else {
            card.style.display = 'none';
        }
    });
}

// ==================== ORDENAR PRODUCTOS ====================
function sortProducts(sortType) {
    const grid = document.getElementById('productosGrid');
    const cards = Array.from(grid.querySelectorAll('.producto-card'));
    
    cards.sort((a, b) => {
        switch(sortType) {
            case 'price-asc':
                return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
            case 'price-desc':
                return parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio);
            case 'name-asc':
                return a.dataset.nombre.localeCompare(b.dataset.nombre);
            default:
                return 0;
        }
    });
    
    cards.forEach(card => grid.appendChild(card));
}

// ==================== TOGGLE VISTA ====================
function toggleView(view) {
    const grid = document.getElementById('productosGrid');
    const buttons = document.querySelectorAll('.view-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    if (view === 'list') {
        grid.classList.add('list-view');
    } else {
        grid.classList.remove('list-view');
    }
}

// ==================== ANIMACIÓN DE ENTRADA ====================
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.producto-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
        }, index * 50);
    });
});
</script>



<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>