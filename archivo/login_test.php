<?php
/**
 * LOGIN - Prueba directa
 */

session_start();

$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'anayeli_admin';
$_SESSION['email'] = 'anayeli@municipio.gob.mx';
$_SESSION['nombre'] = 'Anayeli Ortiz';
$_SESSION['role'] = 'Administrador';
$_SESSION['login_time'] = time();

header('Location: app.php');
exit();
