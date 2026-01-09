<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Panel Admin' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body class="admin-layout">

<!-- SIDEBAR -->
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2>⚡ Panel Admin</h2>
        <span class="admin-name">
            <?= $_SESSION['usuario']['nombre'] ?>
        </span>
    </div>

    <nav class="sidebar-nav">
        <a href="/?controller=admin&action=dashboard"
           class="sidebar-link <?= $_GET['action'] === 'dashboard' ? 'active' : '' ?>">
            🏠 <span>Dashboard</span>
        </a>

        <a href="/?controller=producto&action=adminIndex"
           class="sidebar-link <?= $_GET['controller'] === 'producto' ? 'active' : '' ?>">
            📦 <span>Productos</span>
        </a>

        <a href="/?controller=admin&action=pedidos"
           class="sidebar-link <?= $_GET['action'] === 'pedidos' ? 'active' : '' ?>">
            📋 <span>Pedidos</span>
        </a>

        <a href="/?controller=admin&action=usuarios"
           class="sidebar-link <?= $_GET['action'] === 'usuarios' ? 'active' : '' ?>">
            👤 <span>Usuarios</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="/?controller=usuario&action=logout" class="logout-btn">
            🚪 Cerrar sesión
        </a>
    </div>
</aside>

<!-- CONTENIDO -->
<main class="admin-content">
    <?= $content ?>
</main>

</body>
</html>
