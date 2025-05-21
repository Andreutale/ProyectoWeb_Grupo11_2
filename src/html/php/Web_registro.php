<?php
include('../../app/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['contraseña'];
    $confirmar = $_POST['confirmarContraseña'];

    $mensaje_error = $_POST['mensaje-error'];

    if ($contraseña !== $confirmar) {
        echo("Las contraseñas no coinciden.");
    }

    // Verificar si el correo ya está registrado
    $stmt = $conexion->prepare("SELECT id FROM usuariosWeb WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Este correo ya está registrado.");
    }

    // Encriptar y guardar
    $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare("INSERT INTO usuariosWeb (nombre, apellidos, correo, telefono, contraseña) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellidos, $correo, $telefono, $contraseñaHash);

    if ($stmt->execute()) {
        // ✅ Redirige al inicio de sesión si todo va bien
        header("Location: ../web/Web_inicio_sesion.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
