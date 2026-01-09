<?php
// Iniciar sesión siempre al principio para que el carrito funcione
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = $_GET['controller'] ?? 'usuario';
$action     = $_GET['action'] ?? 'home';

// Limpieza de nombres
$controller = preg_replace('/[^a-z]/', '', strtolower($controller));
$action = preg_replace('/[^a-zA-Z_]/', '', $action);

$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    header("HTTP/1.0 404 Not Found");
    die("Error: El controlador '$controllerName' no existe en la ruta $controllerFile");
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    die("Error: La clase '$controllerName' no está definida dentro del archivo.");
}

$controllerObject = new $controllerName();

if (!method_exists($controllerObject, $action)) {
    die("Error: La acción '$action' no existe en el controlador '$controllerName'");
}

// Ejecutar la acción
$controllerObject->$action();