<?php
session_start();

// Verifica que el usuario haya iniciado sesión. Si no ha iniciado sesión te lleva al inicio de sesión
if (!isset($_SESSION['user_role'])) {
    header("Location: Modulo_Inicio_Sesion.html");
    exit();
}

// Redirige a la landing correspondiente según el rol del usuario
switch ($_SESSION['user_role']) {
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
        // Si el rol no es reconocido
        header("Location: ../modulo/Modulo_Inicio_Sesion.html");
}
exit();
?>
