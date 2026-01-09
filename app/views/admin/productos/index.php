<?php
$title = 'Gestión de Productos';
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
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
    --shadow-md: 0 4px 16px rgba(0, 234, 255, 0.2);
    --radius-md: 12px;
    --transition: all 0.3s ease;
}

/* ==================== CONTENEDOR ==================== */
.productos-section {
    padding: 2rem;
}

/* ==================== HEADER ==================== */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2rem;
    color: var(--primary-color);
    margin: 0;
}

.btn-nuevo {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 700;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.btn-nuevo:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 234, 255, 0.4);
}

/* ==================== FILTROS Y BÚSQUEDA ==================== */
.filters-bar {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 300px;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: var(--text-secondary);
}

.search-box input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: var(--transition);
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.1);
}

.filter-select {
    padding: 0.875rem 1rem;
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    font-size: 0.95rem;
    cursor: pointer;
    transition: var(--transition);
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
}

/* ==================== GRID DE PRODUCTOS ==================== */
.productos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

/* ==================== CARD DE PRODUCTO ==================== */
.producto-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-md);
}

.producto-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(0, 234, 255, 0.3);
    border-color: var(--primary-color);
}

/* Imagen */
.producto-image {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: var(--bg-dark);
}

.producto-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.producto-card:hover .producto-image img {
    transform: scale(1.05);
}

.producto-id {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    background: rgba(0, 0, 0, 0.8);
    color: var(--primary-color);
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
}

.stock-badge {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    padding: 0.375rem 0.875rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    backdrop-filter: blur(10px);
}

.stock-badge.bajo {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.stock-badge.medio {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.stock-badge.alto {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

/* Contenido */
.producto-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.producto-categoria {
    color: var(--primary-color);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.producto-nombre {
    font-size: 1.25rem;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-weight: 700;
    line-height: 1.3;
}

.producto-descripcion {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Footer */
.producto-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-color);
    background: rgba(0, 0, 0, 0.2);
}

.producto-precio {
    font-size: 1.75rem;
    color: var(--primary-color);
    font-weight: 700;
}

.producto-stock {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.producto-stock strong {
    color: var(--text-primary);
}

/* Acciones */
.producto-actions {
    display: flex;
    gap: 0.5rem;
    padding: 0 1.5rem 1.5rem;
}

.btn-action {
    flex: 1;
    padding: 0.75rem;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-editar {
    background: rgba(0, 234, 255, 0.15);
    border: 1px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-editar:hover {
    background: var(--primary-color);
    color: #000;
    transform: translateY(-2px);
}

.btn-eliminar {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid var(--error-color);
    color: var(--error-color);
}

.btn-eliminar:hover {
    background: var(--error-color);
    color: white;
    transform: translateY(-2px);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-state-icon {
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

/* ==================== ALERTAS ==================== */
.alert {
    padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.4s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid var(--success-color);
    color: var(--success-color);
}

.alert-error {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid var(--error-color);
    color: var(--error-color);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .productos-section {
        padding: 1rem;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .productos-grid {
        grid-template-columns: 1fr;
    }

    .search-box {
        min-width: 100%;
    }
}

@media (max-width: 480px) {
    .producto-actions {
        flex-direction: column;
    }

    .btn-action {
        width: 100%;
    }
}
</style>

<div class="productos-section">
    <!-- Header -->
    <div class="section-header">
        <h1 class="section-title">Gestión de Productos</h1>
        <a href="/?controller=producto&action=crear" class="btn-nuevo">
            ➕ Nuevo Producto
        </a>
    </div>

    <!-- Alertas -->
    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch($_GET['success']) {
                case 'producto_creado':
                    echo '✅ Producto creado exitosamente';
                    break;
                case 'producto_actualizado':
                    echo '✅ Producto actualizado exitosamente';
                    break;
                case 'producto_eliminado':
                    echo '✅ Producto eliminado exitosamente';
                    break;
                default:
                    echo '✅ Operación exitosa';
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ⚠️ Error: No se pudo completar la operación
        </div>
    <?php endif; ?>

    <!-- Filtros y Búsqueda -->
    <div class="filters-bar">
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" 
                   id="searchProducts" 
                   placeholder="Buscar productos..."
                   onkeyup="filterProducts()">
        </div>
        
        <select class="filter-select" id="categoryFilter" onchange="filterByCategory()">
            <option value="">Todas las categorías</option>
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['nombre']) ?>">
                        <?= htmlspecialchars($cat['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <select class="filter-select" id="stockFilter" onchange="filterByStock()">
            <option value="">Todos los stocks</option>
            <option value="bajo">Stock Bajo (≤10)</option>
            <option value="medio">Stock Medio (11-50)</option>
            <option value="alto">Stock Alto (>50)</option>
        </select>
    </div>

    <!-- Grid de Productos -->
    <?php if (!empty($productos)): ?>
        <div class="productos-grid" id="productosGrid">
            <?php foreach ($productos as $producto): ?>
                <?php
                // Calcular nivel de stock
                $stock = $producto['stock'];
                $stockNivel = $stock <= 10 ? 'bajo' : ($stock <= 50 ? 'medio' : 'alto');
                $stockTexto = $stock <= 10 ? 'Stock Bajo' : ($stock <= 50 ? 'Stock Medio' : 'Stock Alto');
                ?>
                
                <div class="producto-card" 
                     data-nombre="<?= strtolower(htmlspecialchars($producto['nombre'])) ?>"
                     data-categoria="<?= strtolower(htmlspecialchars($producto['categoria_nombre'] ?? '')) ?>"
                     data-stock="<?= $stockNivel ?>">
                    
                    <!-- Imagen -->
                    <div class="producto-image">
                        <img src="<?= htmlspecialchars($producto['imagen'] ?: '/img/no-image.png') ?>" 
                             alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        
                        <span class="producto-id">#<?= $producto['id_producto'] ?></span>
                        <span class="stock-badge <?= $stockNivel ?>">
                            <?= $stockTexto ?>
                        </span>
                    </div>

                    <!-- Contenido -->
                    <div class="producto-content">
                        <?php if (!empty($producto['categoria_nombre'])): ?>
                            <div class="producto-categoria">
                                <?= htmlspecialchars($producto['categoria_nombre']) ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="producto-nombre">
                            <?= htmlspecialchars($producto['nombre']) ?>
                        </h3>

                        <?php if (!empty($producto['descripcion'])): ?>
                            <p class="producto-descripcion">
                                <?= htmlspecialchars($producto['descripcion']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Footer con precio -->
                    <div class="producto-footer">
                        <div>
                            <div class="producto-precio">
                                $<?= number_format($producto['precio'], 2) ?>
                            </div>
                            <div class="producto-stock">
                                Stock: <strong><?= $producto['stock'] ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="producto-actions">
                        <a href="/?controller=producto&action=edit&id=<?= $producto['id_producto'] ?>" 
                           class="btn-action btn-editar">
                            ✏️ Editar
                        </a>
                        <button onclick="confirmarEliminar(<?= $producto['id_producto'] ?>, '<?= htmlspecialchars($producto['nombre']) ?>')" 
                                class="btn-action btn-eliminar">
                            🗑️ Eliminar
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Estado vacío -->
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <h3>No hay productos</h3>
            <p>Comienza agregando tu primer producto</p>
            <a href="/?controller=producto&action=crear" class="btn-nuevo">
                ➕ Crear Producto
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
// ==================== BÚSQUEDA ====================
function filterProducts() {
    const searchTerm = document.getElementById('searchProducts').value.toLowerCase();
    const cards = document.querySelectorAll('.producto-card');
    
    cards.forEach(card => {
        const nombre = card.getAttribute('data-nombre');
        const matches = nombre.includes(searchTerm);
        card.style.display = matches ? 'flex' : 'none';
    });
}

// ==================== FILTRO POR CATEGORÍA ====================
function filterByCategory() {
    const category = document.getElementById('categoryFilter').value.toLowerCase();
    const cards = document.querySelectorAll('.producto-card');
    
    cards.forEach(card => {
        const cardCategory = card.getAttribute('data-categoria');
        const matches = !category || cardCategory.includes(category);
        card.style.display = matches ? 'flex' : 'none';
    });
}

// ==================== FILTRO POR STOCK ====================
function filterByStock() {
    const stockLevel = document.getElementById('stockFilter').value;
    const cards = document.querySelectorAll('.producto-card');
    
    cards.forEach(card => {
        const cardStock = card.getAttribute('data-stock');
        const matches = !stockLevel || cardStock === stockLevel;
        card.style.display = matches ? 'flex' : 'none';
    });
}

// ==================== CONFIRMAR ELIMINACIÓN ====================
function confirmarEliminar(id, nombre) {
    const confirmacion = confirm(
        `¿Estás seguro de eliminar el producto?\n\n"${nombre}"\n\nEsta acción no se puede deshacer.`
    );
    
    if (confirmacion) {
        window.location.href = `/?controller=producto&action=delete&id=${id}`;
    }
}

// ==================== AUTO-HIDE ALERTAS ====================
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.animation = 'slideDown 0.4s ease reverse';
        setTimeout(() => alert.remove(), 400);
    });
}, 5000);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin_layout.php';
?>