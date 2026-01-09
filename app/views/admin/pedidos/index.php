<?php
$title = 'Admin | Pedidos';
ob_start();
?>

<h1 class="page-title">📦 Pedidos de la Tienda</h1>

<?php if (empty($pedidos)): ?>
    <p>No hay pedidos registrados.</p>
<?php else: ?>

<table class="styled-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Total</th>
            <th>Método</th>
            <th>Estado</th>
            <th>Comprobante</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($pedidos as $p): ?>
        <tr>
            <td>#<?= $p['id_pedido'] ?></td>
            <td><?= htmlspecialchars($p['usuario']) ?></td>
            <td>$<?= number_format($p['total'], 2) ?></td>
            <td><?= ucfirst($p['metodo_pago'] ?? '-') ?></td>
            <td><?= htmlspecialchars($p['estado']) ?></td>

            <!-- COMPROBANTE -->
            <td>
                <?php if (!empty($p['comprobante'])): ?>
                    <a href="<?= $p['comprobante'] ?>" target="_blank">
                        📄 Ver
                    </a>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>

            <!-- ACCIÓN -->
            <td>
                <?php if ($p['estado'] === 'Pendiente'): ?>
                    <a href="/?controller=admin&action=aprobarPago&id=<?= $p['id_pedido'] ?>"
                       onclick="return confirm('¿Marcar pedido como pagado?')"
                       class="btn btn-success">
                        ✅ Aprobar
                    </a>
                <?php else: ?>
                    ✔
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin_layout.php';
