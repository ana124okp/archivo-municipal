<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <a href="index.php" class="btn btn-outline-light mb-4">← Volver al Inicio</a>
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h2 class="card-title text-dark">Lista de Usuarios del Sistema</h2>
                <p class="text-muted">Datos cargados desde una API backend en PHP.</p>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Usuario</th>
                            </tr>
                        </thead>
                        <tbody id="usuarios-body">
                            <tr>
                                <td colspan="2" class="text-center text-muted">Cargando usuarios...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tbody = document.getElementById('usuarios-body');

            axios.get('api/usuarios.php')
                .then(function (response) {
                    if (!response.data.success) {
                        tbody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">No se pudieron cargar los usuarios</td></tr>';
                        return;
                    }

                    if (!response.data.data.length) {
                        tbody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">No hay usuarios registrados</td></tr>';
                        return;
                    }

                    tbody.innerHTML = response.data.data.map(function (usuario) {
                        return '<tr><td>' + usuario.id_usuario + '</td><td>' + usuario.usuario + '</td></tr>';
                    }).join('');
                })
                .catch(function () {
                    tbody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Error al conectar con el backend</td></tr>';
                });
        });
    </script>
</body>
</html>
