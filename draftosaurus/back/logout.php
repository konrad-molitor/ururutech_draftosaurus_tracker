<?php
// Eliminar cookies caducadas
setcookie("user", "", time() - 3600, "/");
setcookie("role", "", time() - 3600, "/");

// Cerrar sesión
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// Redirigir a la página principal
header("Location: ../front/index.php");
exit();
