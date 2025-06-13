<?php
session_start();
include('../../app/conexion.inc');

// Verificar sesión y rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'profesor') {
    header("Location: Modulo_Inicio_Sesion.html");
    exit();
}

// Obtener ID de asignatura
$asignatura_id = isset($_GET['asignatura_id']) ? (int)$_GET['asignatura_id'] : 0;

// Verificar que el profesor tiene permiso para esta asignatura
$query = "SELECT COUNT(*) 
          FROM profesores_asignaturas 
          WHERE id_profesor = ? AND id_asignatura = ?";
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
$query = "SELECT `nombre`,`ects`,`idioma`,`grado`,`duracion`,`descripcion` FROM asignaturas WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$stmt->bind_result($nombre,$ects,$idioma,$grado,$duracion,$descripcion);
$stmt->fetch();
$stmt->close();

// Obtener profesores de la asignatura
$query = "
    SELECT u.nombre, u.apellidos 
    FROM usuariosmodulo u
    INNER JOIN profesores_asignaturas pa ON u.id = pa.id_profesor
    WHERE pa.id_asignatura = ?
";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$result = $stmt->get_result();

$profesores = [];
while ($row = $result->fetch_assoc()) {
    $profesores[] = $row['nombre'] . ' ' . $row['apellidos'];
}
$stmt->close();

// Unir los nombres en una sola cadena
$nombres_profesores = implode(', ', $profesores);

// Obtener criterios de evaluación desde la BD
$query = "SELECT id, nombre, valor FROM criterios_asignaturas WHERE id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $asignatura_id);
$stmt->execute();
$result = $stmt->get_result();

$criteriosEvaluacion = [];
while ($row = $result->fetch_assoc()) {
    $criteriosEvaluacion[] = $row;
}
$stmt->close();

// Obtener asignaturas del profesor para el menú lateral
$query = "SELECT a.id, a.nombre 
          FROM asignaturas a
          JOIN profesores_asignaturas pa ON a.id = pa.id_asignatura
          WHERE pa.id_profesor = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$asignaturas_result = $stmt->get_result();
$asignaturas = $asignaturas_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();


$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía docente profesor | Módulo</title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Modulo_header_asignaturas.css">
    <link rel="stylesheet" href="../css/Modulo_footer.css">
    <link rel="stylesheet" href="../css/Modulo_asignaturas.css">
    <link rel="stylesheet" href="../css/Modulo_recursos_profesor.css">
    <link rel="stylesheet" href="../css/Modulo_asignaturasProfesor.css">
    <script src="../js/Modulo_guia_docente_profesor.js" defer></script>
</head>
<body>

<div id="header"></div>

<main>
    <div class="asignaturas">
        <?php foreach ($asignaturas as $asig): ?>
            <a href="Modulo_guia_docente_profesor.php?asignatura_id=<?= $asig['id'] ?>">
                <div class="btn-azul-claro <?= $asig['id'] == $asignatura_id ? 'active' : '' ?>">
                    <h3><?= htmlspecialchars($asig['nombre']) ?></h3>
                </div>
            </a>
        <?php endforeach; ?>
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
                <ul class="criterios" id="lista-criterios">
                    <!-- Los criterios se cargarán dinámicamente -->
                </ul>
            </section>
        </div>

        <div class="boton-editar-contenedor">
            <button id="btnEditarGuia" class="btn-azul-claro">Editar guía docente</button>
        </div>
    </div>

    <!-- Modal EDITAR GUÍA -->
    <div id="modalEditarGuia" class="modal">
        <div class="modal-content modal-editar-guia">
            <span class="close-modal">&times;</span>
            <h1>Editar guía docente de <?php echo $nombre?></h1>

            <!-- Pestañas -->
            <div class="tabs-container">
                <button class="tab-btn active" data-tab="informacion">Información general</button>
                <button class="tab-btn" data-tab="criterios">Criterios de evaluación</button>
            </div>

            <form id="formEditarGuia" action="../php/modificar_guia_docente.php" method="POST">
                <!-- Pestaña de Información General -->
                <div id="tab-informacion" class="tab-content active">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="profesor">Profesorado</label>
                            <input type="text" id="profesor" value="<?php echo htmlspecialchars($nombres_profesores); ?>" disabled/>
                        </div>

                        <div class="form-group">
                            <label for="idioma">Idioma</label>
                            <input type="text" id="idioma" value="<?php echo htmlspecialchars($idioma)?>" disabled/>
                        </div>

                        <div class="form-group">
                            <label for="creditos">Créditos</label>
                            <input type="text" id="creditos" value="<?php echo htmlspecialchars($ects)?> ECTS" disabled/>
                        </div>

                        <div class="form-group">
                            <label for="duracion">Duración</label>
                            <input type="text" id="duracion" value="<?php echo ($duracion === 'A') ? 'Primer semestre' : (($duracion === 'B') ? 'Segundo semestre' : 'Anual'); ?>" disabled/>
                        </div>

                        <div class="form-group descripcion-textarea">
                            <label for="titulacion">Titulación</label>
                            <input type="text" id="titulacion" value="<?php echo htmlspecialchars($grado)?>" disabled/>
                        </div>

                        <div class="form-group descripcion-textarea">
                            <label for="descripcionAsignatura">Descripción</label>
                            <textarea name="descripcionAsignatura" id="descripcionAsignatura" rows="6" placeholder="Introduce una descripción..."><?php echo htmlspecialchars($descripcion)?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Pestaña de Criterios de Evaluación - MODIFICADA -->
                <div id="tab-criterios" class="tab-content">
                    <div id="contenedor-criterios">
                        <!-- Los criterios se generarán dinámicamente -->
                    </div>
                    <div class="boton-anadir-contenedor">
                        <button type="button" id="btnAnadirCriterio" class="btn-azul-claro">+ Añadir criterio</button>
                    </div>
                </div>

                <div class="form-boton-guardar">
                    <button type="submit" class="btn-azul-claro">Guardar cambios</button>
                    <input type="hidden" name="asignatura_id" value="<?= $_GET['asignatura_id'] ?>">
                </div>
            </form>
        </div>
    </div>
</main>

<div id="footer"></div>

<script type="module">
    import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';

    // Lee el valor de asignatura_id desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const asignaturaIdURL = urlParams.get('asignatura_id');

    if (asignaturaIdURL) {
        localStorage.setItem('asignatura_id', asignaturaIdURL);
    }

    const asignaturaId = localStorage.getItem('asignatura_id');

    // Cargar header con la asignatura correcta
    fetch(`Modulo_header_asignaturas_profesor.php?asignatura_id=${asignaturaId}`)
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

<script>
    const criteriosEvaluacionBD = <?php echo json_encode($criteriosEvaluacion); ?>;
</script>

</body>
</html>