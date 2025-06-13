<?php
session_start();
include('../../app/conexion.inc');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ./Modulo_Inicio_Sesion.php");
    exit();
}

$nombre_usuario = $_SESSION['user_name'];

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing pas | MODULO</title>

    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Modulo_header.css">
    <link rel="stylesheet" href="../css/Modulo_footer.css">
    <link rel="stylesheet" href="../css/Modulo_landing_pas.css">
</head>
<body>

<div id="header"></div>

<main>
    <div class="contenedor-pagina">
        <h1>Hola, <span id="nombreUsuario"><?php echo htmlspecialchars($nombre_usuario); ?></span></h1>
        <h3>Pulsa el botón para acceder a la gestión de usuarios</h3>
        <button class="btn-azul-oscuro">
            <a href="Modulo_gestionar_perfiles.php"><h3>Gestión de usuarios</h3></a>
        </button>
    </div>
</main>

<div id="footer"></div>

<script type="module">
    import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';

    fetch("Modulo_header.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa();
        });

    fetch("Modulo_footer_con_ola.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("footer").innerHTML = html;
        });
</script>

</body>
</html>
