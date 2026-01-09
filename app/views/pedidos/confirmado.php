<h2>Pago realizado con éxito</h2>

<p>Gracias por su compra.</p>

<?php if (isset($pedidoId)): ?>
    <p><strong>Número de pedido:</strong> #<?= htmlspecialchars($pedidoId) ?></p>
<?php endif; ?>

<a href="/?controller=pedido&action=historial">
    Ver mis pedidos
</a>
