
CREATE TABLE tipo_documento (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE sexo (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE provincia (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE localidad (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(60),
  codigo_postal INT NOT NULL,
  provincia_id BIGINT UNSIGNED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  INDEX idx_localidad_provincia (provincia_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE zona_barrio (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE barrio (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  localidad_id BIGINT UNSIGNED NOT NULL,
  zona_barrio_id BIGINT UNSIGNED,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  INDEX idx_barrio_localidad (localidad_id),
  INDEX idx_barrio_zona (zona_barrio_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE niveles_estudio (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE estado_civil (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE situacion_ocupacional (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categoria_ocupacional (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE condicion_inactividad (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE discapacidad (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE enfermedades (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cobertura (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE roles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE programas_asistencia (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255),
  nombre VARCHAR(255) NOT NULL,
  apellido VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  rol_id BIGINT UNSIGNED,
  remember_token VARCHAR(100),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_users_rol (rol_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE domicilio (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  municipio VARCHAR(100),
  localidad VARCHAR(100),
  barrio_id BIGINT UNSIGNED,
  calle VARCHAR(150),
  numero VARCHAR(10),
  piso VARCHAR(5),
  dpto VARCHAR(10),
  INDEX idx_domicilio_barrio (barrio_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE personas (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150),
  apellido VARCHAR(150),
  correo VARCHAR(150),
  fecha_nacimiento DATE,
  documento_id BIGINT UNSIGNED,
  dni VARCHAR(20),
  sexo_id BIGINT UNSIGNED,
  domicilio_id BIGINT UNSIGNED,
  provincia_id BIGINT UNSIGNED,
  localidad_id BIGINT UNSIGNED,
  barrio_id BIGINT UNSIGNED,
  telefono VARCHAR(50),
  nivel_estudio_id BIGINT UNSIGNED,
  trabaja TINYINT(1) DEFAULT 0,
  grupo_sanguineo VARCHAR(5),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_personas_dni (dni),
  INDEX idx_personas_apellido (apellido),
  INDEX idx_personas_localidad (localidad_id),
  INDEX idx_personas_barrio (barrio_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE grupo_familiar (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  persona_id BIGINT UNSIGNED NOT NULL,
  nombre VARCHAR(150) NOT NULL,
  documento_id BIGINT UNSIGNED,
  numero_documento VARCHAR(20),
  sexo_id BIGINT UNSIGNED,
  fecha_nacimiento DATE,
  relacion_titular VARCHAR(50),
  estado_civil_id BIGINT UNSIGNED,
  discapacidad_permanente TINYINT(1),
  discapacidad_id BIGINT UNSIGNED,
  discapacidad_tratamiento TINYINT(1),
  caratula VARCHAR(150),
  enfermedad_id BIGINT UNSIGNED,
  enfermedad_tratamiento TINYINT(1),
  embarazo TINYINT(1),
  control_embarazo TINYINT(1),
  esquema_vacunacion TINYINT(1),
  cobertura_id BIGINT UNSIGNED,
  situacion_ocupacional_id BIGINT UNSIGNED,
  condicion_inactividad_id BIGINT UNSIGNED,
  categoria_ocupacional_id BIGINT UNSIGNED,
  ingresos DECIMAL(10,2),

  INDEX idx_grupo_persona (persona_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cud (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  persona_id BIGINT UNSIGNED NOT NULL,
  tiene_cud TINYINT(1) DEFAULT 0,
  numero_cud VARCHAR(100),
  fecha_emision DATE,
  fecha_vencimiento DATE,
  observaciones TEXT,

  INDEX idx_cud_persona (persona_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE adjuntos (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  entidad_tipo VARCHAR(50) NOT NULL,
  entidad_id BIGINT UNSIGNED NOT NULL,
  nombre_original VARCHAR(255) NOT NULL,
  nombre_guardado VARCHAR(255) NOT NULL,
  ruta VARCHAR(500) NOT NULL,
  tipo_mime VARCHAR(100),
  tamaño BIGINT,
  confidencial TINYINT(1) DEFAULT 0,
  hash_sha256 VARCHAR(64),
  subido_por BIGINT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_adjuntos_entidad (entidad_tipo, entidad_id),
  INDEX idx_adjuntos_usuario (subido_por)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE adjuntos_descargas (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  adjunto_id BIGINT UNSIGNED NOT NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  fecha_descarga TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ip VARCHAR(45),

  INDEX idx_descarga_adjunto (adjunto_id),
  INDEX idx_descarga_usuario (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE migrations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  migration VARCHAR(255) NOT NULL,
  batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE failed_jobs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid VARCHAR(255) NOT NULL,
  connection TEXT NOT NULL,
  queue TEXT NOT NULL,
  payload LONGTEXT NOT NULL,
  exception LONGTEXT NOT NULL,
  failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE password_reset_tokens (
  email VARCHAR(255) PRIMARY KEY,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE personal_access_tokens (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tokenable_type VARCHAR(255) NOT NULL,
  tokenable_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL,
  token VARCHAR(64) NOT NULL,
  abilities TEXT,
  last_used_at TIMESTAMP NULL,
  expires_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






ALTER TABLE users
ADD CONSTRAINT fk_users_rol
FOREIGN KEY (rol_id) REFERENCES roles(id)
ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE localidad
ADD CONSTRAINT fk_localidad_provincia
FOREIGN KEY (provincia_id) REFERENCES provincia(id)
ON DELETE RESTRICT ON UPDATE CASCADE;


ALTER TABLE barrio
ADD CONSTRAINT fk_barrio_localidad
FOREIGN KEY (localidad_id) REFERENCES localidad(id)
ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT fk_barrio_zona
FOREIGN KEY (zona_barrio_id) REFERENCES zona_barrio(id)
ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE domicilio
ADD CONSTRAINT fk_domicilio_barrio
FOREIGN KEY (barrio_id) REFERENCES barrio(id)
ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE personas
ADD CONSTRAINT fk_persona_documento
FOREIGN KEY (documento_id) REFERENCES tipo_documento(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_persona_sexo
FOREIGN KEY (sexo_id) REFERENCES sexo(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_persona_domicilio
FOREIGN KEY (domicilio_id) REFERENCES domicilio(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_persona_provincia
FOREIGN KEY (provincia_id) REFERENCES provincia(id)
ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT fk_persona_localidad
FOREIGN KEY (localidad_id) REFERENCES localidad(id)
ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT fk_persona_barrio
FOREIGN KEY (barrio_id) REFERENCES barrio(id)
ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT fk_persona_nivel
FOREIGN KEY (nivel_estudio_id) REFERENCES niveles_estudio(id)
ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE grupo_familiar
ADD CONSTRAINT fk_grupo_persona
FOREIGN KEY (persona_id) REFERENCES personas(id)
ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_documento
FOREIGN KEY (documento_id) REFERENCES tipo_documento(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_sexo
FOREIGN KEY (sexo_id) REFERENCES sexo(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_estado_civil
FOREIGN KEY (estado_civil_id) REFERENCES estado_civil(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_discapacidad
FOREIGN KEY (discapacidad_id) REFERENCES discapacidad(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_enfermedad
FOREIGN KEY (enfermedad_id) REFERENCES enfermedades(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_cobertura
FOREIGN KEY (cobertura_id) REFERENCES cobertura(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_situacion
FOREIGN KEY (situacion_ocupacional_id) REFERENCES situacion_ocupacional(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_inactividad
FOREIGN KEY (condicion_inactividad_id) REFERENCES condicion_inactividad(id)
ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT fk_grupo_categoria
FOREIGN KEY (categoria_ocupacional_id) REFERENCES categoria_ocupacional(id)
ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE cud
ADD CONSTRAINT fk_cud_persona
FOREIGN KEY (persona_id) REFERENCES personas(id)
ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE adjuntos
ADD CONSTRAINT fk_adjuntos_user
FOREIGN KEY (subido_por) REFERENCES users(id)
ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE adjuntos_descargas
ADD CONSTRAINT fk_descarga_adjunto
FOREIGN KEY (adjunto_id) REFERENCES adjuntos(id)
ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT fk_descarga_usuario
FOREIGN KEY (usuario_id) REFERENCES users(id)
ON DELETE CASCADE ON UPDATE CASCADE;



INSERT INTO `zona_barrio` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'NORTE', NULL, NULL),
(2, 'SUR', NULL, NULL),
(3, 'OESTE', NULL, NULL),
(4, 'CENTRO', NULL, NULL),
(5, 'DELEGACIONES', NULL, NULL);


INSERT INTO `enfermedades` (`id`, `nombre`) VALUES
(1, 'Desnutricion'),
(2, 'Celiaquia'),
(3, 'inmunosupresion'),
(4, 'Psiquiatrica'),
(5, 'Visceral'),
(6, 'Diabetes'),
(7, 'Hipertension'),
(8, 'Otras'),
(9, 'NS/NR'),

INSERT INTO `tipo_documento` (`id`, `nombre`) VALUES
(1, 'DNI/LC/LE'),
(2, 'Pasaporte'),
(3, 'No Posee'),
(4, 'NS/NR');

INSERT INTO `programas_asistencia` (`id`, `nombre`) VALUES
(2, 'Alimentar'),
(1, 'AUH'),
(4, 'Cuota de alimentos'),
(3, 'Fondo de desempleo');

INSERT INTO `barrio` (`id`, `nombre`, `localidad_id`, `zona_barrio_id`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Santa Teresita', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(2, 'Las Mellizas', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(3, 'Azopardo', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(4, 'Yaguaron', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(5, 'San Jorge', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(6, 'Castelli', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(7, 'San Martin', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(8, 'Suizo', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(9, 'Parque Norte', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(10, 'Parque Sarmiento', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(11, '25 de Mayo', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(12, 'Santa Clara', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(13, 'Moreno', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(14, 'Bola de Oro', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(15, 'San Cayetano', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(16, 'Prado Español', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(17, 'Alto Verde', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(18, 'San Pablo', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(19, 'La Loma', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(20, 'Guena', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(21, 'Asonia', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(22, 'Fraga', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(23, 'Martinez', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(24, 'Lares', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(25, 'Jose Ingenieros', 5, 1, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(27, 'Urquiza', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(28, 'Don Bosco', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(29, 'Obrero', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(30, 'Cavalli', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(31, 'Padre D´Amico', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(32, 'Química', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(33, 'Belgrano', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(34, 'San Isidro', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(35, 'Ponce de León', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(36, 'Saavedra', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(37, 'Los Fresnos', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(38, 'Alcoholera', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(39, 'Astul Urquiaga', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(40, 'Super Usina', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(41, 'Golf Club', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(42, 'Oeste', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(43, 'Lanza', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(44, 'Garetto', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(45, 'Evita', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(46, 'Santa Cecilia', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(47, 'Ginés García', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(48, 'ITEC', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(49, 'San Francisco', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(50, 'La Florida', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(51, 'General Mosconi', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(52, 'Mitre', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(53, 'Irigoyen', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(54, 'Villa María', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(55, 'Los Viñedos', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(57, 'Don Americo', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(58, 'Parque Córdoba', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(59, 'Colombo', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(60, 'Malvinas', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(61, 'Virgen del Rosario', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(62, 'Colombini', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(63, '21 de Septiembre', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(64, 'Las Viñas', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(65, 'Pezzi', 5, 3, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(66, 'Las Flores', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(67, 'Juan XXIII', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(68, 'Del Carmen', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(69, 'Primavera', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(70, 'Ponte', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(71, '17 de Octubre', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(72, 'Los Pinos', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(73, 'Savio', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(74, 'Santa Rosa', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(75, '9 de Julio', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(76, 'Virgen de Luján', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(77, 'Trípoli', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(78, 'California', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(79, 'Parque Avamba´e', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(80, 'Avamba´e', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(81, '7 de Septiembre', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(82, 'San Eduardo', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(83, 'Guemes', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(84, 'Plastiversal', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(85, 'Somisa', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(86, 'Sironi', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(87, 'Ayres del Sur', 5, 2, NULL, NULL, '2024-10-23 08:25:50', NULL, NULL),
(88, 'CENTRO', 5, 4, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(89, 'La Emilia', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(90, 'Villa Riccio', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(91, 'Villa Canto', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(92, 'Villa Campi', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(93, 'Campos Salles', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(94, 'General Rojo', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(95, 'Conesa', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(96, 'Erezcano', 5, 5, NULL, NULL, '2026-01-19 20:28:01', NULL, NULL),
(98, '14 de Abril', 5, 1, NULL, NULL, NULL, NULL, NULL),
(99, '12 de Marzo', 5, 3, NULL, NULL, NULL, NULL, NULL);


INSERT INTO `estado_civil` (`id`, `nombre`) VALUES
(1, 'Casado'),
(2, 'Separado de hecho'),
(3, 'Soltero'),
(4, 'Unido de hecho'),
(5, 'Divorciado'),
(6, 'Viudo');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

INSERT INTO `localidad` (`id`, `nombre`, `codigo_postal`, `provincia_id`, `created_at`, `updated_by`, `deleted_by`, `updated_at`, `deleted_at`) VALUES
(2, 'La Plata', 1900, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(3, 'Mar del Plata', 7601, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(4, 'Bahía Blanca', 8000, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(5, 'San Nicolás de los Arroyos', 2900, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(6, 'Tandil', 7000, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(7, 'Olavarría', 7400, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(8, 'Junín', 6000, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(9, 'Pergamino', 2700, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(10, 'San Isidro', 1642, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(11, 'Luján', 6700, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(12, 'Zárate', 2800, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(13, 'Campana', 2804, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(14, 'General Pueyrredón', 7600, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(15, 'La Matanza', 1702, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(16, 'San Fernando', 1646, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(17, 'Tres de Febrero', 1651, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(18, 'San Miguel', 1663, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(19, 'Lomas de Zamora', 1832, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(20, 'Quilmes', 1879, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(21, 'Avellaneda', 1870, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(22, 'Berazategui', 1884, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(23, 'Ituzaingó', 1714, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(24, 'Morón', 1708, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(25, 'Florencio Varela', 1888, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(26, 'San Martín', 1650, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(27, 'Vicente López', 1638, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(28, 'San Fernando del Valle de Catamarca', 4700, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(29, 'Ramallo', 2915, 1, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(30, 'Andalgalá', 4740, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(31, 'Belén', 4750, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(32, 'Tinogasta', 5340, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(33, 'Santa María', 4742, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(34, 'Fiambalá', 4733, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(35, 'La Merced', 4753, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(36, 'Aconquija', 4741, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(37, 'San José', 4701, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(38, 'Saujil', 5335, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(39, 'Pomán', 4724, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(40, 'Capayán', 4722, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(41, 'Valle Viejo', 4718, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(42, 'Ancasti', 4747, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(43, 'El Rodeo', 4730, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(44, 'Los Altos', 4709, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(45, 'Puerta de Corral Quemado', 4745, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(46, 'La Puerta', 4703, 2, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(47, 'Resistencia', 3500, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(48, 'Barranqueras', 3503, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(49, 'Fontana', 3506, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(50, 'Presidencia Roque Sáenz Peña', 3700, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(51, 'Villa Ángela', 3541, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(52, 'Charata', 3730, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(53, 'Machagai', 3708, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(54, 'Las Breñas', 3722, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(55, 'Quitilipi', 3540, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(56, 'Tres Isletas', 3535, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(57, 'General Pinedo', 3703, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(58, 'La Leonesa', 3511, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(59, 'Puerto Tirol', 3519, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(60, 'Colonia Benítez', 3513, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(61, 'Puerto Vilelas', 3507, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(62, 'Margarita Belén', 3505, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(63, 'General San Martín', 3542, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(64, 'San Bernardo', 3706, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(65, 'Juan José Castelli', 3705, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(66, 'Coronel Du Graty', 3724, 3, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(67, 'Comodoro Rivadavia', 9000, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(68, 'Puerto Madryn', 9120, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(69, 'Trelew', 9100, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(70, 'Rawson', 9103, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(71, 'Esquel', 9200, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(72, 'Gaiman', 9105, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(73, 'Trevelin', 9203, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(74, 'Dolavon', 9101, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(75, 'Rada Tilly', 9001, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(76, 'Sarmiento', 9005, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(77, 'Lago Puelo', 9211, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(78, 'Río Mayo', 9011, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(79, 'Río Senguer', 9017, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(80, 'Gobernador Costa', 9221, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(81, 'Paso de Indios', 9023, 4, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(82, 'Córdoba', 5000, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(83, 'Villa María', 5900, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(84, 'Río Cuarto', 5800, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(85, 'San Francisco', 2400, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(86, 'Jesús María', 5220, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(87, 'Villa Carlos Paz', 5152, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(88, 'La Falda', 5172, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(89, 'Cosquín', 5166, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(90, 'Alta Gracia', 5186, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(91, 'Bell Ville', 2550, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(92, 'Villa Allende', 5105, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(93, 'Rio Tercero', 5850, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(94, 'Villa Dolores', 5870, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(95, 'Río Ceballos', 5111, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(96, 'Arroyito', 2440, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(97, 'Mina Clavero', 5889, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(98, 'Villa General Belgrano', 5194, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(99, 'Marcos Juárez', 2580, 5, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(100, 'Corrientes', 3400, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(101, 'Goya', 3450, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(102, 'Mercedes', 3471, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(103, 'Ituzaingó', 3302, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(104, 'Santo Tomé', 3340, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(105, 'Curuzú Cuatiá', 3470, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(106, 'Bella Vista', 3452, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(107, 'Esquina', 3229, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(108, 'Empedrado', 3416, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(109, 'Monte Caseros', 3220, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(110, 'Saladas', 3451, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(111, 'Virasoro', 3342, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(112, 'San Lorenzo', 3425, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(113, 'La Cruz', 3226, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(114, 'Paso de los Libres', 3230, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(115, 'Alvear', 3424, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(116, 'San Luis del Palmar', 3407, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(117, 'Berón de Astrada', 3414, 6, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(118, 'Paraná', 3100, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(119, 'Concordia', 3200, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(120, 'Gualeguaychú', 2821, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(121, 'Gualeguay', 2820, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(122, 'Victoria', 3153, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(123, 'Villaguay', 3240, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(124, 'La Paz', 3190, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(125, 'Colón', 3280, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(126, 'Federal', 3181, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(127, 'Chajarí', 3228, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(128, 'Diamante', 3105, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(129, 'San José', 3283, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(130, 'Crespo', 3116, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(131, 'Ramírez', 3113, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(132, 'Rosario del Tala', 3170, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(133, 'San Justo', 3195, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(134, 'Pueblo Belgrano', 3180, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(135, 'Pueblo General Alvear', 3175, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(136, 'Salto', 3224, 7, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(137, 'Mendoza', 5500, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(138, 'San Rafael', 5600, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(139, 'Godoy Cruz', 5501, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(140, 'Luján de Cuyo', 5505, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(141, 'Guaymallén', 5519, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(142, 'Las Heras', 5502, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(143, 'Maipú', 5515, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(144, 'Junín', 5512, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(145, 'San Martín', 5560, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(146, 'Tupungato', 5565, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(147, 'Malargüe', 5613, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(148, 'Rivadavia', 5562, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(149, 'General Alvear', 5623, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(150, 'Villa Nueva', 5516, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(151, 'Las Compuertas', 5547, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(152, 'San Carlos', 5567, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(153, 'San José del Carril', 5537, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(154, 'Rincón del Indio', 5555, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(155, 'La Consulta', 5568, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(156, 'Parque General San Martín', 5518, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(157, 'El Carrizal', 5520, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(158, 'Tunuyán', 5561, 8, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(159, 'Santa Rosa', 6370, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(160, 'General Alvear', 6070, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(161, 'Toay', 6300, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(162, 'Catriló', 6109, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(163, 'General Pico', 6360, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(164, 'Intendente Alvear', 6343, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(165, 'Macachín', 6316, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(166, 'Realicó', 6150, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(167, 'Santo Tomás', 6332, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(168, 'Victorica', 6338, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(169, 'Rancul', 6307, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(170, 'Pico de Orizaba', 6113, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(171, 'Puelches', 6120, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(172, 'Ceballos', 6351, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(173, 'Chamaico', 6340, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(174, 'Lonquimay', 6176, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(175, 'Rucanelo', 6116, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(176, 'Bernasconi', 6100, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(177, 'Chamanal', 6152, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(178, 'Huantraico', 6095, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(179, 'Rivadavia', 6350, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(180, 'La Maruja', 6118, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(181, 'Puelches', 6349, 9, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(182, 'Carhué', 6465, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(183, 'Guaminí', 6461, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(184, 'Daireaux', 6460, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(185, 'Adolfo Alsina', 6462, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(186, 'Salliqueló', 6463, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(187, 'Pihué', 6466, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(188, 'Pehuajó', 6468, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(189, 'Trenque Lauquen', 6469, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(190, 'General Villegas', 6470, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(191, 'Intendente Alvear', 6471, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(192, 'Trevino', 6482, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(193, 'Banderaló', 6483, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(194, 'Guaminí', 6484, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(195, 'Dorrego', 6485, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(196, 'San Miguel del Monte', 6486, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(197, 'General La Madrid', 6487, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(198, 'Tornquist', 6488, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(199, 'Laprida', 6489, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(200, 'Las Flores', 6490, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(201, 'Azul', 6491, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(202, 'Tandil', 6492, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(203, 'Berazategui', 6493, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(204, 'Zárate', 6494, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(205, 'General Alvear', 6495, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(206, 'General La Madrid', 6496, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(207, 'Castelli', 6497, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL),
(208, 'General Alvear', 6498, 10, '2026-01-31 04:22:19', NULL, NULL, NULL, NULL);

INSERT INTO `niveles_estudio` (`id`, `nombre`) VALUES
(1, 'Primaria'),
(5, 'Primario Incompleto'),
(2, 'Secundaria'),
(3, 'Terciario'),
(6, 'Secundario Incompleto'),
(4, 'Universidad');

INSERT INTO `provincia` (`id`, `nombre`, `created_at`, `updated_by`, `deleted_by`, `updated_at`, `deleted_at`) VALUES
(1, 'Buenos Aires', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(2, 'Catamarca', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(3, 'Chaco', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(4, 'Chubut', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(5, 'Córdoba', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(6, 'Corrientes', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(7, 'Entre Ríos', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(8, 'Formosa', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(9, 'Jujuy', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(10, 'La Pampa', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(11, 'La Rioja', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(12, 'Mendoza', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(13, 'Misiones', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(14, 'Neuquén', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(15, 'Río Negro', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(16, 'Salta', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(17, 'San Juan', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(18, 'San Luis', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(19, 'Santa Cruz', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(20, 'Santa Fe', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(21, 'Santiago del Estero', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(22, 'Tierra del Fuego', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL),
(23, 'Tucumán', '2024-10-23 08:25:50', NULL, NULL, NULL, NULL);

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'tecnico', 'Visualiza datos', NULL, NULL),
(2, 'coordinador', 'Visualiza datos y administra sede', NULL, NULL),
(3, 'administrador', 'Gestiona usuarios e información', NULL, NULL),
(4, 'inactivo', 'Sin acceso', NULL, NULL),
(5, 'programador', 'Acceso total sistema', NULL, NULL);



INSERT INTO `users` (`id`, `username`, `nombre`, `apellido`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `rol`) VALUES
(4, 'admin', 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$02kKXEoepSLtTXByGXq9gu6SPmhPMZQ9AWY5xLT.h5v5uyHHiC2eW', NULL, '2026-04-15 19:19:26', '2026-04-15 19:19:26', 'admin');
