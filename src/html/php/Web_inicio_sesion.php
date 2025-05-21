<?php
session_start();
include('../../app/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $stmt = $conexion->prepare("SELECT id, contraseña, token FROM usuariosWeb WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash_guardado, $token);
        $stmt->fetch();

        if (password_verify($contraseña, $hash_guardado)) {
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
