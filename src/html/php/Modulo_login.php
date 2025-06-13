<?php
session_start();
include('../../app/conexion.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];
    $password = $_POST['password'];

    if (empty($correo) || empty($password)) {
        die("Por favor complete todos los campos");
    }

    // Preparar consulta (asegurándote que el campo contraseña está almacenado con PASSWORD())
    $stmt = $conexion->prepare("SELECT id, nombre, apellidos, dni, correo, rol FROM usuariosmodulo WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Extraer datos con fetch_assoc para mayor claridad
        $usuario = $result->fetch_assoc();

        // Guardar datos en sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_email'] = $usuario['correo'];
        $_SESSION['user_role'] = $usuario['rol'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['user_apellidos'] = $usuario['apellidos'];
        $_SESSION['user_dni'] = $usuario['dni'];

        // Redirigir según rol
        switch ($usuario['rol']) {
            case 'alumno':
                header("Location: ../modulo/Modulo_landing_alumno.php");
                break;
            case 'profesor':
                header("Location: ../modulo/Modulo_landing_profesor.php");
                break;
            case 'pas':
                header("Location: ../modulo/Modulo_landing_page_pas.php");
                break;
            default:
                die("Rol no reconocido");
        }
        exit();
    } else {
        die('Credenciales incorrectas');
    }
} else {
    header("Location: ../html/Modulo_Inicio_Sesion.html");
    exit();
}
?>
