
<?php
session_start();
include('../../app/conexion.inc');

// Verificar sesión y rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'alumno') {
    header("Location: Modulo_Inicio_Sesion.html");
    exit();
}

// Obtener ID de asignatura
$asignatura_id = isset($_GET['asignatura_id']) ? (int)$_GET['asignatura_id'] : 0;

// Verificar que el alumno tiene permiso para esta asignatura
$query = "SELECT COUNT(*) 
          FROM alumnos_asignaturas 
          WHERE id_alumno = ? AND id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ii", $_SESSION['user_id'], $asignatura_id);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count === 0) {
    die("No tienes permiso para acceder a esta asignatura");
}

// Obtener nombre de la asignatura
$query = "SELECT nombre FROM asignaturas WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$stmt->bind_result($nombre_asignatura);
$stmt->fetch();
$stmt->close();

// Obtener archivos de esta asignatura
$query = "SELECT a.id, a.id_autor, a.nombre, a.fecha, a.tipo, u.nombre as nombre_autor
          FROM archivosmodulo a
          JOIN usuariosmodulo u ON a.id_autor = u.id
          WHERE a.id_asignatura = ? 
          ORDER BY a.fecha DESC";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$result = $stmt->get_result();
$archivos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener asignaturas del alumno para el menú lateral
$query = "SELECT a.id, a.nombre 
          FROM asignaturas a
          JOIN alumnos_asignaturas pa ON a.id = pa.id_asignatura
          WHERE pa.id_alumno = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$asignaturas_result = $stmt->get_result();
$asignaturas = $asignaturas_result->fetch_all(MYSQLI_ASSOC);
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
    <title>Recursos alumno | Módulo</title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Modulo_header.css">
    <link rel="stylesheet" href="../css/Modulo_footer.css">
    <link rel="stylesheet" href="../css/Modulo_recursos_alumno.css">
</head>
<body>

<!-- Añadido el header-->
<div id="header"></div>

<!-- Cuerpo del codigo -->
<main>
    <!-- Apartado de asignaturas -->
    <div class="asignaturas">
        <?php foreach ($asignaturas as $asig): ?>
            <a href="Modulo_recursos_alumno.php?asignatura_id=<?= $asig['id'] ?>">
                <div class="btn-azul-claro <?= $asig['id'] == $asignatura_id ? 'active' : '' ?>">
                    <h3><?= htmlspecialchars($asig['nombre']) ?></h3>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Contenedor de la pagina -->
    <div class="contenedor_pagina">
        <!-- Contenedor de la ruta y los botones -->
        <div class="contenedor_ruta">
            <h2>Recursos: <span id="cambio"><?= htmlspecialchars($nombre_asignatura) ?></span></h2>
            <div class="contenedo_botones">
                <button class="btn-azul-claro btn-descargar">Descargar archivos</button>
                <button class="btn-azul-claro btn-añadirRecurso" id="btnAñadirRecurso">
                    <img src="../../images/iconos/icono_añadir_sumar.png" alt="Icono de añadir">
                </button>
            </div>
        </div>

        <!-- Tabla de la pagina-->
        <table id="tablaRecursos">
            <thead>
            <!-- Header de la tabla -->
            <tr>
                <!-- Checkbox -->
                <th>

                </th>
                <!-- Nombre -->
                <th data-sort="nombre">
                    <a href="#" class="sortable"><h3>Nombre</h3><img class="flecha_desplegable"
                                                                     src="../../images/iconos/icono_flecha_desplegable.png"
                                                                     alt="Icono de la flecha desplegable"></a>
                </th>
                <!-- Autor -->
                <th data-sort="autor">
                    <a href="#" class="sortable"><h3>Autor</h3><img class="flecha_desplegable"
                                                                    src="../../images/iconos/icono_flecha_desplegable.png"
                                                                    alt="Icono de la flecha desplegable"></a>
                </th>
                <!-- Fecha -->
                <th data-sort="fecha">
                    <a href="#" class="sortable"><h3>Fecha <span class="datos_responsive">de Publicación</span></h3><img
                                class="flecha_desplegable" src="../../images/iconos/icono_flecha_desplegable.png"
                                alt="Icono de la flecha desplegable"></a>
                </th>
                <!-- Tipo -->
                <th data-sort="tipo">
                    <a href="#" class="sortable"><h3><span class="datos_responsive">Tipo de </span>Archivo</h3><img
                                class="flecha_desplegable" src="../../images/iconos/icono_flecha_desplegable.png"
                                alt="Icono de la flecha desplegable"></a>
                </th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($archivos

            as $archivo):
            $fecha_formateada = date('d/m/y', strtotime($archivo['fecha']));
            $tipo_archivo = obtenerTipoArchivo($archivo['tipo']);
            ?>
            <tr>
                <td>
                    <!--label class="checkbox-con-imagen">
                                <input type="checkbox" class="rowCheckbox" name="archivos_seleccionados[]" value="<?= $archivo['id'] ?>">
                                <img src="../../../images/iconos/icono_tick.png" alt="Icono del tick de seleccionado">
                            </label-->
                </td>
                <td>
                    <div class="nombreMasImagen">
                        <img src="../../images/iconos/icono_fichero.png" alt="Icono de <?= $tipo_archivo ?>">
                        <h3><?= htmlspecialchars($archivo['nombre']) ?></h3>
                    </div>
                </td>
                <td><h3><?= htmlspecialchars($archivo['nombre_autor']) ?></h3></td>
                <td><h3 data-date="<?= $archivo['fecha'] ?>"><?= $fecha_formateada ?></h3></td>
                <td><h3><?= $tipo_archivo ?></h3></td>
                <td class="responsive-actions">
                    <button class="btn-azul-claro btn-desplegable-responsive">
                        <img src="../../images/iconos/icono_flecha_desplegable.png" alt="Mostrar más">
                    </button>
                </td>
                <td>
                    <div class="dropdown-container">
                        <a href="../php/descargar_archivo.php?id=<?= $archivo['id'] ?>" class="dropdown-item">
                            <button class="btn-azul-claro">Descargar</button>
                        </a>
                        <form action="../php/eliminar_archivo.php" method="POST" class="dropdown-item-form">
                            <input type="hidden" name="id_archivo" value="<?= $archivo['id'] ?>">
                            <button type="submit" class="dropdown-item-btn btn-azul-claro"
                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo?')">
                                Eliminar
                            </button>
                        </form>
                    </div>
    </div>
    </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
</main>

<?php
// Funciones auxiliares
function obtenerTipoArchivo($tipo_mime) {
    $partes = explode('/', $tipo_mime);
    $tipo = $partes[0];

    $tipos = [
        'image' => 'Imagen',
        'application' => 'Documento',
        'text' => 'Texto',
        'audio' => 'Audio',
        'video' => 'Video',
        'folder' => 'Carpeta'
    ];

    return $tipos[$tipo] ?? 'Archivo';
}

function obtenerIconoPorTipo($tipo_mime) {
    $partes = explode('/', $tipo_mime);
    $tipo = $partes[0];

    $iconos = [
        'image' => 'icono_imagen.png',
        'application' => 'icono_documento.png',
        'text' => 'icono_documento.png',
        'audio' => 'icono_audio.png',
        'video' => 'icono_video.png',
        'folder' => 'icono_carpeta.png'
    ];

    return $iconos[$tipo] ?? 'icono_fichero.png';
}

function obtenerNombreUsuario($id_usuario) {
    // Esta función debería obtener el nombre del usuario desde la base de datos
    // Para simplificar, aquí devolvemos un valor estático
    return "Profesor";
}
?>


<div id="footer"></div>

<script type="module">
    // Importar funciones del header
    import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';

    // Cargar header y footer
    fetch("Modulo_header_asignaturas.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa();
        });

    fetch("Modulo_footer.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("footer").innerHTML = html;
        });
</script>

<script src="../js/Modulo_recursos_alumno.js"></script>

<script type="module" src="../js/Modulo_recursos_profesor.js" ></script>

</body>
</html>