<?php
/**
 * LOGOUT - Cerrar Sesión
 */

session_start();

session_destroy();

header('Location: ../../index.php');
exit();
?>
