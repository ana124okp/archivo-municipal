<?php
/**
 * MÓDULO TRANSFERENCIAS
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requirePermission('ver_expediente');

$sql = "SELECT t.*, 
        e.folio as expediente_folio,
        c1.nombre as caja_origen,
        c2.nombre as caja_destino,
        u.nombre as usuario_nombre
        FROM transferencias t 
        LEFT JOIN expedientes e ON t.expediente_id = e.id 
        LEFT JOIN cajas c1 ON t.caja_origen_id = c1.id 
        LEFT JOIN cajas c2 ON t.caja_destino_id = c2.id 
        LEFT JOIN usuarios u ON t.usuario_id = u.id 
        ORDER BY t.fecha_transferencia DESC LIMIT 100";

$result = mysqli_query($conn, $sql);
$transferencias = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body style="display: flex; min-height: 100vh;">
    <nav class="sidebar" style="width: 250px; flex-shrink: 0;">
        <div class="sidebar-header">
            <h4 style="color: white; margin: 0;">📋 ARCHIVOS</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../../app.php">🏠 Dashboard</a></li>
            <li><a href="index.php" class="active">↔️ Transferencias</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Transferencias de Expedientes</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 class="page-title">↔️ Transferencias</h1>
                        <p class="page-subtitle">Historial de movimientos entre cajas</p>
                    </div>
                    <?php if (checkPermission('crear_transferencia')): ?>
                    <a href="crear.php" class="btn btn-primary">➕ Nueva Transferencia</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="content-container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Registro de Transferencias</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($transferencias) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Expediente</th>
                                    <th>Caja Origen</th>
                                    <th>Caja Destino</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transferencias as $transf): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($transf['expediente_folio'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($transf['caja_origen'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($transf['caja_destino'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($transf['usuario_nombre'] ?? '-'); ?></td>
                                    <td><?php echo formatDate($transf['fecha_transferencia']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($transf['motivo'] ?? '', 0, 30)); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-info">No hay transferencias registradas</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
