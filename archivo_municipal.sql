-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS archivo_municipal
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE archivo_municipal;

-- 1. ROLES
CREATE TABLE ROLES (
    id_rol INT NOT NULL AUTO_INCREMENT,
    nombre_rol VARCHAR(50) NOT NULL,
    descripcion TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. USUARIOS
CREATE TABLE USUARIOS (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    id_rol INT NOT NULL,
    nombre VARCHAR(80) NOT NULL,
    apellido_paterno VARCHAR(60) NOT NULL,
    apellido_materno VARCHAR(60) NULL DEFAULT NULL,
    usuario VARCHAR(30) NOT NULL,
    contrasena_hash VARCHAR(255) NOT NULL,
    correo VARCHAR(120) NULL DEFAULT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (id_usuario),
    UNIQUE KEY uk_usuario (usuario),
    UNIQUE KEY uk_correo (correo),
    CONSTRAINT fk_usuarios_roles FOREIGN KEY (id_rol) REFERENCES ROLES (id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. FONDOS
CREATE TABLE FONDOS (
    id_fondo INT NOT NULL AUTO_INCREMENT,
    clave_fondo VARCHAR(20) NOT NULL,
    nombre_fondo VARCHAR(150) NOT NULL,
    descripcion TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_fondo),
    UNIQUE KEY uk_clave_fondo (clave_fondo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. SECCIONES
CREATE TABLE SECCIONES (
    id_seccion INT NOT NULL AUTO_INCREMENT,
    id_fondo INT NOT NULL,
    clave_seccion VARCHAR(20) NOT NULL,
    nombre_seccion VARCHAR(150) NOT NULL,
    descripcion TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_seccion),
    CONSTRAINT fk_secciones_fondos FOREIGN KEY (id_fondo) REFERENCES FONDOS (id_fondo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. AREAS
CREATE TABLE AREAS (
    id_area INT NOT NULL AUTO_INCREMENT,
    id_seccion INT NOT NULL,
    clave_area VARCHAR(20) NOT NULL,
    nombre_area VARCHAR(150) NOT NULL,
    responsable VARCHAR(150) NULL DEFAULT NULL,
    telefono VARCHAR(20) NULL DEFAULT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_area),
    UNIQUE KEY uk_clave_area (clave_area),
    CONSTRAINT fk_areas_secciones FOREIGN KEY (id_seccion) REFERENCES SECCIONES (id_seccion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. SERIES_DOCUMENTALES
CREATE TABLE SERIES_DOCUMENTALES (
    id_serie INT NOT NULL AUTO_INCREMENT,
    id_area INT NOT NULL,
    clave_serie VARCHAR(20) NOT NULL,
    nombre_serie VARCHAR(200) NOT NULL,
    descripcion TEXT NULL,
    vigencia_tramite INT NOT NULL DEFAULT 5,
    vigencia_concentracion INT NOT NULL DEFAULT 5,
    destino_final VARCHAR(20) NOT NULL DEFAULT 'BAJA',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_serie),
    CONSTRAINT fk_series_areas FOREIGN KEY (id_area) REFERENCES AREAS (id_area)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. ESTANTES
CREATE TABLE ESTANTES (
    id_estante INT NOT NULL AUTO_INCREMENT,
    codigo_estante VARCHAR(20) NOT NULL,
    descripcion VARCHAR(200) NULL DEFAULT NULL,
    num_niveles INT NOT NULL DEFAULT 5,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_estante),
    UNIQUE KEY uk_codigo_estante (codigo_estante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. NIVELES
CREATE TABLE NIVELES (
    id_nivel INT NOT NULL AUTO_INCREMENT,
    id_estante INT NOT NULL,
    numero_nivel INT NOT NULL,
    descripcion VARCHAR(100) NULL DEFAULT NULL,
    PRIMARY KEY (id_nivel),
    CONSTRAINT fk_niveles_estantes FOREIGN KEY (id_estante) REFERENCES ESTANTES (id_estante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. CAJAS
CREATE TABLE CAJAS (
    id_caja INT NOT NULL AUTO_INCREMENT,
    id_nivel INT NOT NULL,
    codigo_caja VARCHAR(30) NOT NULL,
    capacidad_max INT NOT NULL DEFAULT 10,
    expedientes_actuales INT NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_caja),
    UNIQUE KEY uk_codigo_caja (codigo_caja),
    CONSTRAINT fk_cajas_niveles FOREIGN KEY (id_nivel) REFERENCES NIVELES (id_nivel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. EXPEDIENTES
CREATE TABLE EXPEDIENTES (
    id_expediente INT NOT NULL AUTO_INCREMENT,
    id_serie INT NOT NULL,
    id_caja INT NOT NULL,
    numero_folio VARCHAR(40) NOT NULL,
    asunto VARCHAR(300) NOT NULL,
    fecha_apertura DATE NOT NULL,
    fecha_cierre DATE NULL DEFAULT NULL,
    num_hojas INT NOT NULL DEFAULT 0,
    estado VARCHAR(20) NOT NULL DEFAULT 'ACTIVO',
    observaciones TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_expediente),
    UNIQUE KEY uk_numero_folio (numero_folio),
    CONSTRAINT fk_expedientes_series FOREIGN KEY (id_serie) REFERENCES SERIES_DOCUMENTALES (id_serie),
    CONSTRAINT fk_expedientes_cajas FOREIGN KEY (id_caja) REFERENCES CAJAS (id_caja)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. PRESTAMOS
CREATE TABLE PRESTAMOS (
    id_prestamo INT NOT NULL AUTO_INCREMENT,
    id_expediente INT NOT NULL,
    id_usuario_solicitante INT NOT NULL,
    id_usuario_autoriza INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion_est DATE NOT NULL,
    fecha_devolucion_real DATE NULL DEFAULT NULL,
    estado_prestamo VARCHAR(20) NOT NULL DEFAULT 'ACTIVO',
    observaciones TEXT NULL,
    PRIMARY KEY (id_prestamo),
    CONSTRAINT fk_prestamos_expedientes FOREIGN KEY (id_expediente) REFERENCES EXPEDIENTES (id_expediente),
    CONSTRAINT fk_prestamos_solicitante FOREIGN KEY (id_usuario_solicitante) REFERENCES USUARIOS (id_usuario),
    CONSTRAINT fk_prestamos_autoriza FOREIGN KEY (id_usuario_autoriza) REFERENCES USUARIOS (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. TRANSFERENCIAS
CREATE TABLE TRANSFERENCIAS (
    id_transferencia INT NOT NULL AUTO_INCREMENT,
    id_expediente INT NOT NULL,
    id_caja_origen INT NOT NULL,
    id_caja_destino INT NOT NULL,
    id_usuario INT NOT NULL,
    tipo_transferencia VARCHAR(30) NOT NULL DEFAULT 'INTERNA',
    fecha_transferencia DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT NULL,
    PRIMARY KEY (id_transferencia),
    CONSTRAINT fk_transferencias_expedientes FOREIGN KEY (id_expediente) REFERENCES EXPEDIENTES (id_expediente),
    CONSTRAINT fk_transferencias_origen FOREIGN KEY (id_caja_origen) REFERENCES CAJAS (id_caja),
    CONSTRAINT fk_transferencias_destino FOREIGN KEY (id_caja_destino) REFERENCES CAJAS (id_caja),
    CONSTRAINT fk_transferencias_usuarios FOREIGN KEY (id_usuario) REFERENCES USUARIOS (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. BITACORA
CREATE TABLE BITACORA (
    id_bitacora BIGINT NOT NULL AUTO_INCREMENT,
    id_usuario INT NULL DEFAULT NULL,
    tabla_afectada VARCHAR(60) NOT NULL,
    accion VARCHAR(20) NOT NULL,
    id_registro INT NULL DEFAULT NULL,
    valores_antes JSON NULL DEFAULT NULL,
    valores_despues JSON NULL DEFAULT NULL,
    ip_origen VARCHAR(45) NULL DEFAULT NULL,
    fecha_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_bitacora),
    CONSTRAINT fk_bitacora_usuarios FOREIGN KEY (id_usuario) REFERENCES USUARIOS (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- RECOMENDACIÓN DE ÍNDICES ADICIONALES (Nota 8)
CREATE INDEX idx_expedientes_serie_estado ON EXPEDIENTES(id_serie, estado);
CREATE INDEX idx_expedientes_caja ON EXPEDIENTES(id_caja);
CREATE INDEX idx_prestamos_estado_fecha ON PRESTAMOS(estado_prestamo, fecha_devolucion_est);
CREATE INDEX idx_bitacora_tabla_fecha ON BITACORA(tabla_afectada, fecha_hora);