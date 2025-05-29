<?php
include('../../app/conexion.inc');

//if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $id_autor = 1;
    $id_asignatura = 1;
    // $nombre = $_FILES['archivo']['name']; nombre original del fichero
    $nombre = $_FILES['nombre']; // nombre personalizado
    $tipo = $_FILES['archivo']['type'];
    $archivo = file_get_contents($_FILES['archivo']['tmp_name']);

    $stmt = $conexion->prepare("INSERT INTO archivosModulo (id_autor, id_asignatura, nombre, tipo, datos) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_autor, $id_asignatura, $nombre, $tipo, $archivo);

    if ($stmt->execute()) {
        // Archivo subido exitoso
        echo "Archivo subido";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
//}
?>