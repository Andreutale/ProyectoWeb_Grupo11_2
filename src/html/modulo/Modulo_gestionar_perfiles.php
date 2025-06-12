<?php
session_start();
include('../../app/conexion.inc');
// Conexión a la base de datos

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener usuarios con rol de alumno o profesor
$busqueda = isset($_GET['busqueda']) ? $conexion->real_escape_string($_GET['busqueda']) : '';

if (!empty($busqueda)) {
    $sql = "SELECT id, nombre, apellidos, correo, rol FROM usuariosmodulo 
            WHERE rol IN ('alumno', 'profesor') AND 
            (nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%' OR dni LIKE '%$busqueda%')";
} else {
    $sql = "SELECT id, nombre, apellidos, correo, rol FROM usuariosmodulo WHERE rol IN ('alumno', 'profesor')";
}

$resultado = $conexion->query($sql);

$conexion->close();
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Gestionar perfiles | Modulo</title>
  <link rel="stylesheet" href="../css/libro_de_estilos.css">
  <link rel="stylesheet" href="../css/Modulo_header.css">
  <link rel="stylesheet" href="../css/Modulo_footer.css">
  <link rel="stylesheet" href="../css/Modulo_gestionar_perfiles.css">
  <script src="../js/Modulo_gestionar_perfiles.js" defer></script>




<body>

<!-- Apartado del header -->
<div id="header"></div>


<main>
  <div>
    <h1>Perfiles</h1>
  </div>

    <div class="buscador_gestionar_perfiles">
        <form method="get" action="Modulo_gestionar_perfiles.php">
            <input id="Input_buscador" name="busqueda" type="text" placeholder="Buscar usuarios..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <button id="Icono_buscador" class="btn-azul-claro" type="submit"><img src="../../../images/iconos/icono_lupa.png" alt="Icono de la lupa"></button>
        </form>
    </div>
  <!-- cabezera de la tabla -->
  <div class="tabla_scrolleable">
    <table id="tablaRecursos">
      <thead>
      <tr>
        <th><a href="#" class="sortable"><h3>Nombre</h3><img class="flecha_desplegable" src="../../../images/iconos/icono_flecha_desplegable.png" alt=""></a></th>
        <th><a href="#" class="sortable"><h3>Rol</h3><img class="flecha_desplegable" src="../../../images/iconos/icono_flecha_desplegable.png" alt=""></a></th>
        <th><a href="#" class="sortable"><h3>Correo electrónico</h3><img class="flecha_desplegable" src="../../../images/iconos/icono_flecha_desplegable.png" alt=""></a></th>
        <th>
          <div>
            <button><h3>Añadir <span class="esconder">Usuario</span></h3></button>
          </div>
        </th>
      </tr>
      </thead>



      <tbody>
      <?php
      if ($resultado->num_rows > 0) {
      // Mostrar cada usuario en una fila de la tabla
      while($fila = $resultado->fetch_assoc()) {
      echo '<tr>';
        echo '<td><h3>' . htmlspecialchars($fila["nombre"] . ' ' . $fila["apellidos"]) . '</h3></td>';
        echo '<td><h3>' . htmlspecialchars($fila["rol"]) . '</h3></td>';
        echo '<td><h3>' . htmlspecialchars($fila["correo"]) . '</h3></td>';
        echo '<td>';
          echo '<a href="Modulo_visualizar_usuario.php?id=' . $fila["id"] . '"><button class="botones_gestionar_perfiles"><img src="../../../images/iconos/icono_ojo.png" alt="Icono de visualizar usuario"></button></a>';
          echo '<button class="botones_gestionar_perfiles boton_papelera" data-id="' . $fila["id"] . '"><img src="../../../images/iconos/icono_papelera.png" alt="Icono de la papelera"></button>';
          echo '</td>';
        echo '</tr>';
      }
      } else {
      echo '<tr><td colspan="4"><h3>No se encontraron usuarios</h3></td></tr>';
      }
      ?>
      </tbody>



    </table>
  </div>
</main>

<!-- Modal para añadir usuario -->
<div id="modalAñadirUsuario" class="modal hidden">
    <div class="modal-content">
        <span id="cerrarModal" class="cerrar">&times;</span>
        <h2>Añadir nuevo usuario</h2>
        <form id="formularioNuevoUsuario">
            <label for="nombreUsuario">Nombre:</label>
            <input type="text" id="nombreUsuario" required>

            <label for="apellidosUsuario">Apellidos:</label>
            <input type="text" id="apellidosUsuario" required>

            <label for="dniUsuario">DNI:</label>
            <input type="text" id="dniUsuario" required pattern="[0-9]{8}[A-Za-z]" title="8 números seguidos de una letra">

            <label for="correoUsuario">Correo electrónico:</label>
            <input type="email" id="correoUsuario" required>

            <label for="contraseñaUsuario">Contraseña:</label>
            <input type="password" id="contraseñaUsuario" required minlength="6">

            <label for="confirmarContraseña">Confirmar contraseña:</label>
            <input type="password" id="confirmarContraseña" required minlength="6">

            <label for="rolUsuario">Rol:</label>
            <select id="rolUsuario" required>
                <option value="">Selecciona un rol</option>
                <option value="alumno">Alumno</option>
                <option value="profesor">Profesor</option>
                <option value="pas">PAS</option>
            </select>

            <div class="mensaje-error" id="mensajeError"></div>

            <button type="submit" class="btn-azul-claro">Confirmar</button>
        </form>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div id="modalConfirmarEliminar" class="modal hidden">
    <div class="modal-content">
        <span class="cerrar">&times;</span>
        <h2>Confirmar eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
        <div class="botones-confirmacion">
            <button id="confirmarEliminar" class="btn-rojo">Eliminar</button>
            <button id="cancelarEliminar" class="btn-azul-claro">Cancelar</button>
        </div>
    </div>
</div>


<!-- Apartado del footer -->
<div id="footer"></div>

<!-- Scripts -->
<script type="module">
  // Primero importamos las funciones y datos necesarios
  import { iniciarMenuHamburguesa } from '../js/Modulo_header.js';
  import { usuarios } from '../../app/usuarios.js';

  // Cargamos el HTML del header y footer
  fetch("Modulo_header_sin_ola.html")
          .then(res => res.text())
          .then(html => {
            document.getElementById("header").innerHTML = html;
            iniciarMenuHamburguesa(); //
          });

  fetch("Modulo_footer.html")
          .then(res => res.text())
          .then(html => {
            document.getElementById("footer").innerHTML = html;
          });

  // Si necesitas acceder a los usuarios en algún momento, ya puedes hacerlo
  console.log("Usuarios cargados:", usuarios);
</script>




</body>
</html>