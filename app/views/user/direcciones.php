<?php
$title = "Direcciones";
ob_start();
?>

<h2>Mis Direcciones</h2>

<ul class="address-list">
    <?php foreach ($direcciones as $d): ?>
    <li>
        <strong><?= $d['direccion'] ?></strong><br>
        <?= $d['ciudad'] ?>, <?= $d['provincia'] ?>
    </li>
    <?php endforeach; ?>
</ul>

<a class="btn-primary" href="/?controller=direccion&action=nueva">Añadir dirección</a>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>
