<?php
session_start();
include('../../app/conexion.inc');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/Modulo_Inicio_Sesion.html");
    exit();
}

// Obtener información del usuario
$user_id = $_SESSION['user_id'];
$query = "SELECT nombre FROM usuariosmodulo WHERE id = ?";
$stmt_nombre = $conexion->prepare($query);
$stmt_nombre->bind_param("i", $user_id);
$stmt_nombre->execute();
$result_nombre = $stmt_nombre->get_result(); //???

if ($result_nombre->num_rows === 0) {
    die("Usuario no encontrado");
}

$usuario = $result_nombre->fetch_assoc();
$nombre_usuario = $usuario['nombre'];
$stmt_nombre->close();

// Obtener asignaturas del profesor
$query_asignaturas = "SELECT a.id, a.nombre FROM asignaturas a JOIN profesores_asignaturas pa ON a.id = pa.id_asignatura WHERE pa.id_profesor = ?";
$stmt_asignaturas = $conexion->prepare($query_asignaturas);
$stmt_asignaturas->bind_param("i", $user_id);
$stmt_asignaturas->execute();
$result_asignaturas = $stmt_asignaturas->get_result();

// Guardamos las asignaturas en un array para usar más adelante
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
        <?php if (count($asignaturas) > 0): ?>
            <?php foreach ($asignaturas as $asignatura): ?>
                <div class="asignatura">
                    <a href="Modulo_asignaturas.php?id=<?= $asignatura['id'] ?>">
                        <p><?= htmlspecialchars($asignatura['nombre']) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-asignaturas">No tienes asignaturas asignadas</p>
        <?php endif; ?>
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
