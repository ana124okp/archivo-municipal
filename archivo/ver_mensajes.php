<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <a href="index.php" class="btn btn-outline-light mb-4">← Volver al Inicio</a>
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h2 class="card-title text-dark">Mensajes</h2>
                <p class="text-muted">Este módulo mostrará las comunicaciones internas del sistema.</p>
                <div class="border rounded p-3 mb-2">Mensaje 1: Revisión de documentos</div>
                <div class="border rounded p-3 mb-2">Mensaje 2: Actualización de usuarios</div>
                <div class="border rounded p-3">Mensaje 3: Nueva solicitud recibida</div>
            </div>
        </div>
    </div>
</body>
</html>
