    <?php
include('../../app/auth.php');
verificarToken();
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contacto</title>
  <link rel="stylesheet" href="../css/Web_contacto.css" />
  <link rel="stylesheet" href="../css/Web_header_registrado.css">
  <link rel="stylesheet" href="../css/Web_footer.css">
  <link rel="stylesheet" href="../css/libro_de_estilos.css">
</head>
<body>
  <!-- Header -->
  <div id="header"></div>

  <!-- Sección principal -->
<section class="consulta-section">
  <h1 class="consulta-titulo">Contáctanos para poder ayudarte</h1>
  <h2 class="consulta-subtitulo">Completa el formulario y te responderemos pronto</h2>

    <div class="consulta-container">
      <form class="consulta-form">
        <div class="form-left">
          <div class="input-group">
            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre" required />
          </div>

          <div class="input-group">
            <label for="producto">Producto *</label>
              <select id="producto" name="modulos">
                  <option value="1">Recursos</option>
                  <option value="2">Calificaciones</option>
                  <option value="3">Exámenes</option>
                  <option value="4">Anuncios</option>
                  <option value="5">Tareas</option>
                  <option value="6">Correo interno</option>
                  <option value="7">Foros</option>
                  <option value="8">Videoapuntes</option>
              </select>
          </div>

          <div class="input-group">
            <label for="mensaje">Mensaje *</label>
            <textarea id="mensaje" name="mensaje" required></textarea>
          </div>
        </div>

        <div class="form-right">
          <div class="input-group">
            <label for="apellidos">Apellidos *</label>
            <input type="text" id="apellidos" name="apellidos" required />
          </div>

          <div class="input-group">
            <label for="entidad">Entidad *</label>
            <input type="text" id="entidad" name="entidad" required />
          </div>

          <div class="input-group">
            <label for="correo">Correo electrónico *</label>
            <input type="email" id="correo" name="correo" required />
          </div>

          <button type="submit">Enviar</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <id id="footer"></id>

  <script type="module">
    // Importamos el menu hamburguesa
    import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';


    // Cargamos el HTML del header y footer
    fetch("Web_header_registrado.html")
            .then(res => res.text())
            .then(html => {
              document.getElementById("header").innerHTML = html;
              iniciarMenuHamburguesa(); // Aquí activamos el menú hamburguesa
            });

    fetch("Web_footer.html")
            .then(res => res.text())
            .then(html => {
              document.getElementById("footer").innerHTML = html;
            });
  </script>

<script type="module">
  import { iniciarMenuHamburguesa } from '../js/Modulo_header.js'
  iniciarMenuHamburguesa();

  const formulario = document.querySelector('.consulta-form');
  const popup = document.getElementById('popup-exito');

  formulario.addEventListener('submit', (event) => {
    event.preventDefault(); 
    formulario.reset();

    popup.style.display = 'flex'; 

    setTimeout(() => {
      popup.style.display = 'none'
    }, 3000);
  });
</script>

  <img class="fondo_contacto" src="../../../images/fondo_landing_web.png" alt="Fondo de la sección de consulta">

<div id="popup-exito" class="popup">
  <div class="popup-contenido">
    <p>Su consulta ha sido enviada con éxito</p>
  </div>
</div>

</body>
</html>
