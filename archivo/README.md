# 📋 Sistema de Gestión de Archivos Municipales

## 🎯 Descripción General

Sistema completo para la gestión de archivos, expedientes y documentos municipales. Incluye control de préstamos, transferencias, inventario en tiempo real y auditoría completa.

## 📊 Módulos Implementados

| # | Módulo | Descripción |
|---|--------|------------|
| 1 | **Login/Autenticación** | Autenticación con roles (Admin, Documentalista, Consultor) |
| 2 | **Dashboard** | Panel de control con estadísticas en tiempo real |
| 3 | **Gestión de Expedientes** | CRUD completo de expedientes (crear, editar, ver, eliminar) |
| 4 | **Búsqueda Cruzada** | Búsqueda avanzada con múltiples filtros |
| 5 | **Control de Inventario** | Monitoreo de cajas y ocupación (%) |
| 6 | **Préstamos** | Registro de préstamos y devoluciones |
| 7 | **Transferencias** | Movimiento de expedientes entre cajas |
| 8 | **Catálogos** | CRUD de Fondos, Series, Áreas, Estantes, Cajas, Niveles |
| 9 | **Usuarios y Roles** | Gestión de usuarios (solo Admin) |
| 10 | **Bitácora de Auditoría** | Registro de todas las operaciones del sistema |

## 🏗️ Estructura de Carpetas

```
archivo/
├── public/
│   ├── css/
│   │   └── style.css              # Estilos principales
│   ├── js/
│   │   └── script.js              # JavaScript compartido
│   └── img/                       # Imágenes
├── includes/
│   ├── config/
│   │   ├── database.php           # Conexión a BD
│   │   └── constants.php          # Constantes del sistema
│   ├── helpers/
│   │   └── Functions.php          # Funciones auxiliares
│   └── auth/
│       └── Session.php            # Gestión de sesiones
├── modules/
│   ├── dashboard/
│   ├── expedientes/
│   │   ├── index.php              # Lista
│   │   ├── crear.php              # Formulario crear
│   │   ├── editar.php             # Editar expediente
│   │   └── ver.php                # Ver detalles
│   ├── busqueda/
│   ├── inventario/
│   ├── prestamos/
│   ├── transferencias/
│   ├── usuarios/
│   ├── catalogos/
│   ├── auditoria/
│   └── perfil/
├── api/
│   ├── auth/
│   │   ├── login.php              # Endpoint login
│   │   └── logout.php             # Endpoint logout
│   ├── expedientes/
│   │   ├── crear.php
│   │   ├── editar.php
│   │   ├── eliminar.php
│   │   └── obtener.php
│   ├── prestamos/
│   ├── usuarios/
│   └── transferencias/
├── index.php                      # Página de login
├── app.php                        # Dashboard principal
├── conexion.php                   # Conexión BD (antigua)
├── style.css                      # Estilos (antiguos)
├── script.js                      # JS (antiguos)
└── README.md                      # Este archivo
```

## 🔐 Sistema de Roles y Permisos

### Roles Disponibles:

#### 👨‍💼 Administrador
- ✅ Crear/editar/eliminar usuarios
- ✅ Gestionar catálogos
- ✅ Ver auditoría completa
- ✅ Todas las operaciones

#### 📄 Documentalista
- ✅ Crear/editar expedientes
- ✅ Registrar préstamos
- ✅ Realizar transferencias
- ✅ Ver dashboard

#### 👁️ Consultor
- ✅ Ver expedientes
- ✅ Ver préstamos
- ✅ Ver dashboard

## 🔑 Credenciales de Prueba

```
Admin:
- Email: admin@tecamachalco.mx
- Contraseña: 123456
- Rol: Administrador

Documentalista:
- Email: doc@tecamachalco.mx
- Contraseña: 123456
- Rol: Documentalista

Consultor:
- Email: consultor@tecamachalco.mx
- Contraseña: 123456
- Rol: Consultor
```

## 📱 Interfaz de Usuario

### ✨ Características del UI:

- **Diseño Responsivo**: Funciona en móviles, tablets y desktops
- **Sidebar de Navegación**: Menú lateral colapsable
- **Dashboard Intuitivo**: Panel central con estadísticas
- **Tablas Interactivas**: Búsqueda, filtrado y sorting
- **Modales**: Para confirmaciones y acciones rápidas
- **Alertas**: Feedback visual de operaciones
- **Badges**: Indicadores de estado
- **Cards**: Presentación ordenada de información

## 🎨 Paleta de Colores

```css
--primary-color: #2c3e50      /* Azul marino oscuro */
--secondary-color: #3498db    /* Azul moderno */
--success-color: #27ae60      /* Verde */
--warning-color: #f39c12      /* Naranja */
--danger-color: #e74c3c       /* Rojo */
--light-bg: #ecf0f1           /* Gris claro */
```

## 🗄️ Base de Datos

### Tablas Necesarias (SQL):

```sql
-- Usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol ENUM('admin', 'documentalista', 'consultor'),
    estado ENUM('activo', 'inactivo'),
    telefono VARCHAR(20),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Expedientes
CREATE TABLE expedientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    folio VARCHAR(50) UNIQUE,
    asunto TEXT,
    serie_id INT,
    caja_id INT,
    fecha_inicio DATE,
    estado ENUM('activo', 'inactivo', 'prestado', 'eliminado'),
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cajas
CREATE TABLE cajas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    ubicacion VARCHAR(100),
    capacidad INT DEFAULT 100,
    estado ENUM('disponible', 'llena', 'descartada'),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Préstamos
CREATE TABLE prestamos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    expediente_id INT,
    usuario_solicitante INT,
    fecha_solicitud DATE,
    fecha_vencimiento DATE,
    estado ENUM('solicitado', 'activo', 'vencido', 'devuelto'),
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Transferencias
CREATE TABLE transferencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    expediente_id INT,
    caja_origen_id INT,
    caja_destino_id INT,
    usuario_id INT,
    fecha_transferencia TIMESTAMP,
    motivo TEXT
);

-- Series
CREATE TABLE series (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bitácora
CREATE TABLE bitacora (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    accion VARCHAR(50),
    modulo VARCHAR(50),
    detalles TEXT,
    ip_address VARCHAR(50),
    user_agent TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🚀 Cómo Usar

### 1. Instalación

1. Coloca los archivos en `C:\xampp\htdocs\xampp\archivo`
2. Crea la base de datos `archivo_municipal` en MySQL
3. Ejecuta el script SQL para crear las tablas
4. Configura el acceso en `includes/config/database.php`

### 2. Acceso

1. Abre: `http://localhost/xampp/archivo/`
2. Selecciona el rol
3. Ingresa credenciales de prueba
4. ¡Comienza a usar!

### 3. Flujo de Operaciones Típicas

#### Crear Expediente:
```
Dashboard → Expedientes → Nuevo Expediente → Completar formulario → Guardar
```

#### Registrar Préstamo:
```
Dashboard → Préstamos → Nuevo Préstamo → Seleccionar expediente → Guardar
```

#### Buscar Expediente:
```
Dashboard → Búsqueda → Ingresar criterios → Buscar → Ver resultados
```

## 📋 API REST (Endpoints)

### Autenticación
```
POST /api/auth/login.php          # Login de usuario
GET  /api/auth/logout.php         # Logout
```

### Expedientes
```
POST   /api/expedientes/crear.php      # Crear expediente
PUT    /api/expedientes/editar.php     # Editar
DELETE /api/expedientes/eliminar.php   # Eliminar
GET    /api/expedientes/obtener.php    # Obtener uno
GET    /api/expedientes/listar.php     # Listar todos
```

### Usuarios (Admin)
```
POST   /api/usuarios/crear.php         # Crear usuario
PUT    /api/usuarios/editar.php        # Editar
DELETE /api/usuarios/eliminar.php      # Eliminar
GET    /api/usuarios/listar.php        # Listar
```

### Préstamos
```
POST   /api/prestamos/crear.php        # Crear préstamo
POST   /api/prestamos/devolver.php     # Registrar devolución
```

## 🔧 Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5.3
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Servidor**: Apache (XAMPP)

## 📝 Características Especiales

### ✅ Validaciones
- Validación de emails
- Validación de contraseñas (min 6 caracteres)
- Prevención de inyección SQL
- Verificación de roles y permisos

### 📊 Estadísticas en Tiempo Real
- Total de expedientes
- Préstamos activos
- Cajas al 90% de ocupación
- Usuarios activos

### 🔔 Alertas y Notificaciones
- Cajas al máximo de capacidad
- Préstamos vencidos
- Operaciones completadas
- Errores y validaciones

### 📋 Auditoría Completa
- Registro de IP
- User Agent
- Timestamp de cada operación
- Detalles de la acción

## 🎯 Próximas Mejoras

- [ ] Reportes en PDF
- [ ] Exportación a Excel
- [ ] Gráficas estadísticas avanzadas
- [ ] Notificaciones por correo
- [ ] QR codes para cajas
- [ ] API REST completa
- [ ] Panel móvil nativo
- [ ] Sistema de backup automático

## 🆘 Soporte y Troubleshooting

### Error: "Error al conectar a base de datos"
```
✅ Verifica que MySQL esté corriendo
✅ Confirma credenciales en database.php
✅ Verifica que la base de datos exista
```

### Error: "No tienes permiso"
```
✅ Verifica tu rol de usuario
✅ Asegúrate de estar logeado
✅ Contacta al administrador
```

### Sesión expirada
```
✅ Timeout por inactividad: 8 horas
✅ Haz login nuevamente
```

## 📞 Contacto

- **Desarrollo**: Sistema Municipal de Archivos
- **Email**: soporte@tecamachalco.mx
- **Versión**: 1.0.0
- **Última Actualización**: 2024

---

**Sistema desarrollado para el Ayuntamiento de Tecamachalco** ✅
