-- Script de creación de tablas para el inventario de dispositivs 

-- Creacion de la tabla DataCenter (7 atributos)
CREATE TABLE Datacenter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    ubicacion VARCHAR(255)  NOT NULL,
    descripcion VARCHAR(255)  NOT NULL,
    deleted TIMESTAMP NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación tabla Rack (7 atributos)
CREATE TABLE Rack (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_datacenter INT NOT NULL,
    numero INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    deleted TIMESTAMP NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_rack_datacenter FOREIGN KEY (id_datacenter)
        REFERENCES Datacenter(id)
        ON DELETE RESTRICT 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación tabla Tipo Dispositivo (5 atributos)
CREATE TABLE TipoDispositivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    deleted TIMESTAMP NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación tabla Fabricante (5 atributos)
CREATE TABLE Fabricante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    deleted TIMESTAMP NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP   
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación tabla Dispositivo (13 atributos)
CREATE TABLE Dispositivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_dispositivo INT NOT NULL,
    id_rack INT NOT NULL,
    id_fabricante INT NOT NULL,
    ubicacion_rack VARCHAR(50)  NOT NULL,
    modelo VARCHAR(255)  NOT NULL,
    nro_serie VARCHAR(255)  NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    estado VARCHAR(50) DEFAULT 'activo',
    observaciones VARCHAR(255) DEFAULT NULL,
    deleted TIMESTAMP NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_dispositivo_rack FOREIGN KEY (id_rack)
        REFERENCES Rack(id)
        ON DELETE RESTRICT 
        ON UPDATE CASCADE,
    CONSTRAINT fk_dispositivo_tipo FOREIGN KEY (id_dispositivo)
        REFERENCES TipoDispositivo(id)
        ON DELETE RESTRICT 
        ON UPDATE CASCADE,
    CONSTRAINT fk_dispositivo_fabricante FOREIGN KEY (id_fabricante)
        REFERENCES Fabricante(id)
        ON DELETE RESTRICT 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

