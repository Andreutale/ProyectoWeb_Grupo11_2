<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos profesor | Módulo</title>
    <link rel="stylesheet" href="../css/libro_de_estilos.css">
    <link rel="stylesheet" href="../css/Modulo_header_asignaturas.css">
    <link rel="stylesheet" href="../css/Modulo_footer.css">
    <link rel="stylesheet" href="../css/Modulo_asignaturas.css">
    <link rel="stylesheet" href="../css/Modulo_recursos_profesor.css">
    <link rel="stylesheet" href="../css/Modulo_asignaturasProfesor.css">
    <script src="../js/Modulo_asignaturasProfesor.js" defer></script>
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
        <h1 class="titulo">Programación 2</h1>

        <section class="descripcion">
            <p>
                <br />
                Esta asignatura profundiza en programación orientada a objetos, estructuras de datos y buenas prácticas de desarrollo. </br
                    >Se enfoca en la resolución eficiente de problemas y el diseño modular de aplicaciones.
            </p>
        </section>

        <div class="bloques">
            <section class="bloque informacion">
                <h2>Información general</h2>
                <div class="datos">
                    <p><strong>Profesorado:</strong> Prof. Luelle Pridmore Starsmeare</p>
                    <p><strong>Idioma:</strong> Español</p>
                    <p><strong>Créditos:</strong> 6 ECTS</p>
                    <p><strong>Titulación:</strong> Grado en Tecnologías Interactivas</p>
                    <p><strong>Duración:</strong> Segundo semestre</p>
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
            <h1>Editar guía docente de la asignatura</h1>

            <!-- Pestañas -->
            <div class="tabs-container">
                <button class="tab-btn active" data-tab="informacion">Información general</button>
                <button class="tab-btn" data-tab="criterios">Criterios de evaluación</button>
            </div>

            <form id="formEditarGuia" action="../php/modificar_guia_docente.php" method="POST">
                <!-- Pestaña de Información General - SIN CAMBIOS -->
                <div id="tab-informacion" class="tab-content active">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="profesor">Profesorado</label>
                            <input type="text" id="profesor" value="Prof. Luelle Pridmore Starsmeare" disabled/>
                        </div>

                        <div class="form-group">
                            <label for="idioma">Idioma</label>
                            <input type="text" id="idioma" value="Español" />
                        </div>

                        <div class="form-group">
                            <label for="creditos">Créditos</label>
                            <input type="text" id="creditos" value="6 ECTS" />
                        </div>

                        <div class="form-group">
                            <label for="duracion">Duración</label>
                            <input type="text" id="duracion" value="Segundo semestre" />
                        </div>

                        <div class="form-group descripcion-textarea">
                            <label for="titulacion">Titulación</label>
                            <input type="text" id="titulacion" value="Grado en Tecnologías Interactivas" />
                        </div>

                        <div class="form-group descripcion-textarea">
                            <label for="descripcionAsignatura">Descripción</label>
                            <textarea name="descripcionAsignatura" id="descripcionAsignatura" rows="6" placeholder="Introduce una descripción...">Esta asignatura profundiza en programación orientada a objetos, estructuras de datos y buenas prácticas de desarrollo. Se enfoca en la resolución eficiente de problemas y el diseño modular de aplicaciones.</textarea>
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
                </div>
            </form>
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