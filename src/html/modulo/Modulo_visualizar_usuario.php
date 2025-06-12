<?php
session_start();
include('../../app/conexion.inc');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('../../app/conexion.inc');

    $id_usuario = intval($_GET['id']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $dni = $conexion->real_escape_string($_POST['dni']);

    $sql_update = "
        UPDATE usuariosmodulo SET 
            nombre = '$nombre',
            apellidos = '$apellidos',
            correo = '$correo',
            dni = '$dni'
        WHERE id = $id_usuario
    ";

    $conexion->query($sql_update);
    $conexion->close();

    // Redirigir para evitar re-envío en refresco
    header("Location: Modulo_visualizar_usuario.php?id=$id_usuario");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID de usuario no especificado.");
}

$id_usuario = intval($_GET['id']);

// Obtener datos del usuario
$sql_usuario = "SELECT * FROM usuariosmodulo WHERE id = $id_usuario";
$resultado_usuario = $conexion->query($sql_usuario);

if ($resultado_usuario->num_rows === 0) {
    die("Usuario no encontrado.");
}

$usuario = $resultado_usuario->fetch_assoc();

// Obtener asignaturas según rol
$rol = $usuario['rol'];
$asignaturas = [];

if ($rol === 'alumno') {
    $sql_asignaturas = "
        SELECT a.id, a.nombre 
        FROM asignaturas a
        INNER JOIN alumnos_asignaturas aa ON a.id = aa.id_asignatura
        WHERE aa.id_alumno = $id_usuario";
} elseif ($rol === 'profesor') {
    $sql_asignaturas = "
        SELECT a.id, a.nombre 
        FROM asignaturas a
        INNER JOIN profesores_asignaturas pa ON a.id = pa.id_asignatura
        WHERE pa.id_profesor = $id_usuario";
} else {
    $sql_asignaturas = "";
}

if ($sql_asignaturas) {
    $resultado_asignaturas = $conexion->query($sql_asignaturas);
    while ($fila = $resultado_asignaturas->fetch_assoc()) {
        $asignaturas[] = $fila;
    }
}

$conexion->close();
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar usuario | MÓDULO</title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Modulo_header.css">
    <link rel="stylesheet" href="../css/Modulo_footer.css">
    <link rel="stylesheet" href="../css/Modulo_visualizar_usuario.css">
</head>
<body>
<!-- HEADER -->
<div id="header"></div>

<main>
    <section class="container">
        <h1>Visualizar usuario</h1>

        <p class="cruz_salir">&times;</p>

        <img src="../../../images/iconos/web_perfil.svg" alt="Foto de perdil" class="user-img">
        <button id="btn-editar" class="btn-editar">Editar usuario</button>

        <div id="botones-edicion" style="display: none;">
            <button type="submit" form="form-usuario" class="btn-confirmar">Confirmar</button>
            <button type="button" id="cancelar-edicion" class="btn-cancelar">Cancelar</button>
        </div>


        <!-- INFORMACIÓN PERSONAL -->
        <form id="form-usuario" method="POST" action="Modulo_visualizar_usuario.php?id=<?php echo $usuario['id']; ?>">
            <div class="user-info">
                <div>
                    <p>Nombre</p>
                    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" disabled>
                </div>
                <div>
                    <p>Apellidos</p>
                    <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" disabled>
                </div>
                <div>
                    <p>Correo</p>
                    <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" disabled>
                </div>
                <div>
                        <p>DNI</p>
                    <input type="text" name="dni" id="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>" disabled>
                </div>
                <div>
                    <p>Rol</p>
                    <input type="text" name="rol" id="rol" value="<?php echo htmlspecialchars($usuario['rol']); ?>" disabled>
                </div>
                <!--div>
                    <p>Grado</p>
                    <input type="text" name="grado" id="grado" value="<?php echo htmlspecialchars($usuario['grado']); ?>" disabled>
                </div-->
            </div>
        </form>


        <!-- DATOS TABLA ASIGNATURAS MATRICULADAS-->
        <h2><?php echo ($rol === 'profesor') ? 'Asignaturas impartidas' : 'Asignaturas matriculadas'; ?></h2>
        <table>
            <thead>
            <tr>
                <th><p>Nombre</p></th>
                <th><p>ID</p></th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($asignaturas) > 0): ?>
                <?php foreach ($asignaturas as $asignatura): ?>
                    <tr>
                        <td><p><?php echo htmlspecialchars($asignatura['nombre']); ?></p></td>
                        <td><p><?php echo htmlspecialchars($asignatura['id']); ?></p></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2"><p>No hay asignaturas matriculadas.</p></td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<!-- FOOTER -->
<div id="footer"></div>

<!-- SCRIPTS GENERALES -->
<script type="module">
    // Primero importamos las funciones y datos necesarios
    import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';
    import { usuarios } from '../../app/usuarios.js';

    // Cargamos el HTML del header y footer
    fetch("Modulo_header_sin_ola.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa(); // Aquí activamos el menú hamburguesa
        });

    fetch("Modulo_footer.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("footer").innerHTML = html;
        });

    // Si necesitas acceder a los usuarios en algún momento, ya puedes hacerlo
    console.log("Usuarios cargados:", usuarios);
</script>

<!-- SCRIPT ESPECÍFICO -->
<script src="../js/Modulo_visualizar_usuario.js"></script>
</body>
</html>