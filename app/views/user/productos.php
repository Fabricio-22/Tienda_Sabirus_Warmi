<?php
$title = "Productos";
ob_start();
?>

<h2>Catálogo de Productos</h2>

<div class="products-grid">

    <?php foreach ($productos as $p): ?>
    <div class="product-card">

        <img src="/uploads/<?= $p['imagen'] ?>" class="product-img">

        <h3><?= $p['nombre'] ?></h3>

        <p class="price">$<?= number_format($p['precio'], 2) ?></p>

        <a href="/?controller=pedido&action=agregar&id=<?= $p['id_producto'] ?>" class="btn-add">
            Añadir al carrito
        </a>

    </div>
    <?php endforeach; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>
