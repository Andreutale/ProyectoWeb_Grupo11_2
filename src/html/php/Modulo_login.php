<?php
session_start();
include('../../app/conexion.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];
    $password = $_POST['password'];

    if (empty($correo) || empty($password)) {
        die("Por favor complete todos los campos");
    }

    // Usar la función PASSWORD() de MySQL para verificar
    $stmt = $conexion->prepare("SELECT id, rol FROM usuariosmodulo WHERE correo = ? AND contraseña = PASSWORD(?)");
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Guardar datos en sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_email'] = $correo;
        $_SESSION['user_role'] = $usuario['rol'];

        // Redirigir según rol
        switch ($usuario['rol']) {
            case 'alumno':
                header("Location: ../modulo/Modulo_landing_alumno.php");
                break;
            case 'profesor':
                header("Location: ../modulo/Modulo_landing_profesor.php");
                break;
            case 'pas':
                header("Location: ../modulo/Modulo_landing_page_pas.html");
                break;
            default:
                die("Rol no reconocido");
        }
        exit();
    } else {
        die("Credenciales incorrectas");
    }
} else {
    header("Location: ../html/Modulo_Inicio_Sesion.html");
    exit();
}
?>