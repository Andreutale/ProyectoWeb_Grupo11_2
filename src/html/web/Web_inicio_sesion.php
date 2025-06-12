<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de Sesión | WEB</title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Web_header_no_registrado.css">
    <link rel="stylesheet" href="../css/Web_footer.css">
    <link rel="stylesheet" href="../css/Web_inicio_sesion.css">

</head>
<body>

<?php
session_start();
$errores = $_SESSION['errores'] ?? [];
$datos = $_SESSION['datos'] ?? [];
unset($_SESSION['errores'], $_SESSION['datos']);
?>

<div id="header"></div>

<!-- Imagenes de inicio de sesión -->
<img class="fondo_landing" src="../../../images/fondo_landing_web.png" alt="Imagen de fondo">
<img class="img_persona" src="../../../images/persona_inicio_sesion_web.png" alt="Imagen de la persona">

<!-- Contenedor de la pagina -->
<main>
    <!-- Contenedor del inicio de sesión -->
    <form class="contenedor_inicio_sesion" action="../php/Web_inicio_sesion.php" method="POST">
        <h1>Inicio de sesión</h1>
        <ul>
            <li>
                <label for="email">Correo</label>
                <input type="email" name="correo" id="email" placeholder="Introduce tu correo electrónico"
                       value="<?php echo htmlspecialchars($datos['correo'] ?? '', ENT_QUOTES); ?>" >
                <?php if (isset($errores['correo'])): ?>
                    <p class="mensaje-error"><?php echo htmlspecialchars($errores['correo']); ?></p>
                <?php endif; ?>
            </li>
            <li>
                <label for="password">Contraseña</label>
                <input type="password" name="contraseña" id="password" placeholder="Introduce tu contraseña" >
                <?php if (isset($errores['contraseña'])): ?>
                    <p class="mensaje-error"><?php echo htmlspecialchars($errores['contraseña']); ?></p>
                <?php endif; ?>
            </li>
        </ul>
        <button class="btn-azul-verdoso" type="submit">Acceder</button>

        <!-- Mensaje de error general, opcional -->
        <?php if (isset($errores['general'])): ?>
            <p id="mensaje-error" class="mensaje-error"><?php echo htmlspecialchars($errores['general']); ?></p>
        <?php endif; ?>

        <div class="contenido_final">
            <a href="Web_contraseña_olvidada.html">
                <p>¿Has olvidado tu <span class="parrafo_verde">Contraseña</span>?</p>
            </a>
        </div>
    </form>

</main>

<div id="footer"></div>


<script type="module">
    // Primero importamos las funciones y datos necesarios
    import { iniciarMenuHamburguesa } from "../js/Modulo_header.js";

    // Cargamos el HTML del header y footer
    fetch("Web_header_no_registrado.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa();
        });

    fetch("Web_footer.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("footer").innerHTML = html;
        });

</script>

</body>
</html>