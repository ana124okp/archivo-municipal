<?php
/**
 * API - Crear Préstamo
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requirePermission('crear_prestamo');

$expediente_id = sanitize($_POST['expediente_id'] ?? '');
$fecha_vencimiento = sanitize($_POST['fecha_vencimiento'] ?? '');
$observaciones = sanitize($_POST['observaciones'] ?? '');

if (empty($expediente_id) || empty($fecha_vencimiento)) {
    header('Location: ../../modules/prestamos/crear.php?error=campos_requeridos');
    exit();
}

$fecha_solicitud = date('Y-m-d');

$sql = "INSERT INTO prestamos (expediente_id, usuario_solicitante, fecha_solicitud, fecha_vencimiento, estado, observaciones)
        VALUES ('{$expediente_id}', '" . getCurrentUserId() . "', '{$fecha_solicitud}', '{$fecha_vencimiento}', 'solicitado', '{$observaciones}')";

if (mysqli_query($conn, $sql)) {
    $prestamo_id = mysqli_insert_id($conn);
    
    // Actualizar estado del expediente
    mysqli_query($conn, "UPDATE expedientes SET estado = 'prestado' WHERE id = '{$expediente_id}'");
    
    // Registrar en bitácora
    logAction(getCurrentUserId(), 'CREAR', 'prestamos', "Préstamo creado para expediente {$expediente_id}");
    
    header('Location: ../../modules/prestamos/index.php?success=creado');
    exit();
} else {
    header('Location: ../../modules/prestamos/crear.php?error=sql_error');
    exit();
}
?>
