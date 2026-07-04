<?php
/**
 * DASHBOARD PRINCIPAL
 * Panel Central del Sistema
 */

session_start();

include 'includes/config/database.php';

// Verificar si está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Usuario';
$nombre = $_SESSION['nombre'] ?? 'Usuario';
$role = $_SESSION['role'] ?? 'Consultor';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
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
        }
        
        /* NAVBAR */
        .navbar-custom {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex: 1;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        
        .navbar-menu {
            display: flex;
            gap: 2rem;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .navbar-menu a:hover {
            color: #5dade2;
        }
        
        .search-box {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 20px;
            width: 300px;
            transition: all 0.3s;
        }
        
        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .search-box:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-color: #5dade2;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #5dade2;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        /* CONTENEDOR PRINCIPAL  MAIN CONTAINER */
        .main-container {
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }
        
        .page-header h1 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .page-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /*   Cuadrícula de tarjetas CARDS GRID */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .module-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 350px;
        }
        
        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .module-card-header {
            background: linear-gradient(135deg, #5dade2 0%, #2a5298 100%);
            padding: 2rem;
            text-align: center;
            color: white;
            flex-shrink: 0;
        }
        
        .module-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .module-card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }
        
        .module-card-body {
            padding: 2rem;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .module-description {
            color: #34495e;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        
        .module-btn {
            background: linear-gradient(135deg, #5dade2 0%, #2a5298 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            align-self: center;
            width: auto;
        }
        
        .module-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logout-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(192, 57, 43, 0.4);
        }
        
        /* RESPONSIVE  */
        @media (max-width: 768px) {
            .navbar-custom {
                flex-direction: column;
                gap: 1rem;
            }
            
            .navbar-left {
                width: 100%;
                flex-direction: column;
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .navbar-menu {
                display: none;
            }
            
            .search-box {
                width: 100%;
            }
            
            .navbar-right {
                width: 100%;
                justify-content: space-between;
            }
            
            .main-container {
                padding: 1rem;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .page-header p {
                font-size: 1rem;
            }
            
            .modules-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
   /* Barra de navegación */
    <!-- NAVBAR -->
    <nav class="navbar-custom">
        <div class="navbar-left">
            <a href="app.php" class="navbar-brand">
                <i class="fas fa-building"></i> Ayuntamiento
            </a>
            <div class="navbar-menu">
                <a href="#">Home</a>
                <a href="#">About</a>
            </div>
        </div>
        
        <input type="text" class="search-box" placeholder="Buscar...">
        
        <div class="navbar-right">
            <div class="user-info">
                <span><?php echo htmlspecialchars($nombre); ?></span>
                <div class="user-avatar">
                    <?php echo strtoupper(substr($nombre, 0, 1)); ?>
                </div>
            </div>
            <a href="api/auth/logout.php" class="logout-btn" title="Cerrar Sesión">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>
    
    <!-- MAIN CONTENT(CONTENEDOR PRINCIPAL ) -->
    <div class="main-container">
        <!-- PAGE HEADER (ENCABEZADO DE PÁGINA) -->
        <div class="page-header">
            <h1>Bienvenido al Sistema</h1>
            <p>Gestión de Archivos Municipales</p>
        </div>
        
        <!-- MODULES GRID (CUADRICULA DE MODULOS ) -->
        <div class="modules-grid">
            
            <!-- MÓDULO: DOCUMENTOS -->
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-icon">📂</div>
                    <h3 class="module-card-title">Documentos</h3>
                </div>
                <div class="module-card-body">
                    <p class="module-description">Acceso a archivos y documentos del sistema municipal</p>
                    <a href="modules/expedientes/index.php" class="module-btn">Abrir</a>
                </div>
            </div>
            
            <!-- MÓDULO: USUARIOS -->
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-icon">👥</div>
                    <h3 class="module-card-title">Usuarios</h3>
                </div>
                <div class="module-card-body">
                    <p class="module-description">Gestión de usuarios del sistema</p>
                    <a href="<?php echo ($role === 'Administrador') ? 'modules/usuarios/index.php' : 'modules/perfil/index.php'; ?>" class="module-btn">Abrir</a>
                </div>
            </div>
            
            <!-- MÓDULO: CONFIGURACIÓN -->
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-icon">⚙️</div>
                    <h3 class="module-card-title">Configuración</h3>
                </div>
                <div class="module-card-body">
                    <p class="module-description">Configurar preferencias y opciones del sistema</p>
                    <a href="modules/perfil/index.php" class="module-btn">Abrir</a>
                </div>
            </div>
            
            <!-- MÓDULO: REPORTES -->
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-icon">📊</div>
                    <h3 class="module-card-title">Reportes</h3>
                </div>
                <div class="module-card-body">
                    <p class="module-description">Generación de reportes y estadísticas</p>
                    <a href="modules/auditoria/index.php" class="module-btn">Abrir</a>
                </div>
            </div>
            
            <!-- MÓDULO: SEGURIDAD -->
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-icon">🔒</div>
                    <h3 class="module-card-title">Seguridad</h3>
                </div>
                <div class="module-card-body">
                    <p class="module-description">Auditoría y control de seguridad del sistema</p>
                    <a href="modules/auditoria/index.php" class="module-btn">Abrir</a>
                </div>
            </div>
            
            <!-- MÓDULO: MENSAJES -->
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-icon">💬</div>
                    <h3 class="module-card-title">Mensajes</h3>
                </div>
                <div class="module-card-body">
                    <p class="module-description">Centro de notificaciones y mensajes del sistema</p>
                    <a href="modules/mensajes/index.php" class="module-btn">Abrir</a>
                </div>
            </div>
            
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/script.js"></script>
</body>
</html>
