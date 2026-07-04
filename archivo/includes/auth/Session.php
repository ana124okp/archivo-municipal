<?php
/**
 * Gestión de Sesiones
 */

session_start();

/**
 * Iniciar sesión de usuario
 */
function loginUser($user_id, $username, $email, $role) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['user_role'] = $role;
    $_SESSION['login_time'] = time();
    $_SESSION['last_activity'] = time();
    
    return true;
}

/**
 * Cerrar sesión
 */
function logoutUser() {
    $_SESSION = [];
    session_destroy();
    return true;
}

/**
 * Verificar si el usuario está autenticado
 */
function isLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    // Verificar timeout de sesión
    if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
        logoutUser();
        return false;
    }
    
    $_SESSION['last_activity'] = time();
    return true;
}

/**
 * Requerir autenticación
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'index.php');
        exit();
    }
}

/**
 * Solo admin
 */
function requireAdmin() {
    requireLogin();
    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ' . BASE_URL . 'error.php?code=403');
        exit();
    }
}

/**
 * Obtener datos del usuario actual
 */
function getCurrentUser() {
    global $conn;
    
    if (!isLoggedIn()) {
        return null;
    }
    
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM usuarios WHERE id = '{$user_id}'";
    $result = mysqli_query($conn, $sql);
    
    return mysqli_fetch_assoc($result);
}
?>
