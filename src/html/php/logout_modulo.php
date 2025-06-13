<?php
session_start();
session_destroy();
header("Location: ../modulo/Modulo_Inicio_Sesion.php");
exit();
