<?php
session_start();
include('conexion.inc');

function verificarToken() {
    global $conexion;

    if (!isset($_SESSION['token'])) {
        // Sin token → Redirigir a la página de registro
        header("Location: ../web/Web_inicio_sesion.html");
        exit();
    }

    $token = $_SESSION['token'];
    $stmt = $conexion->prepare("SELECT id FROM usuariosweb WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Token no válido → Redirigir a registro
        header("Location: ../web/Web_inicio_sesion.html");
        exit();
    }
}
