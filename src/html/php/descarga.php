<?php

include('../../app/conexion.inc');

$id_fichero = $_POST['id_fichero'];

$query = "SELECT `id`, `nombre`, `tipo`, `datos` FROM archivosModulo WHERE id = ?";
$result = $conexion->execute_query($query, [$id_fichero]);
// print_r( mysqli_fetch_array($result));
list($id, $nombre, $tipo, $datos) = mysqli_fetch_array($result);
$mime = explode("/", $tipo);
$extension = $mime[1];
header("Content-Disposition: attachment; filename=$nombre.$extension");
echo $datos;
?>