<?php
/**
 * Constantes del Sistema
 */

// URLs Base
define('BASE_URL', 'http://localhost/xampp/archivo/');
define('API_URL', BASE_URL . 'api/');

// Rutas de carpetas
define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('MODULES_PATH', ROOT_PATH . '/modules');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Roles disponibles
define('ROLES', [
    'admin' => 'Administrador',
    'documentalista' => 'Documentalista',
    'consultor' => 'Consultor'
]);

// Permisos por rol
define('PERMISSIONS', [
    'admin' => [
        'crear_usuario', 'editar_usuario', 'eliminar_usuario',
        'crear_expediente', 'editar_expediente', 'eliminar_expediente',
        'crear_prestamo', 'editar_prestamo', 'eliminar_prestamo',
        'crear_transferencia', 'editar_transferencia',
        'gestionar_catalogos', 'ver_auditoria', 'ver_dashboard'
    ],
    'documentalista' => [
        'crear_expediente', 'editar_expediente',
        'crear_prestamo', 'ver_prestamo',
        'crear_transferencia',
        'ver_dashboard'
    ],
    'consultor' => [
        'ver_expediente',
        'ver_prestamo',
        'ver_dashboard'
    ]
]);

// Estados de expedientes
define('ESTADOS_EXPEDIENTE', [
    'activo' => 'Activo',
    'inactivo' => 'Inactivo',
    'prestado' => 'En Préstamo',
    'transferencia' => 'En Transferencia',
    'eliminado' => 'Eliminado'
]);

// Estados de préstamos
define('ESTADOS_PRESTAMO', [
    'solicitado' => 'Solicitado',
    'activo' => 'Activo',
    'vencido' => 'Vencido',
    'devuelto' => 'Devuelto',
    'cancelado' => 'Cancelado'
]);

// Tiempo de sesión (en segundos)
define('SESSION_TIMEOUT', 3600 * 8); // 8 horas

// Paginación
define('ITEMS_PER_PAGE', 20);

// Formatos
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');
?>
