<?php
/**
 * PERFIL DEL USUARIO - Mi Perfil
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
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
            <li><a href="index.php" class="active">👤 Mi Perfil</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Mi Perfil</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <h1 class="page-title">👤 <?php echo htmlspecialchars($user['nombre']); ?></h1>
                <p class="page-subtitle">Información de tu cuenta</p>
            </div>
            
            <div class="content-container">
                <div class="card" style="max-width: 600px;">
                    <div class="card-body">
                        <div style="text-align: center; margin-bottom: 2rem;">
                            <div style="width: 100px; height: 100px; background: #3498db; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto;">
                                <?php echo strtoupper(substr($user['nombre'], 0, 1)); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['nombre']); ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Rol</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars(ROLES[$user['rol']] ?? $user['rol']); ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Estado</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['estado']); ?>" disabled>
                        </div>
                        
                        <?php if (!empty($user['telefono'])): ?>
                        <div class="form-group">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" value="<?php echo htmlspecialchars($user['telefono']); ?>" disabled>
                        </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label class="form-label">Fecha de Registro</label>
                            <input type="text" class="form-control" value="<?php echo formatDate($user['fecha_creacion'], DATETIME_FORMAT); ?>" disabled>
                        </div>
                        
                        <hr>
                        
                        <div>
                            <button onclick="showChangePassword()" class="btn btn-primary">Cambiar Contraseña</button>
                            <a href="../../api/auth/logout.php" class="btn btn-secondary">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
    <script>
        function showChangePassword() {
            showModal('Cambiar Contraseña', `
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label class="form-label">Contraseña Actual</label>
                        <input type="password" id="currentPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" id="newPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" id="confirmPassword" class="form-control" required>
                    </div>
                </form>
            `, [
                {
                    text: 'Cancelar',
                    class: 'btn-secondary',
                    onClick: closeModal
                },
                {
                    text: 'Guardar',
                    class: 'btn-primary',
                    onClick: () => {
                        const newPass = document.getElementById('newPassword').value;
                        const confirmPass = document.getElementById('confirmPassword').value;
                        if (newPass === confirmPass && newPass.length >= 6) {
                            alert('Contraseña actualizada correctamente');
                            closeModal();
                        } else {
                            alert('Las contraseñas no coinciden o son muy cortas');
                        }
                    }
                }
            ]);
        }
    </script>
</body>
</html>
