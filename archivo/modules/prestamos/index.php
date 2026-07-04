<?php
/**
 * MÓDULO PRÉSTAMOS
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requirePermission('ver_prestamo');

$sql = "SELECT p.*, e.folio as expediente_folio, u.nombre as usuario_nombre 
        FROM prestamos p 
        LEFT JOIN expedientes e ON p.expediente_id = e.id 
        LEFT JOIN usuarios u ON p.usuario_solicitante = u.id 
        ORDER BY p.fecha_solicitud DESC LIMIT 100";

$result = mysqli_query($conn, $sql);
$prestamos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
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
            <li><a href="index.php" class="active">🤝 Préstamos</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Gestión de Préstamos</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 class="page-title">🤝 Préstamos</h1>
                        <p class="page-subtitle">Control de préstamos y devoluciones</p>
                    </div>
                    <?php if (checkPermission('crear_prestamo')): ?>
                    <a href="crear.php" class="btn btn-primary">➕ Nuevo Préstamo</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="content-container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Lista de Préstamos</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($prestamos) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Expediente</th>
                                    <th>Solicitante</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($prestamos as $prest): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prest['expediente_folio'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($prest['usuario_nombre'] ?? '-'); ?></td>
                                    <td><?php echo formatDate($prest['fecha_solicitud']); ?></td>
                                    <td><?php echo formatDate($prest['fecha_vencimiento']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php 
                                            echo $prest['estado'] === 'activo' ? 'success' : 
                                                 ($prest['estado'] === 'vencido' ? 'danger' : 'warning');
                                        ?>">
                                            <?php echo htmlspecialchars($prest['estado']); ?>
                                        </span>
                                    </td>
                                    <td class="table-actions">
                                        <a href="ver.php?id=<?php echo $prest['id']; ?>" class="btn-view">Ver</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-info">No hay préstamos registrados</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
