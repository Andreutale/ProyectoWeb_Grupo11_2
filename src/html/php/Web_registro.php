<?php
session_start();
include('../../app/conexion.inc');

// Creamos un token
$token = bin2hex(random_bytes(16));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';
    $confirmar = $_POST['confirmarContraseña'] ?? '';

    // Validar campos
    $errores = [];
    if (empty($nombre)) $errores['nombre'] = "Nombre obligatorio";
    if (empty($apellidos)) $errores['apellidos'] = "Los apellidos son obligatorios";

    if (empty($correo)) {
        $errores['correo'] = "Correo obligatorio";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "Formato de correo inválido";
    }

    if (empty($telefono)) $errores['telefono'] = "Teléfono obligatorio";

    if (empty($contraseña)) {
        $errores['contraseña'] = "Contraseña obligatoria";
    } elseif (strlen($contraseña) < 8) {
        $errores['contraseña'] = "La contraseña debe tener al menos 8 caracteres";
    }

    if (empty($confirmar)) {
        $errores['confirmar'] = "Contraseña obligatoria";
    } elseif ($contraseña !== $confirmar) {
        $errores['confirmar'] = "Las contraseñas no coinciden";
    }

    // Verificar correo solo si no hay errores previos
    if (empty($errores)) {
        $stmt = $conexion->prepare("SELECT id FROM usuariosweb WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errores['correo'] = "Este correo ya está registrado";
        }
        $stmt->close();
    }

    // Guardar en sesión
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = $_POST;

    // Si hay errores, redirigir
    if (!empty($errores)) {
        header("Location: ../web/Web_registro.php");
        exit();
    }

    // Si no hay errores, insertar en BD
    $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare("INSERT INTO usuariosweb (nombre, apellidos, correo, telefono, contraseña, token) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellidos, $correo, $telefono, $contraseñaHash, $token);

    if ($stmt->execute()) {
        // Limpiar sesión y redirigir
        unset($_SESSION['errores']);
        unset($_SESSION['datos']);
        header("Location: ../web/Web_inicio_sesion.html");
        exit();
    } else {
        $errores['general'] = "Error en el registro. Intente nuevamente.";
        $_SESSION['errores'] = $errores;
        header("Location: ../web/Web_registro.php");
        exit();
    }

    $stmt->close();
    $conexion->close();
}
?>