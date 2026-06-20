<?php
// Configuración de las credenciales de la base de datos
$host = 'localhost';
$db   = 'archivo_municipal';
$user = 'root';         // Usuario por defecto en XAMPP
$pass = '';             // En XAMPP, root no tiene contraseña por defecto
$charset = 'utf8mb4';   // Codificación recomendada en tus notas de implementación

// Estructura de conexión usando PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Activa el reporte de errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve los datos en arreglos asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Mayor seguridad contra Inyección SQL
];

try {
$pdo = new PDO($dsn, $user, $pass, $options);
      $pdo->exec("SET NAMES utf8mb4");
     
} catch (\PDOException $e) {
     // Si hay un error, detiene la página y lo muestra
     die("Error de conexión a la base de datos: " . $e->getMessage());
}
?