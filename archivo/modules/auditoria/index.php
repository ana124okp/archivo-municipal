<?php
/**
 * MÓDULO AUDITORÍA - Bitácora del Sistema
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requireAdmin();

// Obtener auditoría
$sql = "SELECT b.*, u.nombre as usuario_nombre 
        FROM bitacora b 
        LEFT JOIN usuarios u ON b.user_id = u.id 
        ORDER BY b.fecha DESC LIMIT 500";

$result = mysqli_query($conn, $sql);
$auditorias = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría del Sistema</title>
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
            <li><a href="../usuarios/index.php">👥 Usuarios</a></li>
            <li><a href="../catalogos/index.php">📚 Catálogos</a></li>
            <li><a href="index.php" class="active">📋 Auditoría</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Auditoría del Sistema</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">📋 Bitácora de Auditoría</h1>
                <p class="page-subtitle">Registro completo de todas las operaciones del sistema</p>
            </div>
            
            <div class="content-container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Movimientos del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($auditorias) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Módulo</th>
                                    <th>Detalles</th>
                                    <th>IP Address</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($auditorias as $audit): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($audit['usuario_nombre'] ?? '-'); ?></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?php echo htmlspecialchars($audit['accion']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?php echo htmlspecialchars($audit['modulo']); ?>
                                        </span>
                                    </td>
                                    <td style="font-size: 0.85rem;">
                                        <?php echo htmlspecialchars(substr($audit['detalles'] ?? '', 0, 50)); ?>
                                    </td>
                                    <td style="font-family: monospace; font-size: 0.85rem;">
                                        <?php echo htmlspecialchars($audit['ip_address'] ?? '-'); ?>
                                    </td>
                                    <td><?php echo formatDate($audit['fecha'], DATETIME_FORMAT); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-info">No hay registros de auditoría</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
