<?php
/**
 * CREAR PRÉSTAMO
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requirePermission('crear_prestamo');

$expediente_id = sanitize($_GET['expediente_id'] ?? '');

// Obtener expedientes
$sql_expedientes = "SELECT * FROM expedientes WHERE estado != 'eliminado' ORDER BY folio";
$result_expedientes = mysqli_query($conn, $sql_expedientes);
$expedientes = mysqli_fetch_all($result_expedientes, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Préstamo</title>
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
            <span class="navbar-brand">Crear Préstamo</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">➕ Nuevo Préstamo</h1>
            </div>
            
            <div class="content-container">
                <div class="card" style="max-width: 800px;">
                    <div class="card-body">
                        <form id="prestamoForm" method="POST" action="../../api/prestamos/crear.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Expediente</label>
                                        <select name="expediente_id" class="form-control" required>
                                            <option value="">Selecciona un expediente</option>
                                            <?php foreach ($expedientes as $exp): ?>
                                            <option value="<?php echo $exp['id']; ?>" <?php echo $expediente_id == $exp['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($exp['folio']); ?> - <?php echo htmlspecialchars(substr($exp['asunto'], 0, 40)); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Fecha de Vencimiento</label>
                                        <input type="date" name="fecha_vencimiento" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="3" placeholder="Describe el motivo o detalles del préstamo"></textarea>
                            </div>
                            
                            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear Préstamo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
