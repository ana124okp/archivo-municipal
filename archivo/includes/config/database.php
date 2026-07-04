<?php
/**
 * Configuración de la Base de Datos
 * Sistema de Gestión de Archivos Municipales
 */

// Datos de conexión
$hostname = "localhost";
$username = "root";
$password = "";
$database = "archivo_municipal";

// Crear conexión
$conn = mysqli_connect($hostname, $username, $password, $database);

// Establecer charset UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Verificar conexión
if (!$conn) {
    die(json_encode([
        'success' => false,
        'message' => 'Error de conexión: ' . mysqli_connect_error()
    ]));
}

// Función para prevenir inyección SQL
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Función para ejecutar queries
function executeQuery($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return [
            'success' => false,
            'error' => mysqli_error($conn)
        ];
    }
    return $result;
}

// Cerrar sesión de BD al finalizar
register_shutdown_function(function() {
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
});
?>
