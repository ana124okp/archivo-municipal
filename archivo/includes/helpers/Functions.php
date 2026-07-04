<?php
/**
 * Funciones Helper del Sistema
 */

/**
 * Respuesta JSON estándar
 */
function response($success, $message = '', $data = []) {
    return [
        'success' => $success,
        'message' => $message,
        'data' => $data
    ];
}

/**
 * Enviar respuesta JSON
 */
function sendJSON($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

/**
 * Validar que el usuario tenga permiso
 */
function checkPermission($required_permission) {
    if (!isset($_SESSION['user_role'])) {
        return false;
    }
    
    $role = $_SESSION['user_role'];
    $permissions = PERMISSIONS[$role] ?? [];
    
    return in_array($required_permission, $permissions);
}

/**
 * Redirigir si no tiene permiso
 */
function requirePermission($permission) {
    if (!checkPermission($permission)) {
        header('Location: ' . BASE_URL . 'error.php?code=403');
        exit();
    }
}

/**
 * Obtener el rol del usuario actual
 */
function getCurrentUserRole() {
    return $_SESSION['user_role'] ?? null;
}

/**
 * Obtener el ID del usuario actual
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Formatear fecha
 */
function formatDate($date, $format = DATE_FORMAT) {
    if (empty($date)) return '-';
    return date($format, strtotime($date));
}

/**
 * Formatear moneda
 */
function formatCurrency($amount) {
    return '$' . number_format($amount, 2, '.', ',');
}

/**
 * Obtener nombre del rol
 */
function getRoleName($role) {
    return ROLES[$role] ?? $role;
}

/**
 * Generar ID único
 */
function generateUniqueId($prefix = '') {
    return $prefix . uniqid() . time();
}

/**
 * Validar email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validar contraseña
 */
function isValidPassword($password) {
    return strlen($password) >= 6;
}

/**
 * Encriptar contraseña
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Verificar contraseña
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Registrar en bitácora
 */
function logAction($user_id, $action, $module, $details = '') {
    global $conn;
    
    $timestamp = date(DATETIME_FORMAT);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $sql = "INSERT INTO bitacora (user_id, accion, modulo, detalles, ip_address, user_agent, fecha)
            VALUES ('{$user_id}', '{$action}', '{$module}', '{$details}', '{$ip_address}', '{$user_agent}', '{$timestamp}')";
    
    return executeQuery($sql);
}

/**
 * Obtener ocupación de caja en porcentaje
 */
function getBoxOccupancy($box_id) {
    global $conn;
    
    $sql = "SELECT 
            COUNT(e.id) as total_expedientes,
            COALESCE(c.capacidad, 100) as capacidad
            FROM expedientes e
            RIGHT JOIN cajas c ON e.caja_id = c.id
            WHERE c.id = '{$box_id}' AND e.estado != 'eliminado'
            GROUP BY c.id";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        return round(($row['total_expedientes'] / $row['capacidad']) * 100, 2);
    }
    return 0;
}

/**
 * Paginación
 */
function getPagination($total_items, $page = 1, $items_per_page = ITEMS_PER_PAGE) {
    $total_pages = ceil($total_items / $items_per_page);
    $offset = ($page - 1) * $items_per_page;
    
    return [
        'current_page' => max(1, min($page, $total_pages)),
        'total_pages' => $total_pages,
        'total_items' => $total_items,
        'offset' => $offset,
        'limit' => $items_per_page
    ];
}
?>
