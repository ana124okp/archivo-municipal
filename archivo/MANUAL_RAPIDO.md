# 🎯 MANUAL DE USO RÁPIDO

## Sistema de Gestión de Archivos Municipales

---

## 📱 Pantalla Principal de Login

### Cómo Iniciar Sesión:

1. **Abre el navegador** y ve a: `http://localhost/xampp/archivo/`

2. **Selecciona tu rol**:
   - 👨‍💼 **Administrador** - Acceso total
   - 📄 **Documentalista** - Crear y editar expedientes
   - 👁️ **Consultor** - Solo visualizar

3. **Ingresa credenciales** (prueba):
   ```
   Email: admin@tecamachalco.mx
   Contraseña: 123456
   ```

4. **Haz clic** en: "Iniciar Sesión"

✅ **Ingresarás al Dashboard**

---

## 🏠 Dashboard - Panel Principal

### Qué ves aquí:

```
┌─────────────────────────────────────┐
│  BIENVENIDO AL DASHBOARD            │
├─────────────────────────────────────┤
│                                     │
│ 📊 ESTADÍSTICAS EN TIEMPO REAL:     │
│ ├─ Total Expedientes: 450           │
│ ├─ Préstamos Activos: 12            │
│ ├─ Cajas al 90%: 3                  │
│ └─ Usuarios Activos: 25             │
│                                     │
│ ⚡ ACCIONES RÁPIDAS:                 │
│ ├─ ➕ Nuevo Expediente               │
│ ├─ 📤 Registrar Préstamo            │
│ ├─ ↔️  Realizar Transferencia       │
│ └─ 🔍 Buscar Expediente             │
│                                     │
│ 📝 ÚLTIMOS MOVIMIENTOS:             │
│ (Tabla con actividad reciente)      │
│                                     │
└─────────────────────────────────────┘
```

---

## 📂 MÓDULO: Expedientes

### 1️⃣ CREAR NUEVO EXPEDIENTE

```
Dashboard → Expedientes → [Botón] ➕ Nuevo Expediente
```

**Formulario a completar:**

| Campo | Descripción | Ejemplo |
|-------|-------------|---------|
| **Folio** | ID único del expediente | EXP-2024-001 |
| **Asunto** | Descripción del contenido | "Reglamento de tránsito" |
| **Serie** | Categoría documentaria | Reglamentos |
| **Caja** | Dónde guardarlo | Caja A-1 |
| **Fecha Inicio** | Cuándo comienza | 2024-01-15 |
| **Observaciones** | Notas adicionales | "Documento original" |

**Botones finales:**
- 🔙 Cancelar → Vuelve a la lista
- ✅ Crear Expediente → Guarda

---

### 2️⃣ VER LISTA DE EXPEDIENTES

```
Dashboard → Expedientes (o botón en sidebar)
```

**Tabla interactiva con:**
- Búsqueda rápida por folio
- Ordenamiento por columnas
- Filtrado por estado
- Paginación automática

**Acciones disponibles:**
- 👁️ **Ver** → Detalles completos
- ✏️ **Editar** → Modificar datos
- 🔗 **Préstamo** → Registrar préstamo

---

### 3️⃣ VER DETALLES DE EXPEDIENTE

```
Expedientes → [Tabla] → Botón "Ver"
```

**Información mostrada:**
- Datos completos del expediente
- Historial de movimientos
- Botones de acciones rápidas
- Relacionados: Ubicación, Serie, Caja

**Acciones desde aquí:**
- 🤝 Registrar Préstamo
- ↔️ Realizar Transferencia
- ✏️ Editar

---

## 🔍 MÓDULO: Búsqueda Cruzada

### Buscar Expedientes Avanzado

```
Dashboard → Búsqueda
```

**Filtros disponibles:**

```
┌────────────────────────────────────┐
│ FILTROS DE BÚSQUEDA                │
├────────────────────────────────────┤
│                                    │
│ 📄 Palabra Clave:  ____________     │
│    (Folio, asunto, observaciones)  │
│                                    │
│ 📚 Serie:  [Selecciona ▼]           │
│                                    │
│ 📊 Estado: [Todas ▼]               │
│    └─ Activo / Inactivo / Préstado │
│                                    │
│ 📦 Caja:   [Selecciona ▼]           │
│                                    │
│ 📅 Fecha:  [Desde] __ [Hasta] __   │
│                                    │
│ [Limpiar]  [🔍 Buscar]              │
│                                    │
└────────────────────────────────────┘
```

**Ejemplo de búsqueda:**
1. Escribe: "reglamento"
2. Selecciona Serie: "Reglamentos"
3. Haz clic: "Buscar"
4. **Resultado**: 15 coincidencias

---

## 🤝 MÓDULO: Préstamos

### Registrar Préstamo

```
Dashboard → Préstamos → ➕ Nuevo Préstamo
```

**Pasos:**

1. **Selecciona expediente** de dropdown
   - Muestra folio y asunto
   
2. **Ingresa fecha de vencimiento**
   - Día máximo de devolución
   
3. **Agrega observaciones** (opcional)
   - Motivo del préstamo
   - Quién lo solicita
   
4. **Haz clic**: ✅ Crear Préstamo

✅ **El expediente cambiará estado a "En Préstamo"**

---

### Ver Préstamos Activos

```
Dashboard → Préstamos
```

**Tabla muestra:**
- Expediente en préstamo
- Quién lo solicitó
- Fecha de solicitud
- Fecha de vencimiento
- Estado: Solicitado / Activo / Vencido / Devuelto

**Código de colores:**
- 🟢 Verde = Activo
- 🔴 Rojo = Vencido
- ⚪ Gris = Devuelto

---

## 📦 MÓDULO: Inventario

### Ver Estado de Cajas

```
Dashboard → Inventario
```

**Vista de cajas:**

```
┌──────────────────┐
│ Caja A-1         │
│ Ubicación: Est.A │
│                  │
│ Ocupación:       │
│ ████░░░░░ 45%    │ ✅ Disponible
│                  │
│ Expedientes: 45  │
│ Capacidad: 100   │
└──────────────────┘

┌──────────────────┐
│ Caja B-2         │
│ Ubicación: Est.B │
│                  │
│ Ocupación:       │
│ ██████████ 95%   │ ⚠️ CRÍTICA
│                  │
│ Expedientes: 95  │
│ Capacidad: 100   │
└──────────────────┘
```

**Colores:**
- 🟢 Verde (< 70%) - Disponible
- 🟡 Naranja (70-90%) - Medio lleno
- 🔴 Rojo (> 90%) - Crítico

---

## 👥 MÓDULO: Usuarios (Solo Admin)

### Crear Nuevo Usuario

```
Dashboard → Usuarios → ➕ Nuevo Usuario
```

**Formulario:**

| Campo | Requerido | Notas |
|-------|-----------|-------|
| Nombre Completo | ✅ | Ej: Juan Pérez |
| Email | ✅ | Debe ser único |
| Contraseña | ✅ | Mínimo 6 caracteres |
| Confirmar | ✅ | Debe coincidir |
| Rol | ✅ | Admin / Documentalista / Consultor |
| Estado | ✅ | Activo / Inactivo |
| Teléfono | ❌ | Opcional |

**Ejemplo:**
```
Nombre: María García
Email: maria@tecamachalco.mx
Contraseña: Temporal123
Rol: Documentalista
Estado: Activo
```

---

### Listar Usuarios

```
Dashboard → Usuarios
```

**Tabla con:**
- Nombre y Email
- Rol asignado
- Estado (Activo/Inactivo)
- Fecha de creación
- Botones: Editar / Eliminar

---

## 📋 MÓDULO: Auditoría (Solo Admin)

### Ver Bitácora Completa

```
Dashboard → Auditoría
```

**Información registrada:**

```
│ Usuario          │ Acción | Módulo  │ Detalles          │ IP          │ Fecha            │
├──────────────────┼────────┼─────────┼───────────────────┼─────────────┼──────────────────┤
│ Admin Usuario    │ LOGIN  │ Auth    │ Sesión iniciada   │ 192.168.1.1 │ 2024-01-15 09:30 │
│ María García     │ CREAR  │ Expedientes │ Exp-2024-001 created │ 192.168.1.2 │ 2024-01-15 09:45 │
│ Admin Usuario    │ CREATE │ Usuarios │ Usuario juan@... │ 192.168.1.1 │ 2024-01-15 10:00 │
```

**Qué se registra:**
- ✅ Quién hizo la acción (usuario)
- ✅ Qué hizo (acción)
- ✅ Dónde (módulo)
- ✅ Cuándo (fecha/hora)
- ✅ Desde dónde (IP)

---

## 📚 MÓDULO: Catálogos (Solo Admin)

### Gestión de Catálogos

```
Dashboard → Catálogos
```

**6 opciones disponibles:**

1. **📁 Fondos** - Fondos documentales
   - Crear fondos generales e históricos
   
2. **📋 Series** - Series documentales
   - Asociadas a fondos
   
3. **🏢 Áreas** - Áreas del municipio
   - Administración, Tesorería, RH, etc.
   
4. **🏗️ Estantes** - Estantes físicos
   - Ubicación en almacén
   
5. **📦 Cajas** - Cajas de almacenamiento
   - Capacidad y ubicación
   
6. **🔤 Niveles** - Niveles de clasificación
   - Jerarquía documental

---

## 👤 Mi Perfil

### Acceder a Perfil Personal

```
Dashboard → Mi Perfil (o Avatar en navbar)
```

**Información visible:**
- Nombre completo
- Email
- Rol actual
- Estado
- Teléfono
- Fecha de registro

**Acciones:**
- 🔑 Cambiar Contraseña
- 🚪 Cerrar Sesión

---

## 🔑 Cambiar Contraseña

```
Mi Perfil → [Botón] Cambiar Contraseña
```

**Modal con campos:**
1. Contraseña actual
2. Nueva contraseña
3. Confirmar contraseña

**Validaciones:**
- ✅ Mínimo 6 caracteres
- ✅ Deben coincidir
- ✅ Contraseña actual correcta

---

## 🔄 Flujos Completos de Ejemplo

### 📌 Flujo 1: Crear y Prestar Expediente

```
1. [LOGIN] admin@tecamachalco.mx / 123456
   ↓
2. [DASHBOARD] Ver estadísticas generales
   ↓
3. [EXPEDIENTES] Botón "Nuevo Expediente"
   ├─ Folio: EXP-2024-250
   ├─ Asunto: Reglamento de parques
   ├─ Serie: Reglamentos
   ├─ Caja: A-1
   └─ ✅ Crear
   ↓
4. [DASHBOARD] Estatísticas actualizadas (+1 expediente)
   ↓
5. [PRÉSTAMOS] Botón "Nuevo Préstamo"
   ├─ Selecciona: EXP-2024-250
   ├─ Vencimiento: 2024-02-15
   └─ ✅ Crear Préstamo
   ↓
6. [AUDITORÍA] Registra ambas operaciones
   └─ 2 entradas en bitácora
```

---

### 📌 Flujo 2: Buscar y Ver Detalles

```
1. [LOGIN] consultor@tecamachalco.mx / 123456
   ↓
2. [BÚSQUEDA] Ingresa criterios
   ├─ Palabra: "reglamento"
   ├─ Serie: Reglamentos
   └─ 🔍 Buscar
   ↓
3. [RESULTADOS] Tabla con 5 coincidencias
   ├─ Haz clic en primer resultado
   ↓
4. [DETALLES] Ver información completa
   ├─ Datos del expediente
   ├─ Historial de movimientos
   └─ Ubicación en caja
```

---

### 📌 Flujo 3: Crear Usuario (Admin)

```
1. [LOGIN] admin@tecamachalco.mx / 123456
   ↓
2. [USUARIOS] Botón "Nuevo Usuario"
   ├─ Nombre: Carlos López
   ├─ Email: carlos@tecamachalco.mx
   ├─ Contraseña: Temporal2024
   ├─ Rol: Documentalista
   ├─ Estado: Activo
   └─ ✅ Crear Usuario
   ↓
3. [AUDITORÍA] Se registra la acción
   └─ Usuario "Carlos López" creado con éxito
```

---

## ⌨️ Atajos de Teclado

| Atajo | Función |
|-------|---------|
| `Tab` | Navegar entre campos |
| `Enter` | Enviar formulario |
| `Esc` | Cerrar modal |
| `Ctrl+A` | Seleccionar todo en campo |

---

## 🆘 Problemas Comunes

### ❌ "Contraseña incorrecta"
✅ **Solución**: La contraseña de prueba es: `123456`

### ❌ "Usuario o contraseña incorrectos"
✅ **Solución**: 
- Verifica seleccionar el rol correcto
- Email debe ser exacto: `admin@tecamachalco.mx`

### ❌ "Sesión expirada"
✅ **Solución**: Has estado inactivo 8+ horas
- Vuelve a hacer login

### ❌ "Error de base de datos"
✅ **Solución**: 
- Verifica que MySQL esté corriendo
- Reinicia Apache y MySQL desde XAMPP

### ❌ "No veo mis expedientes creados"
✅ **Solución**:
- Limpia caché: `Ctrl+Shift+R`
- Verifica que sea el mismo usuario

---

## 📞 Consejos de Uso

✅ **Buenas prácticas:**
- Cambiar contraseña regularmente
- Revisar auditoría semanalmente
- Crear backups mensuales
- No compartir credenciales
- Avisar si una caja llega a 90%

⚠️ **Evitar:**
- Dejar sesión abierta en PC público
- Usar contraseña simple
- Crear expedientes sin folio único
- Llenar cajas más de 100%

---

## 🎓 Guía por Rol

### 👨‍💼 ADMINISTRADOR - Acceso Total
```
✅ Crear usuarios
✅ Ver auditoría
✅ Gestionar catálogos
✅ Crear expedientes
✅ Registrar préstamos
✅ Ver inventario
✅ Todas las operaciones
```

### 📄 DOCUMENTALISTA - Operativo
```
✅ Crear expedientes
✅ Editar expedientes
✅ Registrar préstamos
✅ Realizar transferencias
✅ Ver inventario
✅ Buscar expedientes
❌ Gestionar usuarios
❌ Ver auditoría
```

### 👁️ CONSULTOR - Lectura
```
✅ Ver expedientes
✅ Ver préstamos
✅ Ver inventario
✅ Buscar expedientes
✅ Ver su perfil
❌ Crear expedientes
❌ Registrar préstamos
❌ Gestionar usuarios
```

---

## 🎯 Conclusión

**Recuerda:**
- El sistema está diseñado para ser intuitivo
- Si algo falla, revisa la auditoría
- Contacta al administrador si tienes dudas
- ¡Mantén los datos organizados!

---

**¡Bienvenido al Sistema de Gestión de Archivos! 📋**

Para más ayuda, consulta: `README.md`
