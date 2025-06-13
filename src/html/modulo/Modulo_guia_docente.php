<?php
session_start();
include('../../app/conexion.inc');

// Verificar sesión y rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'alumno') {
    header("Location: Modulo_Inicio_Sesion.php");
    exit();
}

// Obtener ID de asignatura
$asignatura_id = isset($_GET['asignatura_id']) ? (int)$_GET['asignatura_id'] : 0;

// Verificar que el alumno tiene acceso
$query = "SELECT COUNT(*) FROM alumnos_asignaturas WHERE id_alumno = ? AND id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ii", $_SESSION['user_id'], $asignatura_id);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count === 0) {
    die("No tienes permiso para acceder a esta asignatura");
}

// Obtener datos de la asignatura
$query = "SELECT nombre, ects, idioma, grado, duracion, descripcion FROM asignaturas WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$stmt->bind_result($nombre, $ects, $idioma, $grado, $duracion, $descripcion);
$stmt->fetch();
$stmt->close();

// Obtener profesores de la asignatura
$query = "SELECT u.nombre, u.apellidos FROM usuariosmodulo u INNER JOIN profesores_asignaturas pa ON u.id = pa.id_profesor WHERE pa.id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$result = $stmt->get_result();

$profesores = [];
while ($row = $result->fetch_assoc()) {
    $profesores[] = $row['nombre'] . ' ' . $row['apellidos'];
}
$stmt->close();
$nombres_profesores = implode(', ', $profesores);

// Obtener criterios de evaluación
$query = "SELECT nombre, valor FROM criterios_asignaturas WHERE id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$result = $stmt->get_result();

$criteriosEvaluacion = [];
while ($row = $result->fetch_assoc()) {
    $criteriosEvaluacion[] = $row;
}
$stmt->close();
$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos alumno | Módulo</title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Modulo_header_asignaturas.css">
    <link rel="stylesheet" href="../css/Modulo_footer.css">
    <link rel="stylesheet" href="../css/Modulo_asignaturas.css">
    <link rel="stylesheet" href="../css/Modulo_recursos_profesor.css">
    <link rel="stylesheet" href="../css/Modulo_asignaturasProfesor.css">
</head>
<body>

<div id="header"></div>

<main>
    <div class="asignaturas">
        <div class="btn-azul-claro">
            <h3>Programación 1</h3>
        </div>
        <div class="btn-azul-claro">
            <h3>Programación en sistemas cloud</h3>
        </div>
        <div class="btn-azul-claro">
            <h3>Proyecto Aplicaciones de Biometría y Medio Ambiente</h3>
        </div>
        <img id="img_puntos_suspensivos" src="../../../images/iconos/icono_tres_puntos_suspensivos.png" alt="Icono marcapaginas">
    </div>

    <div class="guia-container">
        <h1 class="titulo"><?php echo $nombre?></h1>

        <section class="descripcion">
            <p>
                <?php echo $descripcion?>
            </p>
        </section>

        <div class="bloques">
            <section class="bloque informacion">
                <h2>Información general</h2>
                <div class="datos">
                    <p><strong>Profesorado:</strong> <?php echo htmlspecialchars($nombres_profesores); ?></p>
                    <p><strong>Idioma:</strong> <?php echo $idioma?></p>
                    <p><strong>Créditos:</strong> <?php echo $ects?> ECTS</p>
                    <p><strong>Titulación:</strong> <?php echo $grado?></p>
                    <p><strong>Duración:</strong> <?php echo ($duracion === 'A') ? 'Primer semestre' : (($duracion === 'B') ? 'Segundo semestre' : 'Anual'); ?></p>
                </div>
            </section>

            <section class="bloque evaluacion">
                <h2>Criterios de evaluación</h2>
                <ul class="criterios">
                    <?php foreach ($criteriosEvaluacion as $criterio): ?>
                        <li><?php echo htmlspecialchars($criterio['nombre']); ?>: <?php echo htmlspecialchars($criterio['valor']); ?>%</li>
                    <?php endforeach; ?>
                </ul>

            </section>
        </div>
    </div>
</main>

<div id="footer"></div>

<script type="module">
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

</body>
</html>