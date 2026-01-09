<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>

    <h1>Registro de Usuario</h1>

    <form method="POST" action="/?controller=usuario&action=guardar">

        <input type="text" name="nombre" placeholder="Nombre completo" required><br><br>
        <input type="email" name="correo" placeholder="Correo" required><br><br>
        <input type="text" name="telefono" placeholder="Teléfono"><br><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>

        <button type="submit">Registrarse</button>
    </form>

</body>
</html>

