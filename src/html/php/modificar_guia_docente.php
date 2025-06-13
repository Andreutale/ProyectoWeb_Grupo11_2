<?php
session_start();
include('../../app/conexion.inc');

// Verificar sesión y rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'profesor') {
    header("Location: Modulo_Inicio_Sesion.php");
    exit();
}

// Obtener ID de asignatura
$asignatura_id = $_POST['asignatura_id'] ?? null;
$descripcion = $_POST['descripcionAsignatura'] ?? null;
$criterios_json = $_POST['criterios_json'] ?? null;

if ($asignatura_id && $descripcion) {
    // Actualizar descripción
    $sql_update = "UPDATE asignaturas SET descripcion = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->execute([$descripcion, $asignatura_id]);
}

// Procesar criterios si vienen
if ($criterios_json) {
    $criterios_array = json_decode($criterios_json, true);

    // Eliminar criterios existentes
    $stmt_delete = $conexion->prepare("DELETE FROM criterios_asignaturas WHERE id_asignatura = ?");
    $stmt_delete->bind_param("i", $asignatura_id);
    $stmt_delete->execute();

    // Insertar nuevos criterios
    $stmt_insert = $conexion->prepare("INSERT INTO criterios_asignaturas (nombre, valor, id_asignatura) VALUES (?, ?, ?)");

    foreach ($criterios_array as $criterio) {
        $nombre = $criterio['nombre'];
        $valor = $criterio['porcentaje'];
        $stmt_insert->bind_param("sii", $nombre, $valor, $asignatura_id);
        $stmt_insert->execute();
    }
}

// Cerrar conexión
$conexion->close();

// Redirigir después de todo
header("Location: ../modulo/Modulo_guia_docente_profesor.php?asignatura_id=$asignatura_id");
exit();
?>
