<?php
/**
 * API - Crear Expediente
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    sendJSON(response(false, 'Método no permitido'));
}

requireLogin();
requirePermission('crear_expediente');

// Validar datos
$folio = sanitize($_POST['folio'] ?? '');
$asunto = sanitize($_POST['asunto'] ?? '');
$serie_id = sanitize($_POST['serie_id'] ?? '');
$caja_id = sanitize($_POST['caja_id'] ?? '');
$fecha_inicio = sanitize($_POST['fecha_inicio'] ?? '');
$observaciones = sanitize($_POST['observaciones'] ?? '');

if (empty($folio) || empty($asunto) || empty($serie_id) || empty($caja_id)) {
    header('Location: ../../modules/expedientes/crear.php?error=campos_requeridos');
    exit();
}

// Verificar que no exista el folio
$sql_check = "SELECT id FROM expedientes WHERE folio = '{$folio}'";
$result = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result) > 0) {
    header('Location: ../../modules/expedientes/crear.php?error=folio_existe');
    exit();
}

// Crear expediente
$sql = "INSERT INTO expedientes (folio, asunto, serie_id, caja_id, fecha_inicio, estado, observaciones)
        VALUES ('{$folio}', '{$asunto}', '{$serie_id}', '{$caja_id}', '{$fecha_inicio}', 'activo', '{$observaciones}')";

if (mysqli_query($conn, $sql)) {
    $expediente_id = mysqli_insert_id($conn);
    
    // Registrar en bitácora
    logAction(getCurrentUserId(), 'CREAR', 'expedientes', "Expediente {$folio} creado");
    
    header('Location: ../../modules/expedientes/index.php?success=creado');
    exit();
} else {
    header('Location: ../../modules/expedientes/crear.php?error=sql');
    exit();
}
?>
