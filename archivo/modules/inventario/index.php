<?php
/**
 * MÓDULO INVENTARIO - Control de Cajas
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();

$sql = "SELECT c.*, 
        COALESCE(COUNT(e.id), 0) as expedientes,
        COALESCE(c.capacidad, 100) as capacidad,
        ROUND((COALESCE(COUNT(e.id), 0) / COALESCE(c.capacidad, 100)) * 100, 2) as ocupacion_pct
        FROM cajas c 
        LEFT JOIN expedientes e ON c.id = e.caja_id AND e.estado != 'eliminado'
        GROUP BY c.id
        ORDER BY c.nombre";

$result = mysqli_query($conn, $sql);
$cajas = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Inventario</title>
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
            <li><a href="index.php" class="active">📦 Inventario</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Control de Inventario</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">📦 Control de Inventario</h1>
                <p class="page-subtitle">Monitoreo en tiempo real de cajas y ocupación</p>
            </div>
            
            <div class="content-container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Estado de Cajas</h5>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                            <?php foreach ($cajas as $caja): ?>
                            <div class="card" style="border-left: 4px solid <?php 
                                echo $caja['ocupacion_pct'] >= 90 ? '#e74c3c' : 
                                     ($caja['ocupacion_pct'] >= 70 ? '#f39c12' : '#27ae60');
                            ?>;">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($caja['nombre']); ?></h5>
                                    <p style="color: #666; font-size: 0.9rem; margin: 0;">
                                        Ubicación: <?php echo htmlspecialchars($caja['ubicacion'] ?? '-'); ?>
                                    </p>
                                    
                                    <div style="margin-top: 1rem;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                            <span>Ocupación:</span>
                                            <strong><?php echo $caja['expedientes'] . '/' . $caja['capacidad']; ?></strong>
                                        </div>
                                        
                                        <div style="background: #e0e0e0; height: 10px; border-radius: 5px; overflow: hidden;">
                                            <div style="background: <?php 
                                                echo $caja['ocupacion_pct'] >= 90 ? '#e74c3c' : 
                                                     ($caja['ocupacion_pct'] >= 70 ? '#f39c12' : '#27ae60');
                                            ?>; height: 100%; width: <?php echo $caja['ocupacion_pct']; ?>%;"></div>
                                        </div>
                                        
                                        <div style="text-align: right; margin-top: 0.5rem; font-size: 0.9rem; color: #666;">
                                            <?php echo $caja['ocupacion_pct']; ?>%
                                        </div>
                                    </div>
                                    
                                    <?php if ($caja['ocupacion_pct'] >= 90): ?>
                                    <div style="margin-top: 1rem; padding: 0.5rem; background: #f8d7da; border-radius: 4px; color: #721c24; font-size: 0.85rem;">
                                        ⚠️ Caja al 90% de capacidad
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
