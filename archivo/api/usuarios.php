<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$query = "SELECT id_usuario, usuario FROM usuarios ORDER BY id_usuario ASC";
$result = $conexion->query($query);

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode(['success' => true, 'data' => $usuarios]);
