<?php
/**
 * CREAR EXPEDIENTE
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requirePermission('crear_expediente');

// Obtener series y cajas para el formulario
$sql_series = "SELECT * FROM series";
$result_series = mysqli_query($conn, $sql_series);
$series = mysqli_fetch_all($result_series, MYSQLI_ASSOC);

$sql_cajas = "SELECT * FROM cajas WHERE estado = 'disponible'";
$result_cajas = mysqli_query($conn, $sql_cajas);
$cajas = mysqli_fetch_all($result_cajas, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Expediente</title>
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
            <li><a href="index.php" class="active">📂 Expedientes</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Crear Expediente</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">➕ Nuevo Expediente</h1>
                <p class="page-subtitle">Completa todos los campos para registrar un nuevo expediente</p>
            </div>
            
            <div class="content-container">
                <div class="card" style="max-width: 800px;">
                    <div class="card-body">
                        <form id="expedienteForm" method="POST" action="../../api/expedientes/crear.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Folio</label>
                                        <input type="text" name="folio" class="form-control" placeholder="Ej: EXP-2024-001" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Serie</label>
                                        <select name="serie_id" class="form-control" required>
                                            <option value="">Selecciona una serie</option>
                                            <?php foreach ($series as $serie): ?>
                                            <option value="<?php echo $serie['id']; ?>">
                                                <?php echo htmlspecialchars($serie['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Asunto</label>
                                <textarea name="asunto" class="form-control" rows="3" placeholder="Describe el asunto del expediente" required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Caja</label>
                                        <select name="caja_id" class="form-control" required>
                                            <option value="">Selecciona una caja</option>
                                            <?php foreach ($cajas as $caja): ?>
                                            <option value="<?php echo $caja['id']; ?>">
                                                <?php echo htmlspecialchars($caja['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Fecha de Inicio</label>
                                        <input type="date" name="fecha_inicio" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="2" placeholder="Observaciones adicionales"></textarea>
                            </div>
                            
                            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear Expediente</button>
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
