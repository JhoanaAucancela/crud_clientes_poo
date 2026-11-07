-- Ejecutar en phpMyAdmin (http://localhost/phpmyadmin) -> pestaña SQL
CREATE DATABASE IF NOT EXISTS crud_clientes CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE crud_clientes;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(10) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    telefono VARCHAR(15),
    direccion VARCHAR(200),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO clientes (cedula, nombres, apellidos, email, telefono, direccion) VALUES
('1712345678', 'María', 'López', 'maria.lopez@mail.com', '0991234567', 'Quito, Av. Amazonas'),
('0923456789', 'Carlos', 'Pérez', 'carlos.perez@mail.com', '0987654321', 'Guayaquil, Urdesa');
