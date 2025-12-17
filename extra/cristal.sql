# cristal_db_script.txt (actualizado sin razón social)

-- =============================================
-- BASE DE DATOS: CRISTAL (MARIADB)
-- =============================================
-- Este script crea toda la estructura completa para el sistema:
-- usuarios, roles, clientes, teléfonos, direcciones, fotos,
-- testimonios y promociones del mes.
-- =============================================
CREATE DATABASE cristal;

USE cristal;

-- =========================
-- ELIMINAR SI EXISTEN
-- =========================
DROP VIEW IF EXISTS vista_cliente_contacto;
DROP TABLE IF EXISTS promociones_fotos;
DROP TABLE IF EXISTS promociones;
DROP TABLE IF EXISTS testimonios;
DROP TABLE IF EXISTS cliente_fotos;
DROP TABLE IF EXISTS cliente_direcciones;
DROP TABLE IF EXISTS cliente_telefonos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS sessions;

-- =========================
-- TABLA: SESSIONS (Laravel)
-- =========================
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

-- =========================
-- TABLA: ROLES
-- =========================
CREATE TABLE roles (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO roles (nombre) VALUES ('superadmin'), ('administrador'), ('vendedor');

-- =========================
-- TABLA: USUARIOS
-- =========================
CREATE TABLE usuarios (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
apellido VARCHAR(100) NOT NULL,
correo VARCHAR(100) NOT NULL UNIQUE,
telefono VARCHAR(20),
password VARCHAR(255) NOT NULL,
rol_id INT NOT NULL,
estado TINYINT(1) DEFAULT 1,
creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- =========================
-- TABLA: CLIENTES
-- =========================
CREATE TABLE clientes (
id INT AUTO_INCREMENT PRIMARY KEY,
nombres VARCHAR(100) NOT NULL,
apellidos VARCHAR(100) NOT NULL,
cedula_identidad VARCHAR(200),
correo VARCHAR(120),
creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- TABLA: CLIENTE_TELEFONOS
-- =========================
CREATE TABLE cliente_telefonos (
id INT AUTO_INCREMENT PRIMARY KEY,
cliente_id INT NOT NULL,
telefono VARCHAR(20) NOT NULL,
descripcion VARCHAR(100),
es_principal TINYINT(1) DEFAULT 0,
FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- =========================
-- TABLA: CLIENTE_DIRECCIONES
-- =========================
CREATE TABLE cliente_direcciones (
id INT AUTO_INCREMENT PRIMARY KEY,
cliente_id INT NOT NULL,
zona VARCHAR(255) NOT NULL,
calle VARCHAR(255) NOT NULL,
coordenadas VARCHAR(100),
referencia VARCHAR(255),
es_principal TINYINT(1) DEFAULT 0,
FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- =========================
-- TABLA: CLIENTE_FOTOS
-- =========================
CREATE TABLE cliente_fotos (
id INT AUTO_INCREMENT PRIMARY KEY,
cliente_id INT NOT NULL,
ruta_foto VARCHAR(255) NOT NULL,
descripcion VARCHAR(100),
orden TINYINT UNSIGNED,
FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- =========================
-- TABLA: TESTIMONIOS
-- =========================
CREATE TABLE testimonios (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100),
comentario TEXT,
fuente VARCHAR(50),
fecha_publicacion DATE,
visible BOOLEAN DEFAULT 1,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- TABLA: PROMOCIONES DEL MES
-- =========================
CREATE TABLE promociones (
id INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(150) NOT NULL,
descripcion TEXT,
precio DECIMAL(10,2),
fecha_inicio DATE,
fecha_fin DATE,
creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE promociones_fotos (
id INT AUTO_INCREMENT PRIMARY KEY,
promo_id INT NOT NULL,
ruta_foto VARCHAR(255) NOT NULL,
FOREIGN KEY (promo_id) REFERENCES promociones(id)
);

-- =========================
-- VISTA: vista_cliente_contacto
-- =========================
CREATE VIEW vista_cliente_contacto AS
SELECT
c.id AS cliente_id,
c.nombres,
c.apellidos,
c.correo,
t.telefono AS telefono_principal,
CONCAT(d.zona, ' ', d.calle) AS direccion_principal,
d.coordenadas AS coordenadas_principal
FROM clientes c
LEFT JOIN cliente_telefonos t ON t.cliente_id = c.id AND t.es_principal = 1
LEFT JOIN cliente_direcciones d ON d.cliente_id = c.id AND d.es_principal = 1;

