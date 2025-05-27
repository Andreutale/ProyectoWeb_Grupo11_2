<?php
// Parámetros de conexión
$servidor = "localhost";  // El servidor MySQL (por lo general es localhost)
$usuario = "root";        // El nombre de usuario para la base de datos
$contraseña = "";         // La contraseña del usuario (para XAMPP generalmente está vacía)
$baseDeDatos = "grupo_11";  // El nombre de tu base de datos

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contraseña, $baseDeDatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
