


<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "archivo_municipal";

// Conectamos a la base de datos
$conexion = mysqli_connect($hostname, $username, $password, $database);

// Si hay un error, nos dirá exactamente qué pasa
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}
?>