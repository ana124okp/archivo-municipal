<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <a href="index.php" class="btn btn-outline-light mb-4">← Volver al Inicio</a>
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h2 class="card-title text-dark">Seguridad</h2>
                <p class="text-muted">Aquí se gestionarán permisos, accesos y políticas de seguridad.</p>
                <ul class="list-group">
                    <li class="list-group-item">Control de accesos</li>
                    <li class="list-group-item">Bitácora de sesiones</li>
                    <li class="list-group-item">Restablecimiento de contraseñas</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
