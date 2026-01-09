<?php
$title = "Detalle del Pedido";
ob_start();

// Validar que existan los datos necesarios
if (!isset($pedido) || !isset($detalle)) {
    echo '<div class="alert alert-error">❌ No se pudo cargar la información del pedido.</div>';
    echo '<a href="mis_pedidos.php" class="btn">⬅ Volver a Mis Pedidos</a>';
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/user_layout.php';
    exit;
}

// Definir clases de estado para estilos
$estadoClases = [
    'Pendiente' => 'status-pending',
    'Procesando' => 'status-processing',
    'Enviado' => 'status-shipped',
    'Entregado' => 'status-delivered',
    'Cancelado' => 'status-canceled'
];

$estadoActual = $pedido['estado'] ?? 'Desconocido';
$claseEstado = $estadoClases[$estadoActual] ?? 'status-default';
?>

<style>
    .order-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .order-header h2 {
        margin: 0 0 1rem 0;
        font-size: 1.8rem;
    }
    
    .order-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-card {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #667eea;
    }
    
    .info-card label {
        display: block;
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-card .value {
        font-size: 1.1rem;
        color: #333;
        font-weight: 600;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-shipped { background: #e0e7ff; color: #4338ca; }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-canceled { background: #fee2e2; color: #991b1b; }
    .status-default { background: #e5e7eb; color: #374151; }
    
    .products-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .products-section h3 {
        margin-top: 0;
        margin-bottom: 1.5rem;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    
    .styled-table thead {
        background: #f8fafc;
    }
    
    .styled-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .styled-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    
    .styled-table tbody tr:hover {
        background: #f8fafc;
    }
    
    .styled-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .total-row {
        background: #f8fafc;
        font-weight: 700;
    }
    
    .total-row td {
        padding: 1.5rem 1rem;
        font-size: 1.2rem;
        color: #667eea;
    }
    
    .price-cell {
        font-weight: 600;
        color: #059669;
    }
    
    .actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-size: 1rem;
    }
    
    .btn-secondary {
        background: #e2e8f0;
        color: #475569;
    }
    
    .btn-secondary:hover {
        background: #cbd5e1;
        transform: translateY(-2px);
    }
    
    .btn-primary {
        background: #667eea;
        color: white;
    }
    
    .btn-primary:hover {
        background: #5568d3;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #94a3b8;
    }
    
    @media (max-width: 768px) {
        .order-info-grid {
            grid-template-columns: 1fr;
        }
        
        .styled-table {
            font-size: 0.9rem;
        }
        
        .styled-table th,
        .styled-table td {
            padding: 0.75rem 0.5rem;
        }
        
        .actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="order-header">
    <h2>📦 Pedido #<?= str_pad($pedido['id_pedido'], 6, '0', STR_PAD_LEFT) ?></h2>
    <span class="status-badge <?= $claseEstado ?>">
        <?= htmlspecialchars($estadoActual) ?>
    </span>
</div>

<div class="order-info-grid">
    <div class="info-card">
        <label>👤 Cliente</label>
        <div class="value"><?= htmlspecialchars($pedido['usuario']) ?></div>
    </div>
    
    <div class="info-card">
        <label>📅 Fecha del Pedido</label>
        <div class="value">
            <?php
            $fecha = new DateTime($pedido['fecha_pedido']);
            echo $fecha->format('d/m/Y H:i');
            ?>
        </div>
    </div>
    
    <div class="info-card">
        <label>💰 Total del Pedido</label>
        <div class="value" style="color: #059669; font-size: 1.3rem;">
            $<?= number_format($pedido['total'], 2) ?>
        </div>
    </div>
</div>

<div class="products-section">
    <h3>🛒 Productos del Pedido</h3>
    
    <?php if (!empty($detalle)): ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: right;">Precio Unitario</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalCalculado = 0;
                foreach ($detalle as $item): 
                    $subtotal = $item['cantidad'] * $item['precio_unitario'];
                    $totalCalculado += $subtotal;
                ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($item['nombre']) ?></strong>
                        </td>
                        <td style="text-align: center;">
                            <?= (int)$item['cantidad'] ?>
                        </td>
                        <td style="text-align: right;" class="price-cell">
                            $<?= number_format($item['precio_unitario'], 2) ?>
                        </td>
                        <td style="text-align: right;" class="price-cell">
                            $<?= number_format($subtotal, 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td style="text-align: right;">
                        $<?= number_format($pedido['total'], 2) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>😕 No se encontraron productos en este pedido.</p>
        </div>
    <?php endif; ?>
</div>

<div class="actions">
    <a href="javascript:history.back()" class="btn btn-secondary">
        ⬅ 📋Volver a Pedidos
    </a>
   
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>