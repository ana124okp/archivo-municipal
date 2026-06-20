<?php
// 1. Incluimos el archivo de conexión que creamos en el Paso 1
require_once 'conexion.php';

// 2. Hacemos la consulta SQL a la tabla ROLES
$stmt = $pdo->query('SELECT id_rol, nombre_rol, descripcion FROM ROLES WHERE activo = 1');
$roles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Archivo Municipal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

    <h1>Sistema del Archivo General Municipal</h1>
    <h2>Perfiles de Acceso (Roles) Registrados</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($roles) > 0): ?>
                <?php foreach ($roles as $rol): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rol['id_rol']); ?></td>
                        <td><?php echo htmlspecialchars($rol['nombre_rol']); ?></td>
                        <td><?php echo htmlspecialchars($rol['descripcion']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay roles registrados en este momento.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>