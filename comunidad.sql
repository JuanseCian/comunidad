-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2026 at 11:20 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comunidad`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjuntos`
--

CREATE TABLE `adjuntos` (
  `id` bigint UNSIGNED NOT NULL,
  `entidad_tipo` varchar(50) NOT NULL,
  `entidad_id` bigint UNSIGNED NOT NULL,
  `nombre_original` varchar(255) NOT NULL,
  `nombre_guardado` varchar(255) NOT NULL,
  `ruta` varchar(500) NOT NULL,
  `tipo_mime` varchar(100) DEFAULT NULL,
  `tamaño` bigint DEFAULT NULL,
  `confidencial` tinyint(1) DEFAULT '0',
  `hash_sha256` varchar(64) DEFAULT NULL,
  `subido_por` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adjuntos_descargas`
--

CREATE TABLE `adjuntos_descargas` (
  `id` bigint UNSIGNED NOT NULL,
  `adjunto_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `fecha_descarga` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `atenciones`
--

CREATE TABLE `atenciones` (
  `id` bigint UNSIGNED NOT NULL,
  `persona_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `tipo` enum('visita_domiciliaria','entrevista','llamado','derivacion','seguimiento','otro') NOT NULL DEFAULT 'entrevista',
  `descripcion` text,
  `fecha_atencion` datetime NOT NULL,
  `proxima_atencion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auditoria`
--

CREATE TABLE `auditoria` (
  `id` bigint UNSIGNED NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `registro_id` bigint UNSIGNED NOT NULL,
  `campo` varchar(100) DEFAULT NULL,
  `valor_anterior` text,
  `valor_nuevo` text,
  `accion` enum('create','update','delete') NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barrio`
--

CREATE TABLE `barrio` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `localidad_id` bigint UNSIGNED NOT NULL,
  `zona_barrio_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barrio`
--

INSERT INTO `barrio` (`id`, `nombre`, `localidad_id`, `zona_barrio_id`, `created_at`, `updated_by`, `deleted_by`, `updated_at`, `deleted_at`) VALUES
(1, 'Santa Teresita', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(2, 'Las Mellizas', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(3, 'Azopardo', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(4, 'Yaguaron', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(5, 'San Jorge', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(6, 'Castelli', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(7, 'San Martin', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(8, 'Suizo', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(9, 'Parque Norte', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(10, 'Parque Sarmiento', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(11, '25 de Mayo', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(12, 'Santa Clara', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(13, 'Moreno', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(14, 'Bola de Oro', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(15, 'San Cayetano', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(16, 'Prado Español', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(17, 'Alto Verde', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(18, 'San Pablo', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(19, 'La Loma', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(20, 'Guena', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(21, 'Asonia', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(22, 'Fraga', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(23, 'Martinez', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(24, 'Lares', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(25, 'Jose Ingenieros', 5, 1, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(27, 'Urquiza', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(28, 'Don Bosco', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(29, 'Obrero', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(30, 'Cavalli', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(31, 'Padre D´Amico', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(32, 'Química', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(33, 'Belgrano', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(34, 'San Isidro', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(35, 'Ponce de León', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(36, 'Saavedra', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(37, 'Los Fresnos', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(38, 'Alcoholera', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(39, 'Astul Urquiaga', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(40, 'Super Usina', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(41, 'Golf Club', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(42, 'Oeste', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(43, 'Lanza', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(44, 'Garetto', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(45, 'Evita', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(46, 'Santa Cecilia', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(47, 'Ginés García', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(48, 'ITEC', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(49, 'San Francisco', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(50, 'La Florida', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(51, 'General Mosconi', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(52, 'Mitre', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(53, 'Irigoyen', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(54, 'Villa María', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(55, 'Los Viñedos', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(57, 'Don Americo', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(58, 'Parque Córdoba', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(59, 'Colombo', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(60, 'Malvinas', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(61, 'Virgen del Rosario', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(62, 'Colombini', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(63, '21 de Septiembre', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(64, 'Las Viñas', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(65, 'Pezzi', 5, 3, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(66, 'Las Flores', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(67, 'Juan XXIII', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(68, 'Del Carmen', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(69, 'Primavera', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(70, 'Ponte', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(71, '17 de Octubre', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(72, 'Los Pinos', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(73, 'Savio', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(74, 'Santa Rosa', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(75, '9 de Julio', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(76, 'Virgen de Luján', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(77, 'Trípoli', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(78, 'California', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(79, 'Parque Avamba´e', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(80, 'Avamba´e', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(81, '7 de Septiembre', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(82, 'San Eduardo', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(83, 'Guemes', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(84, 'Plastiversal', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(85, 'Somisa', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(86, 'Sironi', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(87, 'Ayres del Sur', 5, 2, '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(88, 'CENTRO', 5, 4, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(89, 'La Emilia', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(90, 'Villa Riccio', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(91, 'Villa Canto', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(92, 'Villa Campi', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(93, 'Campos Salles', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(94, 'General Rojo', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(95, 'Conesa', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(96, 'Erezcano', 5, 5, '2026-01-19 23:28:01', NULL, NULL, NULL, NULL),
(98, '14 de Abril', 5, 1, NULL, NULL, NULL, NULL, NULL),
(99, '12 de Marzo', 5, 3, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `beneficios`
--

CREATE TABLE `beneficios` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `beneficios`
--

INSERT INTO `beneficios` (`id`, `nombre`) VALUES
(1, 'Bajo Peso'),
(2, 'Mercadería'),
(3, 'Plan Más Vida');

-- --------------------------------------------------------

--
-- Table structure for table `categoria_ocupacional`
--

CREATE TABLE `categoria_ocupacional` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cobertura`
--

CREATE TABLE `cobertura` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `condicion_inactividad`
--

CREATE TABLE `condicion_inactividad` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cud`
--

CREATE TABLE `cud` (
  `id` bigint UNSIGNED NOT NULL,
  `persona_id` bigint UNSIGNED NOT NULL,
  `tiene_cud` tinyint(1) DEFAULT '0',
  `numero_cud` varchar(100) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discapacidad`
--

CREATE TABLE `discapacidad` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domicilio`
--

CREATE TABLE `domicilio` (
  `id` bigint UNSIGNED NOT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `barrio_id` bigint UNSIGNED DEFAULT NULL,
  `calle` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `piso` varchar(5) DEFAULT NULL,
  `dpto` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `domicilio`
--

INSERT INTO `domicilio` (`id`, `municipio`, `localidad`, `barrio_id`, `calle`, `numero`, `piso`, `dpto`) VALUES
(1, NULL, NULL, 33, 'paraguay 1', '384', NULL, NULL),
(2, NULL, NULL, 71, 'paraguay 1', '384', NULL, NULL),
(3, NULL, NULL, 99, 'paraguay 1', '384', NULL, NULL),
(4, NULL, NULL, 78, 'Almafuerte', '2', '2', 'a'),
(5, NULL, NULL, 99, 'Almafuerte', '748', NULL, NULL),
(6, NULL, NULL, 99, NULL, '122', '2', 'A'),
(7, NULL, NULL, 99, 'a', '1', '1', 'a'),
(8, NULL, NULL, 34, 'Almafuerte', '748', NULL, NULL),
(9, NULL, NULL, 63, 'Jujuy', '422', NULL, NULL),
(10, NULL, NULL, 98, 'T', '78', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enfermedades`
--

CREATE TABLE `enfermedades` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enfermedades`
--

INSERT INTO `enfermedades` (`id`, `nombre`) VALUES
(1, 'Desnutricion'),
(2, 'Celiaquia'),
(3, 'inmunosupresion'),
(4, 'Psiquiatrica'),
(5, 'Visceral'),
(6, 'Diabetes'),
(7, 'Hipertension'),
(8, 'Otras'),
(9, 'NS/NR');

-- --------------------------------------------------------

--
-- Table structure for table `estado_civil`
--

CREATE TABLE `estado_civil` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `estado_civil`
--

INSERT INTO `estado_civil` (`id`, `nombre`) VALUES
(1, 'Casado'),
(2, 'Separado de hecho'),
(3, 'Soltero'),
(4, 'Unido de hecho'),
(5, 'Divorciado'),
(6, 'Viudo');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_familiar`
--

CREATE TABLE `grupo_familiar` (
  `id` bigint UNSIGNED NOT NULL,
  `persona_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `documento_id` bigint UNSIGNED DEFAULT NULL,
  `numero_documento` varchar(20) DEFAULT NULL,
  `sexo_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `relacion_titular` varchar(50) DEFAULT NULL,
  `estado_civil_id` bigint UNSIGNED DEFAULT NULL,
  `discapacidad_permanente` tinyint(1) DEFAULT NULL,
  `discapacidad_id` bigint UNSIGNED DEFAULT NULL,
  `discapacidad_tratamiento` tinyint(1) DEFAULT NULL,
  `caratula` varchar(150) DEFAULT NULL,
  `enfermedad_id` bigint UNSIGNED DEFAULT NULL,
  `enfermedad_tratamiento` tinyint(1) DEFAULT NULL,
  `embarazo` tinyint(1) DEFAULT NULL,
  `control_embarazo` tinyint(1) DEFAULT NULL,
  `esquema_vacunacion` tinyint(1) DEFAULT NULL,
  `cobertura_id` bigint UNSIGNED DEFAULT NULL,
  `situacion_ocupacional_id` bigint UNSIGNED DEFAULT NULL,
  `condicion_inactividad_id` bigint UNSIGNED DEFAULT NULL,
  `categoria_ocupacional_id` bigint UNSIGNED DEFAULT NULL,
  `ingresos` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `localidad`
--

CREATE TABLE `localidad` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `codigo_postal` int NOT NULL,
  `provincia_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `localidad`
--

INSERT INTO `localidad` (`id`, `nombre`, `codigo_postal`, `provincia_id`, `created_at`, `updated_at`, `deleted_at`, `updated_by`, `deleted_by`) VALUES
(2, 'La Plata', 1900, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(3, 'Mar del Plata', 7601, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(4, 'Bahía Blanca', 8000, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(5, 'San Nicolás de los Arroyos', 2900, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(6, 'Tandil', 7000, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(7, 'Olavarría', 7400, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(8, 'Junín', 6000, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(9, 'Pergamino', 2700, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(10, 'San Isidro', 1642, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(11, 'Luján', 6700, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(12, 'Zárate', 2800, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(13, 'Campana', 2804, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(14, 'General Pueyrredón', 7600, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(15, 'La Matanza', 1702, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(16, 'San Fernando', 1646, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(17, 'Tres de Febrero', 1651, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(18, 'San Miguel', 1663, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(19, 'Lomas de Zamora', 1832, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(20, 'Quilmes', 1879, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(21, 'Avellaneda', 1870, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(22, 'Berazategui', 1884, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(23, 'Ituzaingó', 1714, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(24, 'Morón', 1708, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(25, 'Florencio Varela', 1888, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(26, 'San Martín', 1650, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(27, 'Vicente López', 1638, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(28, 'San Fernando del Valle de Catamarca', 4700, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(29, 'Ramallo', 2915, 1, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(30, 'Andalgalá', 4740, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(31, 'Belén', 4750, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(32, 'Tinogasta', 5340, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(33, 'Santa María', 4742, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(34, 'Fiambalá', 4733, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(35, 'La Merced', 4753, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(36, 'Aconquija', 4741, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(37, 'San José', 4701, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(38, 'Saujil', 5335, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(39, 'Pomán', 4724, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(40, 'Capayán', 4722, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(41, 'Valle Viejo', 4718, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(42, 'Ancasti', 4747, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(43, 'El Rodeo', 4730, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(44, 'Los Altos', 4709, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(45, 'Puerta de Corral Quemado', 4745, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(46, 'La Puerta', 4703, 2, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(47, 'Resistencia', 3500, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(48, 'Barranqueras', 3503, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(49, 'Fontana', 3506, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(50, 'Presidencia Roque Sáenz Peña', 3700, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(51, 'Villa Ángela', 3541, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(52, 'Charata', 3730, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(53, 'Machagai', 3708, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(54, 'Las Breñas', 3722, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(55, 'Quitilipi', 3540, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(56, 'Tres Isletas', 3535, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(57, 'General Pinedo', 3703, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(58, 'La Leonesa', 3511, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(59, 'Puerto Tirol', 3519, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(60, 'Colonia Benítez', 3513, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(61, 'Puerto Vilelas', 3507, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(62, 'Margarita Belén', 3505, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(63, 'General San Martín', 3542, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(64, 'San Bernardo', 3706, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(65, 'Juan José Castelli', 3705, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(66, 'Coronel Du Graty', 3724, 3, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(67, 'Comodoro Rivadavia', 9000, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(68, 'Puerto Madryn', 9120, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(69, 'Trelew', 9100, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(70, 'Rawson', 9103, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(71, 'Esquel', 9200, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(72, 'Gaiman', 9105, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(73, 'Trevelin', 9203, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(74, 'Dolavon', 9101, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(75, 'Rada Tilly', 9001, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(76, 'Sarmiento', 9005, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(77, 'Lago Puelo', 9211, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(78, 'Río Mayo', 9011, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(79, 'Río Senguer', 9017, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(80, 'Gobernador Costa', 9221, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(81, 'Paso de Indios', 9023, 4, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(82, 'Córdoba', 5000, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(83, 'Villa María', 5900, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(84, 'Río Cuarto', 5800, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(85, 'San Francisco', 2400, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(86, 'Jesús María', 5220, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(87, 'Villa Carlos Paz', 5152, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(88, 'La Falda', 5172, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(89, 'Cosquín', 5166, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(90, 'Alta Gracia', 5186, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(91, 'Bell Ville', 2550, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(92, 'Villa Allende', 5105, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(93, 'Rio Tercero', 5850, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(94, 'Villa Dolores', 5870, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(95, 'Río Ceballos', 5111, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(96, 'Arroyito', 2440, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(97, 'Mina Clavero', 5889, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(98, 'Villa General Belgrano', 5194, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(99, 'Marcos Juárez', 2580, 5, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(100, 'Corrientes', 3400, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(101, 'Goya', 3450, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(102, 'Mercedes', 3471, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(103, 'Ituzaingó', 3302, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(104, 'Santo Tomé', 3340, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(105, 'Curuzú Cuatiá', 3470, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(106, 'Bella Vista', 3452, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(107, 'Esquina', 3229, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(108, 'Empedrado', 3416, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(109, 'Monte Caseros', 3220, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(110, 'Saladas', 3451, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(111, 'Virasoro', 3342, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(112, 'San Lorenzo', 3425, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(113, 'La Cruz', 3226, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(114, 'Paso de los Libres', 3230, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(115, 'Alvear', 3424, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(116, 'San Luis del Palmar', 3407, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(117, 'Berón de Astrada', 3414, 6, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(118, 'Paraná', 3100, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(119, 'Concordia', 3200, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(120, 'Gualeguaychú', 2821, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(121, 'Gualeguay', 2820, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(122, 'Victoria', 3153, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(123, 'Villaguay', 3240, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(124, 'La Paz', 3190, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(125, 'Colón', 3280, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(126, 'Federal', 3181, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(127, 'Chajarí', 3228, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(128, 'Diamante', 3105, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(129, 'San José', 3283, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(130, 'Crespo', 3116, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(131, 'Ramírez', 3113, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(132, 'Rosario del Tala', 3170, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(133, 'San Justo', 3195, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(134, 'Pueblo Belgrano', 3180, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(135, 'Pueblo General Alvear', 3175, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(136, 'Salto', 3224, 7, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(137, 'Mendoza', 5500, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(138, 'San Rafael', 5600, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(139, 'Godoy Cruz', 5501, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(140, 'Luján de Cuyo', 5505, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(141, 'Guaymallén', 5519, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(142, 'Las Heras', 5502, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(143, 'Maipú', 5515, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(144, 'Junín', 5512, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(145, 'San Martín', 5560, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(146, 'Tupungato', 5565, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(147, 'Malargüe', 5613, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(148, 'Rivadavia', 5562, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(149, 'General Alvear', 5623, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(150, 'Villa Nueva', 5516, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(151, 'Las Compuertas', 5547, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(152, 'San Carlos', 5567, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(153, 'San José del Carril', 5537, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(154, 'Rincón del Indio', 5555, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(155, 'La Consulta', 5568, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(156, 'Parque General San Martín', 5518, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(157, 'El Carrizal', 5520, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(158, 'Tunuyán', 5561, 8, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(159, 'Santa Rosa', 6370, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(160, 'General Alvear', 6070, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(161, 'Toay', 6300, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(162, 'Catriló', 6109, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(163, 'General Pico', 6360, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(164, 'Intendente Alvear', 6343, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(165, 'Macachín', 6316, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(166, 'Realicó', 6150, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(167, 'Santo Tomás', 6332, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(168, 'Victorica', 6338, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(169, 'Rancul', 6307, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(170, 'Pico de Orizaba', 6113, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(171, 'Puelches', 6120, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(172, 'Ceballos', 6351, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(173, 'Chamaico', 6340, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(174, 'Lonquimay', 6176, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(175, 'Rucanelo', 6116, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(176, 'Bernasconi', 6100, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(177, 'Chamanal', 6152, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(178, 'Huantraico', 6095, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(179, 'Rivadavia', 6350, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(180, 'La Maruja', 6118, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(181, 'Puelches', 6349, 9, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(182, 'Carhué', 6465, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(183, 'Guaminí', 6461, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(184, 'Daireaux', 6460, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(185, 'Adolfo Alsina', 6462, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(186, 'Salliqueló', 6463, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(187, 'Pihué', 6466, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(188, 'Pehuajó', 6468, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(189, 'Trenque Lauquen', 6469, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(190, 'General Villegas', 6470, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(191, 'Intendente Alvear', 6471, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(192, 'Trevino', 6482, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(193, 'Banderaló', 6483, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(194, 'Guaminí', 6484, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(195, 'Dorrego', 6485, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(196, 'San Miguel del Monte', 6486, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(197, 'General La Madrid', 6487, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(198, 'Tornquist', 6488, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(199, 'Laprida', 6489, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(200, 'Las Flores', 6490, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(201, 'Azul', 6491, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(202, 'Tandil', 6492, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(203, 'Berazategui', 6493, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(204, 'Zárate', 6494, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(205, 'General Alvear', 6495, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(206, 'General La Madrid', 6496, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(207, 'Castelli', 6497, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL),
(208, 'General Alvear', 6498, 10, '2026-01-31 07:22:19', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `niveles_estudio`
--

CREATE TABLE `niveles_estudio` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `niveles_estudio`
--

INSERT INTO `niveles_estudio` (`id`, `nombre`) VALUES
(1, 'Primaria'),
(2, 'Secundaria'),
(3, 'Terciario'),
(4, 'Universidad'),
(5, 'Primario Incompleto'),
(6, 'Secundario Incompleto');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE `permisos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `modulo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `descripcion`, `modulo`) VALUES
(1, 'personas.ver', 'Ver listado y ficha de personas', 'personas'),
(2, 'personas.crear', 'Crear nuevas personas', 'personas'),
(3, 'personas.editar', 'Editar datos de personas existentes', 'personas'),
(4, 'personas.eliminar', 'Eliminar personas', 'personas'),
(5, 'grupo_familiar.ver', 'Ver grupo familiar de una persona', 'personas'),
(6, 'grupo_familiar.editar', 'Editar miembros del grupo familiar', 'personas'),
(7, 'programas.ver', 'Ver programas asignados', 'programas'),
(8, 'programas.asignar', 'Asignar programas a personas', 'programas'),
(9, 'atenciones.ver', 'Ver historial de atenciones', 'atenciones'),
(10, 'atenciones.registrar', 'Registrar nuevas atenciones', 'atenciones'),
(11, 'adjuntos.ver', 'Ver archivos adjuntos', 'archivos'),
(12, 'adjuntos.subir', 'Subir archivos adjuntos', 'archivos'),
(13, 'usuarios.gestionar', 'Crear y gestionar usuarios del sistema', 'sistema'),
(14, 'auditoria.ver', 'Ver log de auditoría de cambios', 'sistema'),
(15, 'sedes.gestionar', 'Crear y editar sedes', 'sistema'),
(16, 'reportes.ver', 'Ver reportes y estadísticas', 'reportes');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

CREATE TABLE `personas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `documento_id` bigint UNSIGNED DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `cuil` varchar(20) DEFAULT NULL,
  `sexo_id` bigint UNSIGNED DEFAULT NULL,
  `domicilio_id` bigint UNSIGNED DEFAULT NULL,
  `provincia_id` bigint UNSIGNED DEFAULT NULL,
  `localidad_id` bigint UNSIGNED DEFAULT NULL,
  `barrio_id` bigint UNSIGNED DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `nivel_estudio_id` bigint UNSIGNED DEFAULT NULL,
  `trabaja` tinyint(1) DEFAULT '0',
  `grupo_sanguineo` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sede_origen_id` bigint UNSIGNED DEFAULT NULL,
  `estado_civil_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `apellido`, `correo`, `fecha_nacimiento`, `documento_id`, `dni`, `cuil`, `sexo_id`, `domicilio_id`, `provincia_id`, `localidad_id`, `barrio_id`, `telefono`, `nivel_estudio_id`, `trabaja`, `grupo_sanguineo`, `created_at`, `updated_at`, `sede_origen_id`, `estado_civil_id`) VALUES
(13, 'Juan Segundo', 'Cian', 'juansegundocian@gmail.com', NULL, 1, '45032239', '20450322394', 1, 8, 1, 5, NULL, '03364318066', 5, 1, 'A+', '2026-04-26 03:22:01', '2026-04-27 02:15:35', NULL, 1),
(14, 'Daniela', 'Abal', 'as@gmail.com', '1999-02-22', 1, '41899221', '27418992218', 2, 9, 1, 5, NULL, '123', 3, 1, 'A+', '2026-04-26 03:51:51', '2026-04-27 02:20:01', NULL, 1),
(15, 'Daniela', 'hernandez', 'H@GMAIL.COM', '2020-10-30', 1, '11', '112', 2, 10, 1, 5, NULL, '445', 1, 1, 'A-', '2026-04-26 04:07:41', '2026-04-26 04:07:41', NULL, 1),
(16, 'pipa', 'pepe', NULL, NULL, 1, '1111', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-26 04:22:17', '2026-04-26 04:22:17', NULL, NULL),
(17, 'la police', 'noono', NULL, NULL, 1, '22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-26 04:26:28', '2026-04-26 04:26:28', NULL, NULL),
(18, 'flaco', 'titi', NULL, NULL, 1, '113', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-26 23:01:57', '2026-04-26 23:01:57', NULL, NULL),
(19, 'ss', 'aa', NULL, NULL, 1, '99', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-27 01:10:38', '2026-04-27 01:10:38', NULL, NULL),
(20, 'Juan Segundo', 'Cian', 'juansegundocian@gmail.com', '2012-11-20', 1, 'q1', NULL, NULL, NULL, NULL, NULL, NULL, '03364318066', NULL, 0, NULL, '2026-04-27 01:15:04', '2026-04-27 01:17:33', NULL, NULL),
(21, 'dd', 'dd', NULL, '2011-11-20', 1, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-27 01:15:39', '2026-04-27 01:15:39', NULL, NULL),
(22, 'll', 'll', NULL, '2003-06-26', 1, '921', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-27 01:16:43', '2026-04-27 01:16:43', NULL, NULL),
(23, 'paap', 'peep', NULL, '2002-11-25', 1, '999', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-27 01:21:50', '2026-04-27 01:21:50', NULL, NULL),
(25, 'qq', 'ss', NULL, '2002-10-30', 1, '1188', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-27 01:26:34', '2026-04-27 01:26:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `persona_beneficio`
--

CREATE TABLE `persona_beneficio` (
  `id` bigint UNSIGNED NOT NULL,
  `persona_id` bigint UNSIGNED NOT NULL,
  `beneficio_id` bigint UNSIGNED NOT NULL,
  `fecha_otorgamiento` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `observaciones` text,
  `registrado_por` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persona_programa`
--

CREATE TABLE `persona_programa` (
  `id` bigint UNSIGNED NOT NULL,
  `persona_id` bigint UNSIGNED NOT NULL,
  `programa_id` bigint UNSIGNED NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `rol` enum('destinatario','tutor') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'destinatario',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `registrado_por` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `persona_programa`
--

INSERT INTO `persona_programa` (`id`, `persona_id`, `programa_id`, `fecha_inicio`, `fecha_fin`, `activo`, `rol`, `observaciones`, `registrado_por`, `created_at`, `updated_at`) VALUES
(1, 14, 1, '2026-04-24', NULL, 1, 'destinatario', 'a', NULL, '2026-04-26 03:59:38', '2026-04-26 03:59:38'),
(2, 15, 4, '2026-04-30', NULL, 1, 'destinatario', 'H', NULL, '2026-04-26 04:07:59', '2026-04-26 04:07:59'),
(3, 16, 4, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-26 04:25:47', '2026-04-26 04:25:47'),
(4, 17, 1, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-26 04:26:33', '2026-04-26 04:26:33'),
(5, 18, 2, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-26 23:02:03', '2026-04-26 23:02:03'),
(6, 20, 2, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-27 01:15:10', '2026-04-27 01:15:10'),
(7, 21, 1, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-27 01:15:47', '2026-04-27 01:15:47'),
(8, 21, 3, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-27 01:15:54', '2026-04-27 01:15:54'),
(9, 22, 1, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-27 01:16:55', '2026-04-27 01:16:55'),
(10, 22, 1, NULL, NULL, 1, 'destinatario', NULL, NULL, '2026-04-27 01:18:26', '2026-04-27 01:18:26'),
(11, 23, 1, NULL, NULL, 1, 'tutor', NULL, NULL, '2026-04-27 01:22:15', '2026-04-27 01:22:15'),
(12, 25, 1, NULL, NULL, 1, 'tutor', NULL, NULL, '2026-04-27 01:26:51', '2026-04-27 01:26:51'),
(13, 13, 1, NULL, NULL, 1, 'tutor', NULL, NULL, '2026-04-27 01:55:44', '2026-04-27 01:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `programas_asistencia`
--

CREATE TABLE `programas_asistencia` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `programas_asistencia`
--

INSERT INTO `programas_asistencia` (`id`, `nombre`) VALUES
(1, 'Envion'),
(2, 'UDI'),
(3, 'Multiespacio'),
(4, 'Guarderia');

-- --------------------------------------------------------

--
-- Table structure for table `provincia`
--

CREATE TABLE `provincia` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `provincia`
--

INSERT INTO `provincia` (`id`, `nombre`, `created_at`, `updated_at`, `updated_by`, `deleted_by`, `deleted_at`) VALUES
(1, 'Buenos Aires', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(2, 'Catamarca', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(3, 'Chaco', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(4, 'Chubut', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(5, 'Córdoba', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(6, 'Corrientes', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(7, 'Entre Ríos', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(8, 'Formosa', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(9, 'Jujuy', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(10, 'La Pampa', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(11, 'La Rioja', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(12, 'Mendoza', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(13, 'Misiones', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(14, 'Neuquén', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(15, 'Río Negro', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(16, 'Salta', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(17, 'San Juan', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(18, 'San Luis', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(19, 'Santa Cruz', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(20, 'Santa Fe', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(21, 'Santiago del Estero', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(22, 'Tierra del Fuego', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL),
(23, 'Tucumán', '2024-10-23 11:25:50', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `created_at`, `updated_at`, `descripcion`) VALUES
(1, 'tecnico', NULL, NULL, 'Visualiza datos'),
(2, 'coordinador', NULL, NULL, 'Visualiza datos y administra sede'),
(3, 'administrador', NULL, NULL, 'Gestiona usuarios e información'),
(4, 'inactivo', NULL, NULL, 'Sin acceso'),
(5, 'programador', NULL, NULL, 'Acceso total sistema');

-- --------------------------------------------------------

--
-- Table structure for table `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `rol_id` bigint UNSIGNED NOT NULL,
  `permiso_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rol_permiso`
--

INSERT INTO `rol_permiso` (`rol_id`, `permiso_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(5, 1),
(2, 2),
(3, 2),
(5, 2),
(2, 3),
(3, 3),
(5, 3),
(3, 4),
(5, 4),
(1, 5),
(2, 5),
(3, 5),
(5, 5),
(2, 6),
(3, 6),
(5, 6),
(1, 7),
(2, 7),
(3, 7),
(5, 7),
(2, 8),
(3, 8),
(5, 8),
(1, 9),
(2, 9),
(3, 9),
(5, 9),
(1, 10),
(2, 10),
(3, 10),
(5, 10),
(1, 11),
(2, 11),
(3, 11),
(5, 11),
(1, 12),
(2, 12),
(3, 12),
(5, 12),
(3, 13),
(5, 13),
(5, 14),
(5, 15),
(2, 16),
(3, 16),
(5, 16);

-- --------------------------------------------------------

--
-- Table structure for table `sedes`
--

CREATE TABLE `sedes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `barrio_id` bigint UNSIGNED DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sexo`
--

CREATE TABLE `sexo` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sexo`
--

INSERT INTO `sexo` (`id`, `nombre`) VALUES
(1, 'Hombre'),
(2, 'Mujer');

-- --------------------------------------------------------

--
-- Table structure for table `situacion_ocupacional`
--

CREATE TABLE `situacion_ocupacional` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `nombre`) VALUES
(1, 'DNI/LC/LE'),
(2, 'Pasaporte'),
(3, 'No Posee'),
(4, 'NS/NR');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` bigint UNSIGNED DEFAULT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nombre`, `apellido`, `email`, `password`, `rol_id`, `sede_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@gmail.com', '$2y$12$02kKXEoepSLtTXByGXq9gu6SPmhPMZQ9AWY5xLT.h5v5uyHHiC2eW', 3, NULL, NULL, '2026-04-15 22:19:26', '2026-04-15 22:19:26'),
(8, 'juanse', 'Juan Segundo', 'Cian', 'juansegundocian@gmail.com', '$2y$12$VGe9zAy3tNkzzeto4I/TY.X8.YrBptmrfLrOtkmpMFfhEbsonDU1y', 4, NULL, NULL, '2026-04-21 16:51:32', '2026-04-21 16:51:32'),
(9, 'pepe', 'pepe', 'pipi', 'pe@gmail.com', '$2y$12$SLck36S.1hliGIO8arwxx.OFZp3uh023w.Muv886goXmSvn0JEmC6', NULL, NULL, NULL, '2026-04-24 16:59:14', '2026-04-24 16:59:14'),
(10, 'dani', 'daniela', 'abal', 'dani@gmail.com', '$2y$12$b/vbv3r90qddImz9aeB58O7zZuPb7DhD4t7sX/QW2thsSgBocl9E.', 2, NULL, NULL, '2026-04-24 17:00:39', '2026-04-24 17:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `zona_barrio`
--

CREATE TABLE `zona_barrio` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `zona_barrio`
--

INSERT INTO `zona_barrio` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'NORTE', NULL, NULL),
(2, 'SUR', NULL, NULL),
(3, 'OESTE', NULL, NULL),
(4, 'CENTRO', NULL, NULL),
(5, 'DELEGACIONES', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjuntos`
--
ALTER TABLE `adjuntos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_adjuntos_entidad` (`entidad_tipo`,`entidad_id`),
  ADD KEY `idx_adjuntos_usuario` (`subido_por`),
  ADD KEY `idx_adjuntos_hash` (`hash_sha256`);

--
-- Indexes for table `adjuntos_descargas`
--
ALTER TABLE `adjuntos_descargas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_descarga_adjunto` (`adjunto_id`),
  ADD KEY `idx_descarga_usuario` (`usuario_id`);

--
-- Indexes for table `atenciones`
--
ALTER TABLE `atenciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_atenciones_persona` (`persona_id`),
  ADD KEY `idx_atenciones_usuario` (`usuario_id`),
  ADD KEY `idx_atenciones_sede` (`sede_id`),
  ADD KEY `idx_atenciones_fecha` (`fecha_atencion`);

--
-- Indexes for table `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_auditoria_tabla` (`tabla`,`registro_id`),
  ADD KEY `idx_auditoria_usuario` (`usuario_id`),
  ADD KEY `idx_auditoria_fecha` (`created_at`);

--
-- Indexes for table `barrio`
--
ALTER TABLE `barrio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_barrio_localidad` (`localidad_id`),
  ADD KEY `idx_barrio_zona` (`zona_barrio_id`),
  ADD KEY `fk_barrio_updated_by` (`updated_by`),
  ADD KEY `fk_barrio_deleted_by` (`deleted_by`),
  ADD KEY `idx_barrio_deleted_at` (`deleted_at`);

--
-- Indexes for table `beneficios`
--
ALTER TABLE `beneficios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categoria_ocupacional`
--
ALTER TABLE `categoria_ocupacional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cobertura`
--
ALTER TABLE `cobertura`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `condicion_inactividad`
--
ALTER TABLE `condicion_inactividad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cud`
--
ALTER TABLE `cud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cud_persona` (`persona_id`),
  ADD KEY `idx_cud_numero` (`numero_cud`);

--
-- Indexes for table `discapacidad`
--
ALTER TABLE `discapacidad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domicilio`
--
ALTER TABLE `domicilio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_domicilio_barrio` (`barrio_id`);

--
-- Indexes for table `enfermedades`
--
ALTER TABLE `enfermedades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupo_familiar`
--
ALTER TABLE `grupo_familiar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_grupo_persona` (`persona_id`),
  ADD KEY `fk_grupo_documento` (`documento_id`),
  ADD KEY `fk_grupo_sexo` (`sexo_id`),
  ADD KEY `fk_grupo_estado_civil` (`estado_civil_id`),
  ADD KEY `fk_grupo_discapacidad` (`discapacidad_id`),
  ADD KEY `fk_grupo_enfermedad` (`enfermedad_id`),
  ADD KEY `fk_grupo_cobertura` (`cobertura_id`),
  ADD KEY `fk_grupo_situacion` (`situacion_ocupacional_id`),
  ADD KEY `fk_grupo_inactividad` (`condicion_inactividad_id`),
  ADD KEY `fk_grupo_categoria` (`categoria_ocupacional_id`),
  ADD KEY `fk_gf_created_by` (`created_by`),
  ADD KEY `fk_gf_updated_by` (`updated_by`),
  ADD KEY `fk_gf_deleted_by` (`deleted_by`);

--
-- Indexes for table `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_localidad_provincia` (`provincia_id`),
  ADD KEY `fk_localidad_updated_by` (`updated_by`),
  ADD KEY `fk_localidad_deleted_by` (`deleted_by`),
  ADD KEY `idx_localidad_deleted_at` (`deleted_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `niveles_estudio`
--
ALTER TABLE `niveles_estudio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_permisos_nombre` (`nombre`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_personas_doc_dni` (`documento_id`,`dni`),
  ADD KEY `idx_personas_dni` (`dni`),
  ADD KEY `idx_personas_apellido` (`apellido`),
  ADD KEY `idx_personas_localidad` (`localidad_id`),
  ADD KEY `idx_personas_barrio` (`barrio_id`),
  ADD KEY `fk_persona_documento` (`documento_id`),
  ADD KEY `fk_persona_sexo` (`sexo_id`),
  ADD KEY `fk_persona_domicilio` (`domicilio_id`),
  ADD KEY `fk_persona_provincia` (`provincia_id`),
  ADD KEY `fk_persona_nivel` (`nivel_estudio_id`),
  ADD KEY `fk_personas_sede` (`sede_origen_id`),
  ADD KEY `idx_personas_nombre_apellido` (`apellido`,`nombre`),
  ADD KEY `fk_personas_estado_civil` (`estado_civil_id`);

--
-- Indexes for table `persona_beneficio`
--
ALTER TABLE `persona_beneficio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pb_persona` (`persona_id`),
  ADD KEY `idx_pb_beneficio` (`beneficio_id`),
  ADD KEY `fk_pb_registrado_por` (`registrado_por`);

--
-- Indexes for table `persona_programa`
--
ALTER TABLE `persona_programa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pp_persona` (`persona_id`),
  ADD KEY `idx_pp_programa` (`programa_id`),
  ADD KEY `fk_pp_registrado_por` (`registrado_por`);

--
-- Indexes for table `programas_asistencia`
--
ALTER TABLE `programas_asistencia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_provincia_updated_by` (`updated_by`),
  ADD KEY `fk_provincia_deleted_by` (`deleted_by`),
  ADD KEY `idx_provincia_deleted_at` (`deleted_at`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`rol_id`,`permiso_id`),
  ADD KEY `fk_rp_permiso` (`permiso_id`);

--
-- Indexes for table `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sedes_barrio` (`barrio_id`);

--
-- Indexes for table `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `situacion_ocupacional`
--
ALTER TABLE `situacion_ocupacional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD UNIQUE KEY `uq_users_username` (`username`),
  ADD KEY `idx_users_rol` (`rol_id`),
  ADD KEY `fk_users_sede` (`sede_id`);

--
-- Indexes for table `zona_barrio`
--
ALTER TABLE `zona_barrio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjuntos`
--
ALTER TABLE `adjuntos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjuntos_descargas`
--
ALTER TABLE `adjuntos_descargas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `atenciones`
--
ALTER TABLE `atenciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barrio`
--
ALTER TABLE `barrio`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `beneficios`
--
ALTER TABLE `beneficios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categoria_ocupacional`
--
ALTER TABLE `categoria_ocupacional`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobertura`
--
ALTER TABLE `cobertura`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `condicion_inactividad`
--
ALTER TABLE `condicion_inactividad`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cud`
--
ALTER TABLE `cud`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discapacidad`
--
ALTER TABLE `discapacidad`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domicilio`
--
ALTER TABLE `domicilio`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `enfermedades`
--
ALTER TABLE `enfermedades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupo_familiar`
--
ALTER TABLE `grupo_familiar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `niveles_estudio`
--
ALTER TABLE `niveles_estudio`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `persona_beneficio`
--
ALTER TABLE `persona_beneficio`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persona_programa`
--
ALTER TABLE `persona_programa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `programas_asistencia`
--
ALTER TABLE `programas_asistencia`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `situacion_ocupacional`
--
ALTER TABLE `situacion_ocupacional`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zona_barrio`
--
ALTER TABLE `zona_barrio`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjuntos`
--
ALTER TABLE `adjuntos`
  ADD CONSTRAINT `fk_adjuntos_user` FOREIGN KEY (`subido_por`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `adjuntos_descargas`
--
ALTER TABLE `adjuntos_descargas`
  ADD CONSTRAINT `fk_descarga_adjunto` FOREIGN KEY (`adjunto_id`) REFERENCES `adjuntos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_descarga_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `atenciones`
--
ALTER TABLE `atenciones`
  ADD CONSTRAINT `fk_atenciones_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_atenciones_sede` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_atenciones_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `fk_auditoria_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `barrio`
--
ALTER TABLE `barrio`
  ADD CONSTRAINT `fk_barrio_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barrio_localidad` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barrio_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barrio_zona` FOREIGN KEY (`zona_barrio_id`) REFERENCES `zona_barrio` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `cud`
--
ALTER TABLE `cud`
  ADD CONSTRAINT `fk_cud_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `domicilio`
--
ALTER TABLE `domicilio`
  ADD CONSTRAINT `fk_domicilio_barrio` FOREIGN KEY (`barrio_id`) REFERENCES `barrio` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `grupo_familiar`
--
ALTER TABLE `grupo_familiar`
  ADD CONSTRAINT `fk_gf_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gf_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gf_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_categoria` FOREIGN KEY (`categoria_ocupacional_id`) REFERENCES `categoria_ocupacional` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_cobertura` FOREIGN KEY (`cobertura_id`) REFERENCES `cobertura` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_discapacidad` FOREIGN KEY (`discapacidad_id`) REFERENCES `discapacidad` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_documento` FOREIGN KEY (`documento_id`) REFERENCES `tipo_documento` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_enfermedad` FOREIGN KEY (`enfermedad_id`) REFERENCES `enfermedades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_estado_civil` FOREIGN KEY (`estado_civil_id`) REFERENCES `estado_civil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_inactividad` FOREIGN KEY (`condicion_inactividad_id`) REFERENCES `condicion_inactividad` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_sexo` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_situacion` FOREIGN KEY (`situacion_ocupacional_id`) REFERENCES `situacion_ocupacional` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `fk_localidad_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_localidad_provincia` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_localidad_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `fk_persona_barrio` FOREIGN KEY (`barrio_id`) REFERENCES `barrio` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_documento` FOREIGN KEY (`documento_id`) REFERENCES `tipo_documento` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_domicilio` FOREIGN KEY (`domicilio_id`) REFERENCES `domicilio` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_localidad` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_nivel` FOREIGN KEY (`nivel_estudio_id`) REFERENCES `niveles_estudio` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_provincia` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_sexo` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_personas_estado_civil` FOREIGN KEY (`estado_civil_id`) REFERENCES `estado_civil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_personas_sede` FOREIGN KEY (`sede_origen_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `persona_beneficio`
--
ALTER TABLE `persona_beneficio`
  ADD CONSTRAINT `fk_pb_beneficio` FOREIGN KEY (`beneficio_id`) REFERENCES `beneficios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pb_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pb_registrado_por` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `persona_programa`
--
ALTER TABLE `persona_programa`
  ADD CONSTRAINT `fk_pp_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pp_programa` FOREIGN KEY (`programa_id`) REFERENCES `programas_asistencia` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pp_registrado_por` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `fk_provincia_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_provincia_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `fk_rp_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rp_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sedes`
--
ALTER TABLE `sedes`
  ADD CONSTRAINT `fk_sedes_barrio` FOREIGN KEY (`barrio_id`) REFERENCES `barrio` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_sede` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
