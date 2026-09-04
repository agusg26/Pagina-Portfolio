----- 1. Crear y seleccionar la base de datos
CREATE DATABASE IF NOT EXISTS portfolio 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;

USE portfolio;

-- 2. Crear la tabla estados
CREATE TABLE IF NOT EXISTS estados (
    estado_id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(80) NOT NULL,
    PRIMARY KEY (estado_id)
) 
-- 3. Crear la tabla materias con su clave foránea
CREATE TABLE IF NOT EXISTS materias (
    materias_id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(80) NOT NULL,
    estado_id INT(11) NOT NULL,
    anio INT(11) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (materias_id),
    KEY estado_id (estado_id),
    CONSTRAINT fk_materias_estados FOREIGN KEY (estado_id) REFERENCES estados (estado_id)
)

-- 4. Insertar los registros en estados
INSERT INTO estados (estado_id, nombre) VALUES
(1, 'Regular'),
(2, 'Libre'),
(3, 'Aprobada');

-- 5. Insertar 4 materias de ejemplo con estado_id = 3
INSERT INTO materias (nombre, estado_id, anio, activo) VALUES
('Programación I', 3, 2024, 1),
('Bases de Datos', 3, 2024, 1),
('Sistemas Operativos', 3, 2025, 1),
('Ingeniería de Software', 3, 2025, 1);