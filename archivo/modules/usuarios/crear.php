<?php
/**
 * CREAR USUARIO - Admin
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
    <title>Crear Usuario</title>
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
            <li><a href="index.php">👥 Usuarios</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Crear Usuario</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">➕ Nuevo Usuario</h1>
            </div>
            
            <div class="content-container">
                <div class="card" style="max-width: 800px;">
                    <div class="card-body">
                        <form id="usuarioForm" method="POST" action="../../api/usuarios/crear.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nombre Completo</label>
                                        <input type="text" name="nombre" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Confirmar Contraseña</label>
                                        <input type="password" name="password_confirm" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Rol</label>
                                        <select name="rol" class="form-control" required>
                                            <option value="">Selecciona un rol</option>
                                            <option value="admin">Administrador</option>
                                            <option value="documentalista">Documentalista</option>
                                            <option value="consultor">Consultor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Estado</label>
                                        <select name="estado" class="form-control" required>
                                            <option value="activo">Activo</option>
                                            <option value="inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" name="telefono" class="form-control">
                            </div>
                            
                            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear Usuario</button>
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
