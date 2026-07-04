<?php
/**
 * MÓDULO BÚSQUEDA - Búsqueda Cruzada
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();

$resultados = [];
$busqueda_realizada = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $busqueda_realizada = true;
    
    $palabra_clave = sanitize($_POST['palabra_clave'] ?? '');
    $serie = sanitize($_POST['serie'] ?? '');
    $estado = sanitize($_POST['estado'] ?? '');
    $fecha_desde = sanitize($_POST['fecha_desde'] ?? '');
    $fecha_hasta = sanitize($_POST['fecha_hasta'] ?? '');
    $caja = sanitize($_POST['caja'] ?? '');
    
    $sql = "SELECT e.*, c.nombre as caja_nombre, s.nombre as serie_nombre 
            FROM expedientes e 
            LEFT JOIN cajas c ON e.caja_id = c.id 
            LEFT JOIN series s ON e.serie_id = s.id 
            WHERE 1=1";
    
    if (!empty($palabra_clave)) {
        $sql .= " AND (e.folio LIKE '%{$palabra_clave}%' 
                   OR e.asunto LIKE '%{$palabra_clave}%' 
                   OR e.observaciones LIKE '%{$palabra_clave}%')";
    }
    
    if (!empty($serie)) {
        $sql .= " AND e.serie_id = '{$serie}'";
    }
    
    if (!empty($estado)) {
        $sql .= " AND e.estado = '{$estado}'";
    }
    
    if (!empty($fecha_desde)) {
        $sql .= " AND e.fecha_inicio >= '{$fecha_desde}'";
    }
    
    if (!empty($fecha_hasta)) {
        $sql .= " AND e.fecha_inicio <= '{$fecha_hasta}'";
    }
    
    if (!empty($caja)) {
        $sql .= " AND e.caja_id = '{$caja}'";
    }
    
    $sql .= " ORDER BY e.fecha_creacion DESC LIMIT 100";
    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $resultados = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

// Obtener series y cajas para filtros
$sql_series = "SELECT * FROM series";
$result_series = mysqli_query($conn, $sql_series);
$series = mysqli_fetch_all($result_series, MYSQLI_ASSOC);

$sql_cajas = "SELECT * FROM cajas";
$result_cajas = mysqli_query($conn, $sql_cajas);
$cajas = mysqli_fetch_all($result_cajas, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Expedientes</title>
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
            <li><a href="../expedientes/index.php">📂 Expedientes</a></li>
            <li><a href="index.php" class="active">🔍 Búsqueda</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Búsqueda de Expedientes</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">🔍 Búsqueda Cruzada</h1>
                <p class="page-subtitle">Busca expedientes usando múltiples filtros</p>
            </div>
            
            <div class="content-container">
                <!-- FORMULARIO DE BÚSQUEDA -->
                <div class="card" style="margin-bottom: 2rem;">
                    <div class="card-header">
                        <h5 class="card-title">Filtros de Búsqueda</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="searchForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Palabra Clave</label>
                                        <input type="text" name="palabra_clave" class="form-control" placeholder="Busca por folio, asunto, etc...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Serie</label>
                                        <select name="serie" class="form-control">
                                            <option value="">Todas las series</option>
                                            <?php foreach ($series as $s): ?>
                                            <option value="<?php echo $s['id']; ?>">
                                                <?php echo htmlspecialchars($s['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Estado</label>
                                        <select name="estado" class="form-control">
                                            <option value="">Todos los estados</option>
                                            <option value="activo">Activo</option>
                                            <option value="inactivo">Inactivo</option>
                                            <option value="prestado">En Préstamo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Caja</label>
                                        <select name="caja" class="form-control">
                                            <option value="">Todas las cajas</option>
                                            <?php foreach ($cajas as $c): ?>
                                            <option value="<?php echo $c['id']; ?>">
                                                <?php echo htmlspecialchars($c['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Rango de Fechas</label>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <input type="date" name="fecha_desde" class="form-control">
                                            <input type="date" name="fecha_hasta" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-primary">🔍 Buscar</button>
                                <a href="index.php" class="btn btn-secondary">Limpiar</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- RESULTADOS -->
                <?php if ($busqueda_realizada): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            📊 Resultados (<?php echo count($resultados); ?> encontrados)
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($resultados) > 0): ?>
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
                                <?php foreach ($resultados as $exp): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($exp['folio']); ?></strong></td>
                                    <td><?php echo htmlspecialchars(substr($exp['asunto'], 0, 50)); ?></td>
                                    <td><?php echo htmlspecialchars($exp['serie_nombre'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($exp['caja_nombre'] ?? '-'); ?></td>
                                    <td>
                                        <span class="badge badge-<?php 
                                            echo $exp['estado'] === 'activo' ? 'success' : 'warning';
                                        ?>">
                                            <?php echo htmlspecialchars($exp['estado']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo formatDate($exp['fecha_creacion']); ?></td>
                                    <td class="table-actions">
                                        <a href="../expedientes/ver.php?id=<?php echo $exp['id']; ?>" class="btn-view">Ver</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-info">No se encontraron resultados para los criterios especificados</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
