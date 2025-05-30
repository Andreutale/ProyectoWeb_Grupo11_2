<?php
session_start();
include('../../app/conexion.inc');

// Creamos un token
$token = bin2hex(random_bytes(16));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['contraseña'];
    $confirmar = $_POST['confirmarContraseña'];

    if ($contraseña !== $confirmar) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Verificar si el correo ya está registrado
    $stmt = $conexion->prepare("SELECT id FROM usuariosweb WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Este correo ya está registrado.");
    }

    // Encriptar y guardar
    $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare("INSERT INTO usuariosweb (nombre, apellidos, correo, telefono, contraseña, token) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellidos, $correo, $telefono, $contraseñaHash, $token);

    if ($stmt->execute()) {
        // Redirigir a la página de inicio de sesión, sin guardar sesión aquí
        header("Location: ../web/Web_inicio_sesion.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>