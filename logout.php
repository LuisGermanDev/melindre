<?php
session_start(); // Inicia la sesión

// Destruye todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al inicio.php después de cerrar la sesión
header("Location: inicio.php");
exit();
?>
