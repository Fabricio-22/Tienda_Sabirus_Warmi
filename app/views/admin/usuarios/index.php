<?php
$title = 'Usuarios';
$currentPage = 'usuarios';
ob_start();
?>

<div class="admin-wrapper">

    <div class="admin-header">
        <h1 class="admin-title">Usuarios</h1>
    </div>

    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                        <td><?= htmlspecialchars($u['correo']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
$content = ob_get_clean();

/**
 * Explicación de la ruta:
 * __DIR__ es .../admin/usuarios
 * dirname(__DIR__, 2) sube dos niveles hasta .../views
 * Luego entra a /layouts/admin_layout.php
 */
require_once dirname(__DIR__, 2) . '/layouts/admin_layout.php';