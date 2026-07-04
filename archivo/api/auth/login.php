<?php
/**
 * AUTENTICACIÓN - Login de Usuarios
 * API Backend
 */

session_start();

include_once '../../includes/config/database.php';

// Obtener POST data
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$role = isset($_POST['role']) ? mysqli_real_escape_string($conn, trim($_POST['role'])) : 'Administrador';

// Validaciones
if (empty($email) || empty($password)) {
    header('Location: ../../index.php?error=campos_requeridos');
    exit();
}

// Query con estructura actual de BD
$sql = "SELECT u.*, r.nombre_rol 
        FROM usuarios u
        LEFT JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.correo = '{$email}' AND r.nombre_rol = '{$role}' LIMIT 1";

$result = mysqli_query($conn, $sql);

if (!$result) {
    header('Location: ../../index.php?error=sql_error');
    exit();
}

if (mysqli_num_rows($result) == 0) {
    header('Location: ../../index.php?error=invalid_credentials');
    exit();
}

$user = mysqli_fetch_assoc($result);

// Verificar contraseña
if (!password_verify($password, $user['contrasena_hash'])) {
    header('Location: ../../index.php?error=invalid_credentials');
    exit();
}

// Verificar si está activo
if ($user['activo'] != 1) {
    header('Location: ../../index.php?error=user_inactive');
    exit();
}

// Iniciar sesión
$_SESSION['user_id'] = $user['id_usuario'];
$_SESSION['username'] = $user['usuario'];
$_SESSION['email'] = $user['correo'];
$_SESSION['nombre'] = trim($user['nombre'] . ' ' . $user['apellido_paterno']);
$_SESSION['role'] = $user['nombre_rol'];
$_SESSION['login_time'] = time();

// Actualizar último acceso
$update_sql = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id_usuario = {$user['id_usuario']}";
mysqli_query($conn, $update_sql);

// Redirigir al dashboard
header('Location: ../../app.php');
exit();

// Redirigir al dashboard
header('Location: ../../app.php');
exit();
?>
