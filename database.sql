-- Omite esto si ya tienes una base de datos 
CREATE DATABASE IF NOT EXISTS prueba_tecnica;
ALTER DATABASE prueba_tecnica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Cambia el nombre si usas otra base de datos
USE prueba_tecnica;

-- Creación de las tablas

CREATE TABLE IF NOT EXISTS pastel (
	id_pastel INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR (100) NOT NULL,
    descripcion VARCHAR(500),
    preparado_por VARCHAR (100),
    fecha_creacion DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
	creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (fecha_vencimiento >= fecha_creacion)
);


CREATE TABLE IF NOT EXISTS categoria_ingrediente (
	id_categoria_ingrediente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion varchar(500),
	creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ingrediente (
	id_ingrediente INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(500),
    fecha_ingreso DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL, 
    id_categoria_ingrediente INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (fecha_vencimiento >= fecha_ingreso),
	FOREIGN KEY (id_categoria_ingrediente) REFERENCES categoria_ingrediente(id_categoria_ingrediente)
);
CREATE TABLE IF NOT EXISTS pastel_ingredientes (
	id_pastel INT NOT NULL,
    id_ingrediente INT NOT NULL,
    cantidad_ingrediente INT NOT NULL,
    unidad_medida VARCHAR(20) NOT NULL,
	creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_pastel, id_ingrediente),
	FOREIGN KEY (id_pastel) REFERENCES pastel (id_pastel) ON DELETE CASCADE,
    FOREIGN KEY (id_ingrediente) REFERENCES ingrediente (id_ingrediente)
);


