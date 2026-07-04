# 📦 GUÍA DE INSTALACIÓN - Sistema de Gestión de Archivos Municipales

## 🚀 Requisitos Previos

- **XAMPP** (Apache + MySQL + PHP) instalado en `C:\xampp`
- **PHP 7.4** o superior
- **MySQL 5.7** o superior
- **Navegador web** moderno (Chrome, Firefox, Edge)

---

## 📋 Paso 1: Preparar la Base de Datos

### 1.1 Acceder a phpMyAdmin

1. Asegúrate que XAMPP esté ejecutándose
2. Abre en tu navegador: `http://localhost/phpmyadmin`
3. Inicia sesión (Usuario: `root`, Contraseña: vacía)

### 1.2 Crear Base de Datos

1. Haz clic en **"Nueva"** (lado izquierdo)
2. Nombre de la base de datos: `archivo_municipal`
3. Intercalación: `utf8mb4_unicode_ci`
4. Haz clic en **"Crear"**

### 1.3 Ejecutar Script SQL

1. Ve a la pestaña **"SQL"** en phpMyAdmin
2. Abre y copia el contenido de: `C:\xampp\htdocs\xampp\archivo\SCRIPT_SQL.sql`
3. Pega el código SQL en el editor
4. Haz clic en **"Ejecutar"**

✅ **Resultado esperado**: Se crearán todas las tablas y se insertarán datos de prueba

---

## 📂 Paso 2: Verificar Estructura de Carpetas

Verifica que las carpetas estén en:

```
C:\xampp\htdocs\xampp\archivo\
├── public/
│   ├── css/
│   ├── js/
│   └── img/
├── includes/
│   ├── config/
│   ├── helpers/
│   └── auth/
├── modules/
│   ├── expedientes/
│   ├── busqueda/
│   ├── prestamos/
│   ├── inventario/
│   ├── transferencias/
│   ├── usuarios/
│   ├── catalogos/
│   ├── auditoria/
│   └── perfil/
├── api/
│   ├── auth/
│   ├── expedientes/
│   ├── prestamos/
│   └── usuarios/
├── index.php
├── app.php
└── README.md
```

---

## ⚙️ Paso 3: Configurar Conexión a Base de Datos

Abre: `C:\xampp\htdocs\xampp\archivo\includes\config\database.php`

Verifica que los datos sean correctos:

```php
$hostname = "localhost";
$username = "root";
$password = "";              // Vacío si es instalación local
$database = "archivo_municipal";
```

**Nota**: Si tu MySQL requiere contraseña, cámbiala en `$password`

---

## 🌐 Paso 4: Acceder a la Aplicación

### 4.1 URL de Acceso

```
http://localhost/xampp/archivo/
```

### 4.2 Selecciona un Rol

En la pantalla de login, selecciona uno de los tres roles:
- 👨‍💼 **Administrador**
- 📄 **Documentalista**
- 👁️ **Consultor**

### 4.3 Inicia Sesión

**Credenciales de prueba:**

```
Email: admin@tecamachalco.mx
Contraseña: 123456
```

---

## ✅ Verificación de Instalación

Después de acceder, verifica que veas:

- ✅ Dashboard con estadísticas
- ✅ Menú lateral con opciones
- ✅ Tarjetas de estadísticas
- ✅ Últimos movimientos en la tabla
- ✅ Botones de acciones rápidas

---

## 🔧 Troubleshooting

### ❌ Error: "Error al conectar: Connection refused"

**Solución:**
1. Abre XAMPP Control Panel
2. Inicia **Apache** y **MySQL**
3. Espera a que muestren "Running"
4. Recarga la página

### ❌ Error: "La base de datos 'archivo_municipal' no existe"

**Solución:**
1. Accede a phpMyAdmin
2. Verifica que exista `archivo_municipal`
3. Si no existe, ejecuta el SCRIPT_SQL.sql nuevamente

### ❌ No puedo iniciar sesión

**Solución:**
1. Verifica que escribas correctamente: `admin@tecamachalco.mx`
2. La contraseña es: `123456`
3. Selecciona el rol: **Administrador**
4. Limpia cookies del navegador (Ctrl+Shift+Del)

### ❌ Las estilos no cargan correctamente

**Solución:**
1. Limpia caché del navegador: `Ctrl+Shift+R`
2. Verifica que CSS esté en: `public/css/style.css`
3. Comprueba que JavaScript está en: `public/js/script.js`

### ❌ Las imágenes no se ven

**Solución:**
1. Las imágenes van en: `public/img/`
2. Referencia en HTML: `<img src="public/img/nombre.jpg">`

---

## 👥 Gestionar Usuarios

### Crear nuevo usuario (Admin)

1. Inicia sesión como **Administrador**
2. Ve a: **Usuarios → Nuevo Usuario**
3. Completa el formulario:
   - Nombre completo
   - Email
   - Contraseña (mín 6 caracteres)
   - Rol
   - Estado
4. Haz clic en **"Crear Usuario"**

### Cambiar contraseña

1. Ve a: **Mi Perfil**
2. Haz clic en **"Cambiar Contraseña"**
3. Ingresa la contraseña actual
4. Ingresa la nueva contraseña
5. Confirma y guarda

---

## 📊 Datos de Prueba Disponibles

### Usuarios
```
1. Admin
   Email: admin@tecamachalco.mx
   Rol: Administrador
   
2. Documentalista
   Email: doc@tecamachalco.mx
   Rol: Documentalista
   
3. Consultor
   Email: consultor@tecamachalco.mx
   Rol: Consultor
```

### Fondos
- Fondo General
- Fondo Histórico

### Series
- Reglamentos
- Acuerdos
- Contratos

### Cajas Disponibles
- Caja A-1, A-2, B-1, C-1
- Ubicaciones asignadas
- Capacidad: 50 documentos c/u

---

## 🎯 Flujos de Trabajo Típicos

### Crear y Prestar un Expediente

1. **Iniciar sesión** como Documentalista
2. **Ir a**: Expedientes → Nuevo Expediente
3. **Llenar datos**:
   - Folio: `EXP-2024-001`
   - Asunto: Describe el contenido
   - Serie: Selecciona una serie
   - Caja: Elige una caja disponible
4. **Guardar**
5. **Ir a**: Préstamos → Nuevo Préstamo
6. **Seleccionar** el expediente creado
7. **Guardar**

### Buscar un Expediente

1. **Ir a**: Búsqueda
2. **Ingresa criterios**:
   - Palabra clave (folio, asunto, etc.)
   - Serie específica (opcional)
   - Rango de fechas (opcional)
3. **Haz clic** en: Buscar
4. **Ver resultados** en tabla

### Gestionar Inventario

1. **Ir a**: Inventario
2. **Ver estado de cajas** con gráficos de ocupación
3. **Alertas** si alguna caja está al 90%+

---

## 🔐 Seguridad

### Mejores Prácticas

- ✅ Cambiar contraseña de **root** en MySQL
- ✅ No dejar credenciales en el código
- ✅ Usar HTTPS en producción
- ✅ Mantener backups regulares
- ✅ Revisar bitácora de auditoría

### Backup de Base de Datos

1. Abre phpMyAdmin
2. Ve a: `archivo_municipal` → **Exportar**
3. Formato: SQL
4. Haz clic en **"Ir"**
5. Guarda el archivo `.sql`

---

## 📞 Soporte

Si encuentras problemas:

1. Revisa la consola de navegador (F12)
2. Verifica logs de Apache en `C:\xampp\apache\logs`
3. Verifica logs de MySQL en `C:\xampp\mysql\data`
4. Consulta el README.md del proyecto

---

## 🎉 ¡Listo!

Tu sistema está configurado y listo para usar. 

**Próximos pasos:**
- [ ] Explorar el dashboard
- [ ] Crear algunos expedientes de prueba
- [ ] Probar el sistema de búsqueda
- [ ] Registrar préstamos
- [ ] Ver la bitácora de auditoría

---

**Versión**: 1.0.0  
**Última actualización**: 2024  
**Desarrollado para**: Ayuntamiento de Tecamachalco
