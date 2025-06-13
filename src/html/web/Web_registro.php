<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro | WEB </title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Web_header_no_registrado.css">
    <link rel="stylesheet" href="../css/Web_footer.css">
    <link rel="stylesheet" href="../css/Web_registro.css">
</head>
<body>

<?php
session_start();
// Recuperamos los errores y datos de la sesión
$errores = $_SESSION['errores'] ?? [];
$datos = $_SESSION['datos'] ?? [];

// Limpiamos las variables de sesión para que no se muestren nuevamente
unset($_SESSION['errores']);
unset($_SESSION['datos']);
?>
<img class="fondo_landing" src="../../images/fondo_landing_web.png" alt="Imagen del fondo de la pantalla">
<img class="img_persona" src="../../images/persona_registro_web.png" alt="Imagen de la persona que aparece en el high fidelity
        de registro">

<div id="header"></div>
<main>
    <form class="contenedor_registro" action="../php/Web_registro.php" method="POST">
        <h1>Registro</h1>
        <ul class="contenedor_div_formulario">
            <li class="contenedor_1_formulario">
                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" type="text" placeholder="Carlos"
                       value="<?php echo isset($datos['nombre']) ? htmlspecialchars($datos['nombre']) : ''; ?>">
                <?php if(isset($errores['nombre'])): ?>
                    <p class="mensaje-error visible"><?php echo $errores['nombre']; ?></p>
                <?php endif; ?>

                <label for="correo">Correo</label>
                <input id="correo" name="correo" type="email" placeholder="carlosgarcia@gmail.com"
                       value="<?php echo isset($datos['correo']) ? htmlspecialchars($datos['correo']) : ''; ?>">
                <?php if(isset($errores['correo'])): ?>
                    <p class="mensaje-error visible"><?php echo $errores['correo']; ?></p>
                <?php endif; ?>

                <label for="contraseña">Contraseña</label>
                <input id="contraseña" name="contraseña" type="password" placeholder="*********">
                <?php if(isset($errores['contraseña'])): ?>
                    <p class="mensaje-error visible"><?php echo $errores['contraseña']; ?></p>
                <?php endif; ?>
            </li>
            <li class="contenedor_2_formulario">
                <label for="apellidos">Apellidos</label>
                <input id="apellidos" name="apellidos" type="text" placeholder="García"
                       value="<?php echo isset($datos['apellidos']) ? htmlspecialchars($datos['apellidos']) : ''; ?>">
                <?php if(isset($errores['apellidos'])): ?>
                    <p class="mensaje-error visible"><?php echo $errores['apellidos']; ?></p>
                <?php endif; ?>

                <label for="telefono">Teléfono</label>
                <input id="telefono" name="telefono" type="text" placeholder="987 654 321"
                       value="<?php echo isset($datos['telefono']) ? htmlspecialchars($datos['telefono']) : ''; ?>">
                <?php if(isset($errores['telefono'])): ?>
                    <p class="mensaje-error visible"><?php echo $errores['telefono']; ?></p>
                <?php endif; ?>

                <label for="confirmarContraseña">Confirmar contraseña</label>
                <input id="confirmarContraseña" name="confirmarContraseña" type="password" placeholder="*********">
                <?php if(isset($errores['confirmar'])): ?>
                    <p class="mensaje-error visible"><?php echo $errores['confirmar']; ?></p>
                <?php endif; ?>
            </li>
        </ul>

        <?php if(isset($errores['general'])): ?>
            <p class="mensaje-error visible"><?php echo $errores['general']; ?></p>
        <?php endif; ?>

        <button class="btn-azul-verdoso" type="submit">Regístrate</button>
        <a href="Web_inicio_sesion.php"><p>¿Ya tienes cuenta? <span class="parrafo_verde">Inicia Sesión</span></p></a>
    </form>
</main>


<div id="footer"></div>

<script type="module">
    import { iniciarMenuHamburguesa } from "../js/Modulo_header.js";
    // Cargamos el HTML del header y footer
    fetch("../php/cargar_header.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa(); // Si tienes esta función para el menú
        });

    fetch("Web_footer.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("footer").innerHTML = html;
        });
</script>

</body>
</html>