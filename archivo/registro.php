<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Crear cuenta</h2>
                        <p class="text-muted text-center">Registra un nuevo usuario en el sistema.</p>

                        <form id="registro-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apellido paterno</label>
                                    <input type="text" class="form-control" name="apellido_paterno" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apellido materno</label>
                                    <input type="text" class="form-control" name="apellido_materno">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Usuario</label>
                                    <input type="text" class="form-control" name="usuario" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" name="correo" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">Registrar</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="index.php" class="text-decoration-none">← Volver al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registro-form');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const payload = Object.fromEntries(formData.entries());

                if (payload.password !== payload.confirm_password) {
                    alert('Las contraseñas no coinciden');
                    return;
                }

                const urlEncoded = new URLSearchParams(formData);
                axios.post('api/registrar.php', urlEncoded, {
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                })
                    .then(function (response) {
                        if (response.data.success) {
                            alert('Usuario registrado correctamente');
                            window.location.href = 'index.php';
                        } else {
                            alert(response.data.message || 'No se pudo registrar');
                        }
                    })
                    .catch(function () {
                        alert('No se pudo conectar con el backend');
                    });
            });
        });
    </script>
</body>
</html>
