<?php
session_start();
include('../../app/conexion.inc');

// Verificar sesión y rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'profesor') {
    die("Acceso denegado");
}

// Verificar datos recibidos
if (!isset($_POST['id_asignatura']) || !isset($_FILES['archivo'])) {
    die("Datos incompletos");
}

$id_profesor = $_SESSION['user_id'];
$id_asignatura = (int)$_POST['id_asignatura'];
$nombre = $_POST['nombre'];
$tipo = $_FILES['archivo']['type'];
$archivo = file_get_contents($_FILES['archivo']['tmp_name']);

// Verificar que el profesor tiene permiso para esta asignatura
$query = "SELECT COUNT(*) 
          FROM profesores_asignaturas 
          WHERE id_profesor = ? AND id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ii", $id_profesor, $id_asignatura);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count === 0) {
    die("No tienes permiso para subir archivos a esta asignatura");
}

// Insertar archivo en la base de datos
$stmt = $conexion->prepare("INSERT INTO archivosModulo (id_autor, id_asignatura, nombre, tipo, datos) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $id_profesor, $id_asignatura, $nombre, $tipo, $archivo);

if ($stmt->execute()) {
    echo "Archivo subido";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>