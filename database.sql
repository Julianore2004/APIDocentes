-- Crear base de datos
CREATE DATABASE instituto_api_docentes;
USE instituto_api_docentes;

-- ================================
-- TABLA DE USUARIOS (Login Admin)
-- ================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- almacenaremos hash (ej. bcrypt)
    nombre_completo VARCHAR(120) NOT NULL,
    rol ENUM('admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ================================
-- TABLA DE DOCENTES
-- ================================
CREATE TABLE docentes (
    id_docente INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(120),
    telefono VARCHAR(20),
    especialidad VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ================================
-- TABLA DE CURSOS
-- ================================
CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    tipo ENUM('Teoría','Práctica') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ================================
-- RELACIÓN MUCHOS A MUCHOS DOCENTES - CURSOS
-- ================================
CREATE TABLE docente_curso (
    id_docente INT,
    id_curso INT,
    PRIMARY KEY (id_docente, id_curso),
    FOREIGN KEY (id_docente) REFERENCES docentes(id_docente) ON DELETE CASCADE,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso) ON DELETE CASCADE
);

-- ================================
-- TABLA DE HORARIOS
-- ================================
CREATE TABLE horarios (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_docente INT NOT NULL,
    id_curso INT NOT NULL,
    dia ENUM('Lunes','Martes','Miércoles','Jueves','Viernes') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    FOREIGN KEY (id_docente) REFERENCES docentes(id_docente) ON DELETE CASCADE,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ================================
-- INSERTAR ADMIN POR DEFECTO
-- (password: admin123 -> se recomienda encriptar con password_hash)
-- ================================
INSERT INTO usuarios (username, password, nombre_completo) 
VALUES ('admin', '$2y$10$wVv4Jd8Gfn9sU7dNE7cS4uV5P4g7YkSHTDkEhvzE9I7nnqhrhl1hy', 'Administrador General');

-- ================================
-- INSERTAR DOCENTES (ejemplo)
-- ================================
INSERT INTO docentes (nombres, apellidos, especialidad) VALUES
('Kevin Vlaes', 'Bando Gomez', 'Redes e Internet, Diagramación digital, Gestión de sitios web'),
('Jorge Luis', 'Jara Diaz', 'Arquitectura de Computadoras, Análisis y diseño de sistemas, Administración BD, Marketing digital'),
('Christian', 'Alegria Ñaccha', 'Introducción BD, Diseño de interfaces, Programación móvil'),
('Juan Carlos', 'Torres Lozano', 'Fundamentos de programación, Pruebas de software'),
('Andy', 'Cconovilca Ayala', 'Aplicaciones en internet'),
('Anibal', 'Yucra Curo', 'Programación web, Diseño de soluciones web, Inglés'),
('Bill Ulises', 'Ochoa Medina', 'Oportunidades de negocios'),
('Alfonso Alvaro', 'Moreno Marquez', 'Comunicación oral, Solución de problemas');

-- ================================
-- INSERTAR CURSOS (ejemplo reducido)
-- ================================
INSERT INTO cursos (nombre, tipo) VALUES
('Redes e Internet','Teoría'),
('Redes e Internet','Práctica'),
('Arquitectura de Computadoras','Teoría'),
('Arquitectura de Computadoras','Práctica');

-- ================================
-- EJEMPLO DE HORARIOS
-- ================================
INSERT INTO horarios (id_docente, id_curso, dia, hora_inicio, hora_fin) VALUES
(1, 1, 'Lunes', '08:00:00', '08:45:00'),
(1, 2, 'Lunes', '08:45:00', '09:30:00'),
(2, 3, 'Lunes', '08:00:00', '08:45:00'),
(2, 4, 'Lunes', '08:45:00', '09:30:00');

-- ================================
APIDOCENTES:
/APIDOCENTES
│── /config
│    └── database.php
│
│── /controllers
│    └── AuthController.php
│    └── DocenteController.php
│
│── /models
│    └── Usuario.php
│    └── Docente.php
│
│── /views
│    ├── include/
│    │     ├── header.php
│    │     └── footer.php
│    ├── login.php
│    ├── dashboard.php
│    ├── docentes_list.php
│    └── docente_form.php
│
│── /public
│    └── index.php
│    └── css/
│    └── js/
│
└── index.php   # en la raíz (carga login por defecto)


-- ================================
