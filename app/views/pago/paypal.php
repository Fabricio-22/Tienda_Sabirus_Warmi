<h2>Confirmar pago</h2>

<div id="paypal-button-container"></div>

<!-- SDK PayPal Sandbox -->
<script src="https://www.paypal.com/sdk/js?client-id=ASuXch-VlMQcbRtg8oGtFygn11Fmmwa5-VQt6iA5zVI2JMWmrS63qtu06HZrhc4aQjORAEKWhSEXX8jX&currency=USD"></script>

<script>
paypal.Buttons({

    createOrder: function () {
        return fetch("/?controller=pago&action=crearOrden", {
            method: "POST"
        })
        .then(res => res.json())
        .then(data => data.id);
    },

    onApprove: function (data) {
        return fetch("/?controller=pago&action=confirmarPago", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                orderID: data.orderID
            })
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === "COMPLETED") {
                alert("Pago realizado con éxito");
                window.location.href = "/?controller=pedido&action=exito";
            }
        });
    },

    onError: function (err) {
        console.error(err);
        alert("Error en el pago");
    }

}).render('#paypal-button-container');
</script>
