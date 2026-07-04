<?php
/**
 * LOGIN - Autenticación de Usuarios
 * Diseño de dos columnas moderno
 */

// Iniciar sesión
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: app.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Archivos Municipales - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7aa8d1 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }
        
        /* NAVBAR */
        .navbar-custom {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-brand-custom {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-menu {
            margin-left: auto;
            display: flex;
            gap: 2rem;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .navbar-menu a:hover {
            color: #5dade2;
        }
        
        .search-box {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            width: 250px;
        }
        
        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        /* CONTENEDOR PRINCIPAL */
        .login-container {
            display: flex;
            min-height: 100vh;
            padding-top: 70px;
            gap: 0;
        }
        
        .login-left {
            flex: 1;
            padding: 4rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        
        .login-left h1 {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }
        
        .login-left h2 {
            font-size: 1.8rem;
            font-weight: 300;
            margin-bottom: 1.5rem;
            color: #5dade2;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .login-left p {
            font-size: 1rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.6;
        }
        
        .social-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        
        .social-btn {
            padding: 0.8rem 1.8rem;
            border: 2px solid white;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }
        
        .social-btn:hover {
            background: white;
            color: #2a5298;
            transform: translateY(-2px);
        }
        
        /* FORMULARIO */
        .login-right {
            flex: 1;
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.15);
        }
        
        .login-form-box {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        
        .login-form-title {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.8rem;
            color: #2c3e50;
            font-weight: bold;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.6rem;
            color: #34495e;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.9rem 1.1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #5dade2;
            background: white;
            box-shadow: 0 0 0 4px rgba(93, 173, 226, 0.1);
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            margin-bottom: 1.5rem;
        }
        
        .form-check input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #5dade2;
        }
        
        .form-check label {
            margin: 0;
            cursor: pointer;
            color: #34495e;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        
        .forgot-password {
            color: #5dade2;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            color: #2a5298;
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #5dade2 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(42, 82, 152, 0.4);
        }
        
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #34495e;
            font-size: 0.9rem;
        }
        
        .signup-link a {
            color: #5dade2;
            text-decoration: none;
            font-weight: bold;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #c33;
        }
        
        /* RESPONSIVE */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-left {
                padding: 2.5rem;
            }
            
            .login-left h1 {
                font-size: 2.5rem;
            }
            
            .login-left h2 {
                font-size: 1.3rem;
            }
            
            .login-right {
                padding: 2.5rem;
            }
            
            .login-form-box {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 0.75rem 1.5rem;
            }
            
            .navbar-brand-custom {
                font-size: 1.3rem;
            }
            
            .navbar-menu {
                display: none;
            }
            
            .login-container {
                padding-top: 60px;
            }
            
            .login-left {
                padding: 2rem;
                text-align: center;
            }
            
            .login-left h1 {
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            
            .login-left h2 {
                font-size: 1.1rem;
            }
            
            .login-right {
                padding: 2rem;
            }
            
            .login-form-box {
                padding: 2rem;
            }
            
            .social-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar-custom">
        <a href="#" class="navbar-brand-custom">
            <i class="fas fa-building"></i> Ayuntamiento
        </a>
        <div class="navbar-menu">
            <a href="#">Home</a>
            <a href="#">About</a>
            <input type="text" class="search-box" placeholder="Buscar...">
            <button class="btn" style="background: rgba(93, 173, 226, 0.8); color: white; border: none; border-radius: 50%; width: 40px; height: 40px;">
                <i class="fas fa-user"></i>
            </button>
        </div>
    </nav>
    
    <div class="login-container">
        <!-- COLUMNA IZQUIERDA -->
        <div class="login-left">
            <h1>¡BIENVENIDOS!</h1>
            <h2>ARCHIVOS GENERALES.</h2>
            <p>AYUNTAMIENTO DE TECAMACHALCO.</p>
            
            <div class="social-buttons">
                <a href="#" class="social-btn">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a>
                <a href="#" class="social-btn">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
                <a href="#" class="social-btn">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
        
        <!-- COLUMNA DERECHA -->
        <div class="login-right">
            <div class="login-form-box">
                <div class="login-form-title">Iniciar sesión</div>
                
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="error-message">';
                    if ($_GET['error'] == 'invalid_credentials') {
                        echo '❌ Email o contraseña incorrectos';
                    } elseif ($_GET['error'] == 'user_inactive') {
                        echo '⚠️ Usuario inactivo';
                    } else {
                        echo 'Error: ' . htmlspecialchars($_GET['error']);
                    }
                    echo '</div>';
                }
                ?>
                
                <form method="POST" action="api/auth/login.php" onsubmit="return validarLogin()">
                    <!-- EMAIL -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email"
                            placeholder="tu@email.com"
                            required
                        >
                    </div>
                    
                    <!-- PASSWORD -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="password"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                    
                    <!-- ROL OCULTO -->
                    <input type="hidden" name="role" id="role" value="Administrador">
                    
                    <!-- REMEMBER ME -->
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="remember" 
                            name="remember"
                        >
                        <label for="remember" class="form-check-label">
                            Remember me
                        </label>
                    </div>
                    
                    <!-- FORGOT PASSWORD -->
                    <div class="form-footer">
                        <div></div>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>
                    
                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn-login">Iniciar sesión</button>
                </form>
                
                <div class="signup-link">
                    Don't have an account? <a href="#">Sign up</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarLogin() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                alert('Por favor completa todos los campos');
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
