<?php
session_start();
include('../../app/conexion.inc');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ./Modulo_Inicio_Sesion.html");
    exit();
}

$nombre_usuario = $_SESSION['user_name'];

// Obtener asignaturas del alumno
$query_asignaturas = "SELECT a.id, a.nombre FROM asignaturas a JOIN alumnos_asignaturas aa ON a.id = aa.id_asignatura WHERE aa.id_alumno = ?";
$stmt_asignaturas = $conexion->prepare($query_asignaturas);
$stmt_asignaturas->bind_param("i", $user_id);
$stmt_asignaturas->execute();
$result_asignaturas = $stmt_asignaturas->get_result();

$asignaturas = [];
while ($row = $result_asignaturas->fetch_assoc()) {
    $asignaturas[] = $row;
}

$stmt_asignaturas->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Landing Alumno</title>
  <link rel="stylesheet" href="../css/libro_de_estilos.css">
  <link rel="stylesheet" href="../css/Modulo_landing_alumno.css">
  <link rel="stylesheet" href="../css/Modulo_header.css">
  <link rel="stylesheet" href="../css/Modulo_footer.css">
  <script src="../js/Modulo_header.js" defer></script>

</head>
<body>

<!-- Contenedor del header -->
<div class="header-container">
  <header>
    <!-- Logo -->
    <a href="../php/cargar_header_modulo.php"><img class="logo" src="../../../images/logo_modulo.png" alt="Logo del apartado de modulo"></a>
      <a href="Modulo_perfil.php" class="perfil"><h2><?php echo htmlspecialchars($nombre_usuario); ?></h2><img class="user" src="../../../images/user_icon.png" alt="Icono de usuario"></a>
    <!-- Lineas del menu hamburguesa -->
    <div class="menu-hamburguesa" id="menu-btn">
      <div class="linea"></div>
      <div class="linea"></div>
      <div class="linea"></div>
    </div>
    <!-- Menú desplegable -->
    <nav class="menu-desplegable" id="menu">
      <ul>
        <li><a href="../php/cargar_header_modulo.php">Inicio</a></li>
        <li><a href="Modulo_perfil.php">Perfil</a></li>
        <li><a href="../php/logout_modulo.php">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>
</div>

<!-- Contenedor de la pagina -->
<main class="main-container">
    <img class="fondo_landing" src="../../../images/fondo_landing_estudiante_modulo.jpg" alt="Imagen del fondo de la landing">
    <h1>Hola, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
  <h3>¿A qué asignatura quieres acceder?</h3>

  <!-- Contenedor de los apartados -->
  <div class="grid-asignaturas">
      <?php if (count($asignaturas) > 0): ?>
          <?php foreach ($asignaturas as $asignatura): ?>
              <div class="asignatura">
                  <a href="Modulo_recursos_alumno.php?id_asignatura=<?= $asignatura['id'] ?>">
                      <p><?= htmlspecialchars($asignatura['nombre']) ?></p>
                  </a>
              </div>
          <?php endforeach; ?>
      <?php else: ?>
          <p class="no-asignaturas">No estás matriculado en ninguna asignatura</p>
      <?php endif; ?>
  </div>
</main>

<!-- Contenedor footer -->
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
