<?php
/**
 * API - Crear Usuario
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requireAdmin();

// Validar datos
$nombre = sanitize($_POST['nombre'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$rol = sanitize($_POST['rol'] ?? '');
$estado = sanitize($_POST['estado'] ?? 'activo');
$telefono = sanitize($_POST['telefono'] ?? '');

// Validaciones
if (empty($nombre) || empty($email) || empty($password) || empty($rol)) {
    header('Location: ../../modules/usuarios/crear.php?error=campos_requeridos');
    exit();
}

if (!isValidEmail($email)) {
    header('Location: ../../modules/usuarios/crear.php?error=email_invalido');
    exit();
}

if (!isValidPassword($password)) {
    header('Location: ../../modules/usuarios/crear.php?error=password_corta');
    exit();
}

if ($password !== $password_confirm) {
    header('Location: ../../modules/usuarios/crear.php?error=password_no_coincide');
    exit();
}

// Verificar que no exista el email
$sql_check = "SELECT id FROM usuarios WHERE email = '{$email}'";
$result = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result) > 0) {
    header('Location: ../../modules/usuarios/crear.php?error=email_existe');
    exit();
}

// Encriptar contraseña
$password_hash = hashPassword($password);

// Crear usuario
$sql = "INSERT INTO usuarios (nombre, email, password, rol, estado, telefono)
        VALUES ('{$nombre}', '{$email}', '{$password_hash}', '{$rol}', '{$estado}', '{$telefono}')";

if (mysqli_query($conn, $sql)) {
    $user_id = mysqli_insert_id($conn);
    
    // Registrar en bitácora
    logAction(getCurrentUserId(), 'CREAR', 'usuarios', "Usuario {$nombre} ({$email}) creado con rol {$rol}");
    
    header('Location: ../../modules/usuarios/index.php?success=usuario_creado');
    exit();
} else {
    header('Location: ../../modules/usuarios/crear.php?error=sql_error');
    exit();
}
?>
