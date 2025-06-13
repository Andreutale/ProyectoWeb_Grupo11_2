<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/Modulo_Inicio_Sesion.php");
    exit();
}

include('../../app/conexion.inc');

$user_id = $_SESSION['user_id'];

$stmt = $conexion->prepare("SELECT nombre, apellidos, correo, dni, rol FROM usuariosmodulo WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    $nombre = $usuario['nombre'];
    $apellidos = $usuario['apellidos'];
    $correo = $usuario['correo'];
    $dni = $usuario['dni'];
    $rol = $usuario['rol'];
} else {
    die("Usuario no encontrado");
}

$stmt->close();
$conexion->close();
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Perfil | Módulo</title>
  
  <link rel="stylesheet" href="../css/libro_de_estilos.css">
  <link rel="stylesheet" href="../css/Modulo_header.css">
  <link rel="stylesheet" href="../css/Modulo_footer.css">
  <link rel="stylesheet" href="../css/Modulo_perfil.css">

</head>
<body>
<div id="header"></div>

<main>
  <h1>Mi perfil</h1>

  <div>
    <!-- div de la imagen y el boton-->
    <div>
      <img src="../../../images/user_icon.svg" alt="Foto de perfil" >
        <a href="../php/logout_modulo.php"><button id="cerrarSesion" class="btn-cerrar-sesion"><h3>Cerrar sesión</h3></button></a>
    </div>

    <div>
      <ul id="datos">
        <!-- Cada informacion del perfil -->
        <li><h3>Nombre</h3><div id="Nombre"><p> <?php echo htmlspecialchars($nombre); ?> </p></div></li>
        <li><h3>Apellidos</h3><div id="Apellido"><p> <?php echo htmlspecialchars($apellidos); ?> </p></div></li>
        <li><h3>Correo</h3><div id="Correo"><p> <?php echo htmlspecialchars($correo); ?> </p></div></li>
        <li><h3>DNI</h3><div id="DNI"><p> <?php echo htmlspecialchars($dni); ?> </p></div></li>
      </ul>
    </div>
  </div>
</main>

<div id="footer"></div>

<script type="module">
  // importamos el menu hamburguesa
  import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';


  // Cargamos el HTML del header y footer
  fetch("Modulo_header.php")
          .then(res => res.text())
          .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa(); // Aquí activamos el menú hamburguesa
          });

  fetch("Modulo_footer_con_ola.html")
          .then(res => res.text())
          .then(html => {
            document.getElementById("footer").innerHTML = html;
          });


</script>
</body>
</html>
