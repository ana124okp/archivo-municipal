<?php
/**
 * SCRIPT SQL - Crear Tablas
 * Ejecutar en phpMyAdmin o con: mysql -u root archivo_municipal < script.sql
 */

-- Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'documentalista', 'consultor') DEFAULT 'consultor',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    telefono VARCHAR(20),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Fondos
CREATE TABLE IF NOT EXISTS fondos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Series
CREATE TABLE IF NOT EXISTS series (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fondo_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fondo_id) REFERENCES fondos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Áreas
CREATE TABLE IF NOT EXISTS areas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estantes
CREATE TABLE IF NOT EXISTS estantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    area_id INT,
    ubicacion VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (area_id) REFERENCES areas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Niveles
CREATE TABLE IF NOT EXISTS niveles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cajas
CREATE TABLE IF NOT EXISTS cajas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    estante_id INT,
    nivel_id INT,
    ubicacion VARCHAR(100),
    capacidad INT DEFAULT 100,
    estado ENUM('disponible', 'llena', 'descartada') DEFAULT 'disponible',
    ocupacion DECIMAL(5,2) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estante_id) REFERENCES estantes(id),
    FOREIGN KEY (nivel_id) REFERENCES niveles(id),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Expedientes
CREATE TABLE IF NOT EXISTS expedientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    folio VARCHAR(50) UNIQUE NOT NULL,
    asunto TEXT NOT NULL,
    serie_id INT,
    caja_id INT,
    area_id INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('activo', 'inactivo', 'prestado', 'transferencia', 'eliminado') DEFAULT 'activo',
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (serie_id) REFERENCES series(id),
    FOREIGN KEY (caja_id) REFERENCES cajas(id),
    FOREIGN KEY (area_id) REFERENCES areas(id),
    INDEX idx_folio (folio),
    INDEX idx_estado (estado),
    INDEX idx_caja (caja_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Préstamos
CREATE TABLE IF NOT EXISTS prestamos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    expediente_id INT NOT NULL,
    usuario_solicitante INT NOT NULL,
    usuario_aprobador INT,
    fecha_solicitud DATE NOT NULL,
    fecha_aprobacion DATE,
    fecha_vencimiento DATE NOT NULL,
    fecha_devolucion DATE,
    estado ENUM('solicitado', 'activo', 'vencido', 'devuelto', 'cancelado') DEFAULT 'solicitado',
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id),
    FOREIGN KEY (usuario_solicitante) REFERENCES usuarios(id),
    FOREIGN KEY (usuario_aprobador) REFERENCES usuarios(id),
    INDEX idx_estado (estado),
    INDEX idx_vencimiento (fecha_vencimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Transferencias
CREATE TABLE IF NOT EXISTS transferencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    expediente_id INT NOT NULL,
    caja_origen_id INT NOT NULL,
    caja_destino_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha_transferencia TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT,
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id),
    FOREIGN KEY (caja_origen_id) REFERENCES cajas(id),
    FOREIGN KEY (caja_destino_id) REFERENCES cajas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bitácora de Auditoría
CREATE TABLE IF NOT EXISTS bitacora (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    accion VARCHAR(50) NOT NULL,
    modulo VARCHAR(50) NOT NULL,
    detalles TEXT,
    ip_address VARCHAR(50),
    user_agent TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id),
    INDEX idx_fecha (fecha),
    INDEX idx_usuario (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos de prueba
INSERT INTO usuarios (nombre, email, password, rol, estado) VALUES
('Admin Usuario', 'admin@tecamachalco.mx', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/LFm', 'admin', 'activo'),
('Documentalista', 'doc@tecamachalco.mx', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/LFm', 'documentalista', 'activo'),
('Consultor', 'consultor@tecamachalco.mx', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/LFm', 'consultor', 'activo');

-- Insertar fondos
INSERT INTO fondos (nombre, descripcion) VALUES
('Fondo General', 'Documentos generales del municipio'),
('Fondo Histórico', 'Documentos históricos y archivos');

-- Insertar series
INSERT INTO series (nombre, descripcion, fondo_id) VALUES
('Reglamentos', 'Reglamentos municipales', 1),
('Acuerdos', 'Acuerdos de cabildo', 1),
('Contratos', 'Contratos y convenios', 1);

-- Insertar áreas
INSERT INTO areas (nombre, descripcion) VALUES
('Administración', 'Área administrativa'),
('Tesorería', 'Área de finanzas'),
('Recursos Humanos', 'Área de RH');

-- Insertar estantes
INSERT INTO estantes (nombre, area_id, ubicacion) VALUES
('Estante A', 1, 'Piso 1, Esquina Nord'),
('Estante B', 1, 'Piso 1, Esquina Sud'),
('Estante C', 2, 'Piso 2, Esquina Este');

-- Insertar niveles
INSERT INTO niveles (nombre, descripcion) VALUES
('Nivel 1', 'Nivel superior'),
('Nivel 2', 'Nivel intermedio'),
('Nivel 3', 'Nivel inferior');

-- Insertar cajas
INSERT INTO cajas (nombre, estante_id, nivel_id, ubicacion, capacidad, estado) VALUES
('Caja A-1', 1, 1, 'Estante A, Nivel 1', 50, 'disponible'),
('Caja A-2', 1, 2, 'Estante A, Nivel 2', 50, 'disponible'),
('Caja B-1', 2, 1, 'Estante B, Nivel 1', 50, 'disponible'),
('Caja C-1', 3, 3, 'Estante C, Nivel 3', 50, 'disponible');
