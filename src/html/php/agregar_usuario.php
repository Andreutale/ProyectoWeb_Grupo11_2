<?php
session_start();
include('../../app/conexion.inc');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Recoger y validar datos
$requiredFields = ['nombre', 'apellidos', 'dni', 'correo', 'contraseña', 'rol'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit;
    }
}

// Validar formato DNI
if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $_POST['dni'])) {
    echo json_encode(['success' => false, 'message' => 'Formato de DNI incorrecto']);
    exit;
}

// Validar contraseña
if ($_POST['contraseña'] !== $_POST['confirmar_contraseña']) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
    exit;
}

if (strlen($_POST['contraseña']) < 6) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
    exit;
}

// Validar correo único
$correo = $conexion->real_escape_string($_POST['correo']);
$sqlVerificarCorreo = "SELECT id FROM usuariosmodulo WHERE correo = '$correo'";
if ($conexion->query($sqlVerificarCorreo)->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado']);
    exit;
}

// Validar DNI único
$dni = $conexion->real_escape_string($_POST['dni']);
$sqlVerificarDNI = "SELECT id FROM usuariosmodulo WHERE dni = '$dni'";
if ($conexion->query($sqlVerificarDNI)->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El DNI ya está registrado']);
    exit;
}

// Preparar datos para inserción
$nombre = $conexion->real_escape_string($_POST['nombre']);
$apellidos = $conexion->real_escape_string($_POST['apellidos']);
$rol = $conexion->real_escape_string(strtolower($_POST['rol']));
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

// Insertar nuevo usuario
$sql = "INSERT INTO usuariosmodulo (nombre, apellidos, dni, correo, contraseña, rol) 
        VALUES ('$nombre', '$apellidos', '$dni', '$correo', '$contraseña', '$rol')";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario: ' . $conexion->error]);
}

$conexion->close();
?>