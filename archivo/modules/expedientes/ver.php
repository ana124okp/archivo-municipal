<?php
/**
 * VER EXPEDIENTE - Detalles completos
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();

$expediente_id = sanitize($_GET['id'] ?? '0');

$sql = "SELECT e.*, c.nombre as caja_nombre, s.nombre as serie_nombre, a.nombre as area_nombre 
        FROM expedientes e 
        LEFT JOIN cajas c ON e.caja_id = c.id 
        LEFT JOIN series s ON e.serie_id = s.id 
        LEFT JOIN areas a ON e.area_id = a.id 
        WHERE e.id = '{$expediente_id}'";

$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

$expediente = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Expediente</title>
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
            <li><a href="index.php">📂 Expedientes</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Detalles del Expediente</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 class="page-title">📂 <?php echo htmlspecialchars($expediente['folio']); ?></h1>
                        <p class="page-subtitle"><?php echo htmlspecialchars($expediente['asunto']); ?></p>
                    </div>
                    <div>
                        <a href="index.php" class="btn btn-secondary">← Volver</a>
                        <?php if (checkPermission('editar_expediente')): ?>
                        <a href="editar.php?id=<?php echo $expediente_id; ?>" class="btn btn-primary">Editar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="content-container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Información del Expediente</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Folio:</strong> <?php echo htmlspecialchars($expediente['folio']); ?></p>
                                        <p><strong>Estado:</strong> 
                                            <span class="badge badge-<?php echo $expediente['estado'] === 'activo' ? 'success' : 'warning'; ?>">
                                                <?php echo htmlspecialchars($expediente['estado']); ?>
                                            </span>
                                        </p>
                                        <p><strong>Serie:</strong> <?php echo htmlspecialchars($expediente['serie_nombre'] ?? '-'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Caja:</strong> <?php echo htmlspecialchars($expediente['caja_nombre'] ?? '-'); ?></p>
                                        <p><strong>Área:</strong> <?php echo htmlspecialchars($expediente['area_nombre'] ?? '-'); ?></p>
                                        <p><strong>Fecha Inicio:</strong> <?php echo formatDate($expediente['fecha_inicio']); ?></p>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div>
                                    <strong>Asunto:</strong>
                                    <p><?php echo htmlspecialchars($expediente['asunto']); ?></p>
                                </div>
                                
                                <?php if (!empty($expediente['observaciones'])): ?>
                                <div>
                                    <strong>Observaciones:</strong>
                                    <p><?php echo htmlspecialchars($expediente['observaciones']); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <hr>
                                
                                <small style="color: #666;">
                                    <p>Creado: <?php echo formatDate($expediente['fecha_creacion'], DATETIME_FORMAT); ?></p>
                                </small>
                            </div>
                        </div>
                        
                        <?php if (checkPermission('crear_prestamo')): ?>
                        <div class="card" style="margin-top: 1.5rem;">
                            <div class="card-header">
                                <h5 class="card-title">Acciones</h5>
                            </div>
                            <div class="card-body">
                                <a href="../prestamos/crear.php?expediente_id=<?php echo $expediente_id; ?>" class="btn btn-primary">
                                    🤝 Registrar Préstamo
                                </a>
                                <a href="../transferencias/crear.php?expediente_id=<?php echo $expediente_id; ?>" class="btn btn-primary">
                                    ↔️ Transferir
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Historial</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $sql_movimientos = "SELECT * FROM bitacora WHERE detalles LIKE '%{$expediente['folio']}%' ORDER BY fecha DESC LIMIT 10";
                                $result_movimientos = mysqli_query($conn, $sql_movimientos);
                                
                                if ($result_movimientos && mysqli_num_rows($result_movimientos) > 0) {
                                    while ($mov = mysqli_fetch_assoc($result_movimientos)) {
                                        echo '<div style="padding: 0.5rem 0; border-bottom: 1px solid #ddd; font-size: 0.9rem;">';
                                        echo '<strong>' . htmlspecialchars($mov['accion']) . '</strong><br>';
                                        echo '<small style="color: #666;">' . formatDate($mov['fecha'], DATETIME_FORMAT) . '</small>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p style="color: #999;">No hay movimientos registrados</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
