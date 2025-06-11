<?php
session_start();
include('../../app/conexion.inc');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado']);
    exit;
}

$idUsuario = $conexion->real_escape_string($_POST['id']);

// Verificar que el usuario existe y no es PAS (por seguridad)
$sqlVerificar = "SELECT id, rol FROM usuariosmodulo WHERE id = '$idUsuario'";
$resultado = $conexion->query($sqlVerificar);

if ($resultado->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

$usuario = $resultado->fetch_assoc();
if ($usuario['rol'] === 'pas') {
    echo json_encode(['success' => false, 'message' => 'No puedes eliminar usuarios PAS']);
    exit;
}

// Eliminar el usuario
$sqlEliminar = "DELETE FROM usuariosmodulo WHERE id = '$idUsuario'";
if ($conexion->query($sqlEliminar)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $conexion->error]);
}

$conexion->close();
?>