<?php
$title = 'Admin | Dashboard';
$currentPage = 'dashboard';
ob_start();
?>

<div class="admin-wrapper">

    <!-- ==========================
         BIENVENIDA
    ========================== -->
    <section class="welcome-section">
        <h1 class="welcome-title">
            Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
        </h1>
        <p class="welcome-subtitle">Panel de administración</p>
    </section>

    <!-- ==========================
         TARJETAS KPI
    ========================== -->
    <section class="dashboard-grid">

    <!-- USUARIOS -->
    <a href="/?controller=usuario&action=index"
       class="dashboard-card card-primary dashboard-link">

        <div class="card-icon">👥</div>

        <div class="card-body">
            <h3 class="card-title">Usuarios</h3>
            <p class="card-number"><?= $totalUsuarios ?></p>
            <span class="card-btn">Gestionar →</span>
        </div>
    </a>

    <!-- PRODUCTOS -->
    <a href="/?controller=producto&action=adminIndex"
       class="dashboard-card card-secondary dashboard-link">

        <div class="card-icon">📦</div>

        <div class="card-body">
            <h3 class="card-title">Productos</h3>
            <p class="card-number"><?= $totalProductos ?></p>
            <span class="card-btn">Ver productos →</span>
        </div>
    </a>

    <!-- PEDIDOS -->
    <a href="/?controller=admin&action=pedidos"
       class="dashboard-card card-accent dashboard-link">

        <div class="card-icon">🧾</div>

        <div class="card-body">
            <h3 class="card-title">Pedidos</h3>
            <p class="card-number"><?= $totalPedidos ?></p>
            <span class="card-btn">Administrar →</span>
        </div>
    </a>

</section>


    <!-- ==========================
         ÚLTIMOS PEDIDOS
    ========================== -->
    <section class="admin-card">
        <h2>Últimos Pedidos</h2>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ultimosPedidos)): ?>
                   <?php foreach ($ultimosPedidos as $p): ?>
    <tr>
        <td>#<?= $p['id_pedido'] ?></td>
        <td><?= htmlspecialchars($p['nombre_usuario'] ?? 'Usuario #' . $p['id_usuario']) ?></td>
        <td>$<?= number_format($p['total'], 2) ?></td>
        <td><?= $p['fecha_pedido'] ?></td>
    </tr>
<?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; opacity:.6;">
                            No hay pedidos recientes
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin_layout.php';
