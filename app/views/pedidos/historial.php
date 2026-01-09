<?php
$title = "Mis Pedidos";
ob_start();
?>

<style>
/* ==================== HEADER SECTION ==================== */
.pedidos-header {
    background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-dark) 100%);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-md);
}

.pedidos-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.header-title {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    font-size: 3rem;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.header-title h1 {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    color: var(--primary-color);
    margin: 0;
    text-shadow: 0 0 20px rgba(0, 234, 255, 0.3);
}

.header-title p {
    color: var(--text-secondary);
    font-size: 1rem;
    margin: 0.5rem 0 0 0;
}

.header-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1rem 1.5rem;
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: var(--transition);
}

.stat-item:hover {
    border-color: var(--primary-color);
    box-shadow: 0 0 20px rgba(0, 234, 255, 0.2);
    transform: translateY(-3px);
}

.stat-value {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-color);
    text-shadow: 0 0 15px rgba(0, 234, 255, 0.4);
}

.stat-label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-top: 0.3rem;
}

/* ==================== FILTROS ==================== */
.pedidos-filters {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    align-items: center;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-chip {
    padding: 0.6rem 1.2rem;
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    border-radius: 50px;
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition);
    font-weight: 600;
    font-size: 0.9rem;
}

.filter-chip:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
}

.filter-chip.active {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    border-color: var(--primary-color);
    box-shadow: 0 0 20px rgba(0, 234, 255, 0.4);
}

.search-box {
    flex: 1;
    min-width: 250px;
}

.search-box input {
    width: 100%;
    padding: 0.7rem 1.2rem;
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    border-radius: 50px;
    color: var(--text-primary);
    transition: var(--transition);
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.1);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-card);
    border: 1px dashed var(--border-color);
    border-radius: var(--radius-lg);
    margin: 2rem 0;
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.empty-action {
    display: inline-block;
    padding: 0.9rem 2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.empty-action:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* ==================== TIMELINE DE PEDIDOS ==================== */
.pedidos-timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-line {
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--primary-color), transparent);
}

.pedido-item {
    position: relative;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: var(--transition);
    animation: slideInRight 0.5s ease;
}

.pedido-item:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow-md);
    transform: translateX(5px);
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 1.5rem;
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border: 3px solid var(--bg-dark);
    border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(0, 234, 255, 0.2);
    animation: pulse-marker 2s ease-in-out infinite;
}

@keyframes pulse-marker {
    0%, 100% {
        box-shadow: 0 0 0 4px rgba(0, 234, 255, 0.2);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(0, 234, 255, 0.4);
    }
}

.pedido-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.pedido-id {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--primary-color);
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
}

.pedido-date {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.estado-badge {
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.estado-badge::before {
    content: '●';
    font-size: 1.2rem;
    animation: pulse 2s ease-in-out infinite;
}

.estado-badge.pendiente {
    background: rgba(251, 191, 36, 0.15);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.3);
}

.estado-badge.pagado {
    background: rgba(34, 197, 94, 0.15);
    color: #22c55e;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.estado-badge.enviado {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.estado-badge.entregado {
    background: rgba(0, 234, 255, 0.15);
    color: var(--primary-color);
    border: 1px solid rgba(0, 234, 255, 0.3);
}

.estado-badge.cancelado {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.pedido-body {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.25rem;
}

.pedido-info-item {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.info-label {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 600;
}

.info-value {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 700;
}

.info-value.total {
    color: var(--primary-color);
    font-size: 1.8rem;
    text-shadow: 0 0 15px rgba(0, 234, 255, 0.3);
}

.pedido-progress {
    margin: 1.5rem 0;
}

.progress-bar {
    height: 6px;
    background: var(--bg-dark);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    border-radius: 10px;
    transition: width 0.5s ease;
    box-shadow: 0 0 10px rgba(0, 234, 255, 0.5);
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    margin-top: 0.75rem;
}

.progress-step {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-align: center;
    flex: 1;
}

.progress-step.active {
    color: var(--primary-color);
    font-weight: 700;
}

.pedido-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.7rem 1.5rem;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary-action {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.btn-primary-action:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-secondary-action {
    background: var(--bg-dark);
    color: var(--text-primary);
    border: 2px solid var(--border-color);
}

.btn-secondary-action:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-danger-action {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    border: 2px solid rgba(239, 68, 68, 0.3);
}

.btn-danger-action:hover {
    background: rgba(239, 68, 68, 0.25);
    border-color: #ef4444;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .pedidos-header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-stats {
        width: 100%;
        justify-content: space-between;
        gap: 1rem;
    }

    .stat-item {
        flex: 1;
        padding: 0.8rem;
    }

    .stat-value {
        font-size: 1.5rem;
    }

    .pedidos-timeline {
        padding-left: 1.5rem;
    }

    .timeline-marker {
        left: -2rem;
        width: 16px;
        height: 16px;
    }

    .pedido-body {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .pedido-actions {
        flex-direction: column;
    }

    .btn-action {
        width: 100%;
        justify-content: center;
    }
}
</style>

<!-- Header Section -->
<div class="pedidos-header">
    <div class="pedidos-header-content">
        <div class="header-title">
            <div class="header-icon">📦</div>
            <div>
                <h1>Historial de Pedidos</h1>
                <p>Gestiona y revisa todos tus pedidos</p>
            </div>
        </div>
        
        <?php if (!empty($pedidos)): ?>
        <div class="header-stats">
            <div class="stat-item">
                <span class="stat-value"><?= count($pedidos) ?></span>
                <span class="stat-label">Total Pedidos</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">
                    <?php 
                        $totalGastado = array_sum(array_column($pedidos, 'total'));
                        echo '$' . number_format($totalGastado, 2);
                    ?>
                </span>
                <span class="stat-label">Total Gastado</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">
                    <?php 
                        $entregados = count(array_filter($pedidos, fn($p) => strtolower($p['estado']) === 'entregado'));
                        echo $entregados;
                    ?>
                </span>
                <span class="stat-label">Entregados</span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php if (isset($_GET['msg']) && $_GET['msg'] === 'espera'): ?>
    <div style="background-color: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #bee5eb;">
        <strong>¡Pedido Registrado!</strong> Tu transferencia ha sido enviada con éxito. Tu pedido estará a la espera de que el administrador confirme el depósito.
    </div>
<?php endif; ?>
<?php if (empty($pedidos)): ?>
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <h3>No tienes pedidos aún</h3>
        <p>Comienza a explorar nuestros productos y realiza tu primera compra</p>
        <a href="/?controller=producto&action=index" class="empty-action">
            🛍️ Explorar Productos
        </a>
    </div>
<?php else: ?>

    <!-- Filtros -->
    <div class="pedidos-filters">
        <div class="filter-group">
            <button class="filter-chip active" onclick="filterByStatus('all')">Todos</button>
            <button class="filter-chip" onclick="filterByStatus('pendiente')">Pendiente</button>
            <button class="filter-chip" onclick="filterByStatus('pagado')">Pagado</button>
            <button class="filter-chip" onclick="filterByStatus('enviado')">Enviado</button>
            <button class="filter-chip" onclick="filterByStatus('entregado')">Entregado</button>
            <button class="filter-chip" onclick="filterByStatus('cancelado')">Cancelado</button>
        </div>
        
        <div class="search-box">
            <input type="text" 
                   placeholder="🔍 Buscar por número de pedido..." 
                   id="searchInput"
                   onkeyup="searchPedidos()">
        </div>
    </div>

    <!-- Timeline de Pedidos -->
    <div class="pedidos-timeline">
        <div class="timeline-line"></div>
        
        <?php foreach ($pedidos as $index => $p): 
            $estadoClass = strtolower(str_replace(' ', '-', $p['estado']));
            
            // Calcular progreso basado en el estado
            $progress = 0;
            switch(strtolower($p['estado'])) {
                case 'pendiente': $progress = 20; break;
                case 'pagado': $progress = 40; break;
                case 'enviado': $progress = 70; break;
                case 'entregado': $progress = 100; break;
                case 'cancelado': $progress = 0; break;
            }
        ?>
        
        <div class="pedido-item" 
             data-estado="<?= strtolower($p['estado']) ?>"
             data-pedido="<?= $p['id_pedido'] ?>"
             style="animation-delay: <?= $index * 0.1 ?>s">
            
            <div class="timeline-marker"></div>
            
            <div class="pedido-header">
                <div>
                    <div class="pedido-id">Pedido #<?= $p['id_pedido'] ?></div>
                    <div class="pedido-date">
                        📅 <?= date('d/m/Y H:i', strtotime($p['fecha_pedido'])) ?>
                    </div>
                </div>
                <span class="estado-badge <?= $estadoClass ?>">
                    <?= htmlspecialchars($p['estado']) ?>
                </span>
            </div>
            
            <div class="pedido-body">
                <div class="pedido-info-item">
                    <span class="info-label">Total del Pedido</span>
                    <span class="info-value total">$<?= number_format($p['total'], 2) ?></span>
                </div>
                
                <div class="pedido-info-item">
                    <span class="info-label">Método de Pago</span>
                    <span class="info-value">
                        <?= isset($p['metodo_pago']) ? htmlspecialchars($p['metodo_pago']) : 'No especificado' ?>
                    </span>
                </div>
                
                <div class="pedido-info-item">
                    <span class="info-label">Dirección de Envío</span>
                    <span class="info-value">
                        <?= isset($p['direccion']) ? htmlspecialchars($p['direccion']) : 'No especificada' ?>
                    </span>
                </div>
            </div>
            
            <?php if (strtolower($p['estado']) !== 'cancelado'): ?>
            <div class="pedido-progress">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $progress ?>%"></div>
                </div>
                <div class="progress-steps">
                    <span class="progress-step <?= $progress >= 20 ? 'active' : '' ?>">Pendiente</span>
                    <span class="progress-step <?= $progress >= 40 ? 'active' : '' ?>">Pagado</span>
                    <span class="progress-step <?= $progress >= 70 ? 'active' : '' ?>">Enviado</span>
                    <span class="progress-step <?= $progress >= 100 ? 'active' : '' ?>">Entregado</span>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="pedido-actions">
                <a href="/?controller=pedido&action=detalle&id=<?= $p['id_pedido'] ?>" 
                   class="btn-action btn-primary-action">
                    👁️ Ver Detalles
                </a>
                
                <?php if (strtolower($p['estado']) === 'entregado'): ?>
                <a href="/?controller=pedido&action=recomprar&id=<?= $p['id_pedido'] ?>" 
                   class="btn-action btn-secondary-action">
                    🔄 Volver a Comprar
                </a>
                <?php endif; ?>
                
                <?php if (in_array(strtolower($p['estado']), ['pendiente', 'pagado'])): ?>
                
                <?php endif; ?>
                
                <a href="/?controller=pedido&action=factura&id=<?= $p['id_pedido'] ?>" 
                   class="btn-action btn-secondary-action">
                    📄 Descargar Factura
                </a>
            </div>
        </div>
        
        <?php endforeach; ?>
    </div>

<?php endif; ?>

<script>
// Filtrar por estado
function filterByStatus(status) {
    const items = document.querySelectorAll('.pedido-item');
    const chips = document.querySelectorAll('.filter-chip');
    
    chips.forEach(chip => chip.classList.remove('active'));
    event.target.classList.add('active');
    
    items.forEach((item, index) => {
        if (status === 'all' || item.dataset.estado === status) {
            item.style.display = 'block';
            item.style.animation = `slideInRight 0.5s ease ${index * 0.1}s`;
        } else {
            item.style.display = 'none';
        }
    });
}

// Buscar pedidos
function searchPedidos() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.pedido-item');
    
    items.forEach(item => {
        const pedidoId = item.dataset.pedido.toLowerCase();
        if (pedidoId.includes(input)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Cancelar pedido
function cancelarPedido(id) {
    if (confirm('¿Estás seguro de que deseas cancelar este pedido?')) {
        window.location.href = `/?controller=pedido&action=cancelar&id=${id}`;
    }
}

// Animación de entrada
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.pedido-item');
    items.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '1';
        }, index * 100);
    });
});
</script>


<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>