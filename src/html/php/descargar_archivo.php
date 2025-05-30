<?php
include('../../app/conexion.inc');

// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de archivo inválido");
}

$id_archivo = (int)$_GET['id'];

// Obtener el archivo de la base de datos
$query = "SELECT nombre, tipo, datos FROM archivosmodulo WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_archivo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Archivo no encontrado");
}

$stmt->bind_result($nombre_archivo, $tipo_archivo, $datos_archivo);
$stmt->fetch();
$stmt->close();

// Enviar encabezados para forzar la descarga
header("Content-Type: $tipo_archivo");
header("Content-Disposition: attachment; filename=\"" . basename($nombre_archivo) . "\"");
header("Content-Length: " . strlen($datos_archivo));

// Imprimir los datos del archivo
echo $datos_archivo;
exit;
?>