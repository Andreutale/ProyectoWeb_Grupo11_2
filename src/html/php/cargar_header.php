<?php
session_start();

if (isset($_SESSION['token'])) {
    // Header para usuario registrado
    readfile("../web/Web_header_registrado.html");
} else {
    // Header para visitante
    readfile("../web/Web_header_no_registrado.html");
}
?>
