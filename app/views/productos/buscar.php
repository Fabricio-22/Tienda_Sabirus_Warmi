<h2>Resultados de búsqueda</h2>

<?php if (empty($productos)): ?>
    <p>No se encontraron productos.</p>
<?php else: ?>
    <div class="productos">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <h3><?= htmlspecialchars($producto->nombre) ?></h3>
                <p>$<?= number_format($producto->precio, 2) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
