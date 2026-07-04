<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <a href="index.php" class="btn btn-outline-light mb-4">← Volver al Inicio</a>
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h2 class="card-title text-dark">Reportes</h2>
                <p class="text-muted">Aquí se mostrarán indicadores y reportes del sistema.</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios activos</h5>
                                <p class="card-text">12</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Documentos</h5>
                                <p class="card-text">48</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Solicitudes</h5>
                                <p class="card-text">7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
