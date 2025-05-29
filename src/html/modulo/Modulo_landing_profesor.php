<?php
session_start();
include('../../app/conexion.inc'); // Asegúrate que la ruta es correcta

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/Modulo_Inicio_Sesion.html");
    exit();
}

// Obtener información del usuario
$user_id = $_SESSION['user_id'];
$query = "SELECT nombre FROM usuariosmodulo WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado");
}

$usuario = $result->fetch_assoc();
$nombre_usuario = $usuario['nombre'];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Landing Profesor</title>
  <link rel="stylesheet" href="../css/libro_de_estilos.css">
  <link rel="stylesheet" href="../css/Modulo_landing_profesor.css">
  <link rel="stylesheet" href="../css/Modulo_header.css">
  <link rel="stylesheet" href="../css/Modulo_footer.css">
  <script src="../js/Modulo_header.js" defer></script>
</head>
<body>

<div class="header-container">
  <header>
      <a href="Modulo_landing_profesor.html"><img class="logo" src="../../../images/logo_modulo.png" alt="Logo del apartado de modulo"></a>
      <a href="Modulo_Perfil.html" class="perfil"><h2><?php echo htmlspecialchars($nombre_usuario); ?></h2><img class="user" src="../../../images/user_icon.png" alt="Icono de usuario"></a>
    <div class="menu-hamburguesa" id="menu-btn">
      <div class="linea"></div>
      <div class="linea"></div>
      <div class="linea"></div>
    </div>
    <nav class="menu-desplegable" id="menu">
      <ul>
        <li><a href="Modulo_landing_profesor.html">Inicio</a></li>
        <li><a href="Modulo_Perfil.html">Perfil</a></li>
        <li><a href="Modulo_Inicio_Sesion.html">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>
</div>

<main class="main-container">
  <h1>Hola, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
  <h3>¿A qué asignatura quieres acceder?</h3>

  <div class="grid-asignaturas">
    <div class="asignatura">
      <a href="Modulo_asignaturas.html">
        <img src="../../../images/iconos/icono_programacion.png" alt="Programación 1">
        <p>Programación 1</p>
      </a>
    </div>
    <div class="asignatura">
      <a href="Modulo_asignaturas.html">
        <img src="../../../images/iconos/icono_programacion.png" alt="Programación 2">
        <p>Programación 2</p>
      </a>
    </div>
    <div class="asignatura">
      <a href="Modulo_asignaturas.html">
        <img src="../../../images/iconos/icono_programacion_en_sistemas_cloud.png" alt="Programación en sistemas cloud">
        <p>Programación en<br>sistemas cloud</p>
      </a>
    </div>
    <div class="asignatura">
      <a href="Modulo_asignaturas.html">
        <img src="../../../images/iconos/icono_Proyecto_Aplicacion_Biometria.png" alt="Biometría y Medio Ambiente">
        <p>Proyecto Aplicaciones de<br>Biometría y Medio Ambiente</p>
      </a>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="footer-content">
    <p>GTI 2025 &copy;</p>
  </div>
</footer>

<script type="module">
  import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';
  iniciarMenuHamburguesa();
</script>

</body>
</html>
