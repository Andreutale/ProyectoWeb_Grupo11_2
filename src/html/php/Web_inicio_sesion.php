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

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $nombre, $apellidos, $correoDB, $telefono, $hash_guardado, $token);
        $stmt->fetch();

        if (password_verify($contraseña, $hash_guardado)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_nombre'] = $nombre;
            $_SESSION['user_apellidos'] = $apellidos;
            $_SESSION['user_correo'] = $correoDB;
            $_SESSION['user_telefono'] = $telefono;
            $_SESSION['token'] = $token;
            header("Location: ../web/Web_landing_page_registrado.html");
            exit();
        } else {
            header("Location: ../web/Web_inicio_sesion.html?error=1");
            exit();
        }
    } else {
        header("Location: ../web/Web_inicio_sesion.html?error=1");
        exit();
    }

    $stmt->close();
    $conexion->close();
}
?>