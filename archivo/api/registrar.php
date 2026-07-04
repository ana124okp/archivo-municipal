<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$input = [];
$rawInput = file_get_contents('php://input');
if ($rawInput !== '') {
    $decoded = json_decode($rawInput, true);
    if (is_array($decoded)) {
        $input = $decoded;
    }
}

if (empty($input)) {
    $input = $_POST;
}

$nombre = trim($input['nombre'] ?? '');
$apellidoPaterno = trim($input['apellido_paterno'] ?? '');
$apellidoMaterno = trim($input['apellido_materno'] ?? '');
$usuario = trim($input['usuario'] ?? '');
$correo = trim($input['correo'] ?? '');
$password = trim($input['password'] ?? '');

if ($nombre === '' || $apellidoPaterno === '' || $usuario === '' || $correo === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Completa todos los campos obligatorios']);
    exit;
}

$check = $conexion->prepare('SELECT id_usuario FROM usuarios WHERE usuario = ? OR correo = ? LIMIT 1');
$check->bind_param('ss', $usuario, $correo);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El usuario o correo ya están registrados']);
    exit;
}

$rolesCheck = $conexion->query('SELECT id_rol FROM roles WHERE id_rol = 1 LIMIT 1');
if ($rolesCheck && $rolesCheck->num_rows === 0) {
    $conexion->query("INSERT INTO roles (id_rol, nombre_rol, descripcion, activo) VALUES (1, 'Administrador', 'Rol por defecto', 1)");
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$rolId = 1;

$stmt = $conexion->prepare('INSERT INTO usuarios (id_rol, nombre, apellido_paterno, apellido_materno, usuario, contrasena_hash, correo, activo) VALUES (?, ?, ?, ?, ?, ?, ?, 1)');
$stmt->bind_param('issssss', $rolId, $nombre, $apellidoPaterno, $apellidoMaterno, $usuario, $hash, $correo);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuario registrado']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . $stmt->error]);
}
