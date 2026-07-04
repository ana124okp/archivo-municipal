<?php
/**
 * MÓDULO USUARIOS - Solo Administrador
 */

include '../../includes/config/database.php';
include '../../includes/config/constants.php';
include '../../includes/helpers/Functions.php';
include '../../includes/auth/Session.php';

requireLogin();
requireAdmin();

$sql = "SELECT * FROM usuarios ORDER BY fecha_creacion DESC";
$result = mysqli_query($conn, $sql);
$usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
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
            <li><a href="index.php" class="active">👥 Usuarios</a></li>
            <li><a href="../catalogos/index.php">📚 Catálogos</a></li>
            <li><a href="../auditoria/index.php">📋 Auditoría</a></li>
            <li><a href="../../api/auth/logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div style="flex: 1; display: flex; flex-direction: column;">
        <nav class="navbar">
            <span class="navbar-brand">Gestión de Usuarios</span>
        </nav>
        
        <div style="overflow-y: auto; flex: 1;">
            <div class="page-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 class="page-title">👥 Usuarios</h1>
                        <p class="page-subtitle">Gestión de roles y permisos</p>
                    </div>
                    <a href="crear.php" class="btn btn-primary">➕ Nuevo Usuario</a>
                </div>
            </div>
            
            <div class="content-container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Lista de Usuarios</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($usuarios) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usr): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usr['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usr['email']); ?></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?php echo htmlspecialchars(ROLES[$usr['rol']] ?? $usr['rol']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $usr['estado'] === 'activo' ? 'success' : 'warning'; ?>">
                                            <?php echo htmlspecialchars($usr['estado']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo formatDate($usr['fecha_creacion']); ?></td>
                                    <td class="table-actions">
                                        <a href="editar.php?id=<?php echo $usr['id']; ?>" class="btn-edit">Editar</a>
                                        <a href="javascript:void(0);" class="btn-delete" onclick="confirmDelete(<?php echo $usr['id']; ?>)">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-info">No hay usuarios registrados</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/js/script.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                window.location.href = '../../api/usuarios/eliminar.php?id=' + id;
            }
        }
    </script>
</body>
</html>
