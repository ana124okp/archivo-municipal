<?php
/**
 * MÓDULO CATÁLOGOS - Admin
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requireAdmin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Catálogos</title>
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
            <li><a href="index.php" class="active">📚 Catálogos</a></li>
            <li><a href="../auditoria/index.php">📋 Auditoría</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Gestión de Catálogos</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">📚 Catálogos</h1>
                <p class="page-subtitle">Administra Fondos, Series, Estantes, Cajas, etc.</p>
            </div>
            
            <div class="content-container">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">📁 Fondos</h5>
                        </div>
                        <div class="card-body">
                            <p>Gestiona los fondos documentales del sistema</p>
                            <a href="fondos.php" class="btn btn-primary btn-sm">Administrar</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">📋 Series</h5>
                        </div>
                        <div class="card-body">
                            <p>Administra las series documentales</p>
                            <a href="series.php" class="btn btn-primary btn-sm">Administrar</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">🏢 Áreas</h5>
                        </div>
                        <div class="card-body">
                            <p>Gestiona las áreas del municipio</p>
                            <a href="areas.php" class="btn btn-primary btn-sm">Administrar</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">🏗️ Estantes</h5>
                        </div>
                        <div class="card-body">
                            <p>Administra los estantes de almacenamiento</p>
                            <a href="estantes.php" class="btn btn-primary btn-sm">Administrar</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">📦 Cajas</h5>
                        </div>
                        <div class="card-body">
                            <p>Gestiona las cajas de almacenamiento</p>
                            <a href="cajas.php" class="btn btn-primary btn-sm">Administrar</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">🔤 Niveles</h5>
                        </div>
                        <div class="card-body">
                            <p>Administra los niveles de clasificación</p>
                            <a href="niveles.php" class="btn btn-primary btn-sm">Administrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
</body>
</html>
