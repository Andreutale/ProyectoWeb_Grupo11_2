<?php
session_start();
include('../../app/conexion.inc');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $nombre = $_SESSION[''];

    $stmt = $conexion->prepare("SELECT id, nombre, apellidos, correo, telefono, contraseña, token FROM usuariosweb WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    $errores = [];

    if (empty($correo)) {
        $errores['correo'] = "Correo obligatorio";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "Formato de correo inválido";
    }

    if (empty($contraseña)) {
        $errores['contraseña'] = "Contraseña obligatoria";
    }

    // Guardar en sesión
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = $_POST;

    // Si hay errores, redirigir
    if (!empty($errores)) {
        header("Location: ../web/Web_inicio_sesion.php");
        exit();
    }

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $nombre, $apellidos, $correoDB, $telefono, $hash_guardado, $token);
        $stmt->fetch();

        if (password_verify($contraseña, $hash_guardado)) {
            // Éxito: autenticar usuario
            unset($_SESSION['errores']);
            unset($_SESSION['datos']);

            $_SESSION['user_id'] = $id;
            $_SESSION['user_nombre'] = $nombre;
            $_SESSION['user_apellidos'] = $apellidos;
            $_SESSION['user_correo'] = $correoDB;
            $_SESSION['user_telefono'] = $telefono;
            $_SESSION['token'] = $token;
            header("Location: ../web/Web_landing_page_registrado.html");
            exit();
        } else {
            $errores['contraseña'] = "Contraseña incorrecta";
        }
    } else {
        $errores['correo'] = "Correo no registrado";
    }

    $stmt->close();
    $conexion->close();

    // Volver a enviar errores
    $_SESSION['errores'] = $errores;
    header("Location: ../web/Web_inicio_sesion.php");
    exit();
}
?>