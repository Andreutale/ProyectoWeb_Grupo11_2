<?php
session_start();
include('../../app/conexion.inc');

// Verificar sesión y rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'profesor') {
    die("Acceso denegado");
}

// Verificar que se recibió un ID válido
if (!isset($_POST['id_archivo']) || !is_numeric($_POST['id_archivo'])) {
    die("ID de archivo inválido");
}

$id_archivo = (int)$_POST['id_archivo'];
$id_profesor = $_SESSION['user_id'];

// Verificar que el profesor es el autor del archivo
$query = "SELECT id_asignatura FROM archivosmodulo WHERE id = ? AND id_autor = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ii", $id_archivo, $id_profesor);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("No tienes permiso para eliminar este archivo o no existe");
}

$stmt->bind_result($id_asignatura);
$stmt->fetch();
$stmt->close();

// Eliminar el archivo
$query = "DELETE FROM archivosmodulo WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_archivo);

if ($stmt->execute()) {
    header("Location: Modulo_recursos_profesor.php?asignatura_id=$id_asignatura&mensaje=Archivo+eliminado+correctamente");
} else {
    echo "Error al eliminar el archivo: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>