<?php
/**
 * MÓDULO EXPEDIENTES - Lista y Gestión
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requirePermission('ver_expediente');

$user_role = getCurrentUserRole();

// Obtener expedientes
$sql = "SELECT e.*, c.nombre as caja_nombre, s.nombre as serie_nombre 
        FROM expedientes e 
        LEFT JOIN cajas c ON e.caja_id = c.id 
        LEFT JOIN series s ON e.serie_id = s.id 
        ORDER BY e.fecha_creacion DESC LIMIT 100";

$result = mysqli_query($conn, $sql);
$expedientes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $expedientes[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Expedientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body style="display: flex; min-height: 100vh;">
    <!-- SIDEBAR -->
    <nav class="sidebar" style="width: 250px; flex-shrink: 0;">
        <div class="sidebar-header">
            <h4 style="color: white; margin: 0;">📋 ARCHIVOS</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../../app.php">🏠 Dashboard</a></li>
            <li><a href="index.php" class="active">📂 Expedientes</a></li>
            <li><a href="../busqueda/index.php">🔍 Búsqueda</a></li>
            <li><a href="../prestamos/index.php">🤝 Préstamos</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <!-- MAIN CONTENT -->
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Gestión de Expedientes</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 class="page-title">📂 Expedientes</h1>
                        <p class="page-subtitle">Gestiona todos los expedientes del sistema</p>
                    </div>
                    <?php if (checkPermission('crear_expediente')): ?>
                    <a href="crear.php" class="btn btn-primary">➕ Nuevo Expediente</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="content-container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Lista de Expedientes</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($expedientes) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Asunto</th>
                                    <th>Serie</th>
                                    <th>Caja</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($expedientes as $exp): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($exp['folio']); ?></strong></td>
                                    <td><?php echo htmlspecialchars(substr($exp['asunto'], 0, 50)); ?></td>
                                    <td><?php echo htmlspecialchars($exp['serie_nombre'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($exp['caja_nombre'] ?? '-'); ?></td>
                                    <td>
                                        <span class="badge badge-<?php 
                                            echo $exp['estado'] === 'activo' ? 'success' : 
                                                 ($exp['estado'] === 'inactivo' ? 'warning' : 'danger');
                                        ?>">
                                            <?php echo htmlspecialchars($exp['estado']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo formatDate($exp['fecha_creacion']); ?></td>
                                    <td class="table-actions">
                                        <a href="ver.php?id=<?php echo $exp['id']; ?>" class="btn-view">Ver</a>
                                        <?php if (checkPermission('editar_expediente')): ?>
                                        <a href="editar.php?id=<?php echo $exp['id']; ?>" class="btn-edit">Editar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-info">No hay expedientes registrados</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
