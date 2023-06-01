DROP DATABASE IF EXISTS basicCRUD;
CREATE DATABASE basicCRUD DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

use basicCRUD;

CREATE TABLE alumnos (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  edad INT(3),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);