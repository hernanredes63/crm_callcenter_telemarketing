-- ======================================================================
-- SCRIPT SQL MAESTRO - CRM GESTIONA (Desde Cero / IDs Numéricos)
-- ======================================================================

SET NAMES utf8mb4;
SET TIME_ZONE = '-04:00';
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

-- ----------------------------------------------------------------------
-- 1. MÓDULO DE SEGURIDAD Y USUARIOS
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario Administrador por defecto (password: password o la que corresponda)
INSERT INTO `users` (`id`, `email`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, 'admin@crm.local', '$2y$10$HSMqzaJRitX0GCrxjRYCp.2gZwPlLVE3a1vP7I8nmudPfPPB8cdHW', '2026-07-17 10:00:19', '2026-07-17 10:24:24');

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `role` enum('admin','supervisor','agente','vendedor','marketing') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_role` (`user_id`,`role`),
  CONSTRAINT `fk_role_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_roles` (`id`, `user_id`, `role`, `created_at`) VALUES
(1, 1, 'admin', '2026-07-17 10:00:19');

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nombre` varchar(190) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_profile_user` (`user_id`),
  CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profiles` (`id`, `user_id`, `nombre`, `email`, `activo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrador', 'admin@crm.local', 1, '2026-07-17 10:00:19', '2026-07-17 10:00:19');


-- ----------------------------------------------------------------------
-- 2. MÓDULO DE PERSONAL OPERATIVO (AGENTES Y VENDEDORES)
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS `agentes`;
CREATE TABLE `agentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(190) NOT NULL,
  `profile_id` int DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_agente_profile` (`profile_id`),
  CONSTRAINT `fk_agente_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `vendedor`;
CREATE TABLE `vendedor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `profile_id` int DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_vend_profile` (`profile_id`),
  CONSTRAINT `fk_vend_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------
-- 3. CATÁLOGOS GEOGRÁFICOS Y DE NEGOCIO
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pais_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paises` (`id`, `nombre`, `created_at`) VALUES
(1, 'Bolivia', '2026-07-17 10:00:19'),
(2, 'Argentina', '2026-07-17 10:00:19'),
(3, 'Chile', '2026-07-17 10:00:19'),
(4, 'Perú', '2026-07-17 10:00:19'),
(5, 'Colombia', '2026-07-17 10:00:19'),
(6, 'México', '2026-07-17 10:00:19'),
(7, 'Ecuador', '2026-07-17 10:00:19'),
(8, 'Uruguay', '2026-07-17 10:00:19'),
(9, 'Paraguay', '2026-07-17 10:00:19'),
(10, 'España', '2026-07-17 10:00:19'),
(11, 'Estados Unidos', '2026-07-17 10:00:19');

DROP TABLE IF EXISTS `ciudad`;
CREATE TABLE `ciudad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `pais_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ciudad_pais` (`pais_id`),
  CONSTRAINT `fk_ciudad_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ciudad` (`id`, `nombre`, `pais_id`) VALUES
(1, 'La Paz', 1),
(2, 'Cochabamba', 1),
(3, 'Santa Cruz', 1),
(4, 'Sucre', 1),
(5, 'Oruro', 1),
(6, 'Potosí', 1),
(7, 'Tarija', 1),
(8, 'Beni', 1),
(9, 'Pando', 1),
(10, 'Buenos Aires', 2),
(11, 'Santiago', 3),
(12, 'Lima', 4),
(13, 'Bogotá', 5),
(14, 'Ciudad de México', 6),
(15, 'Quito', 7),
(16, 'Montevideo', 8),
(17, 'Asunción', 9),
(18, 'Madrid', 10),
(19, 'Miami', 11),
(20, 'New York', 11),
(21, 'Washington D.C.', 11);

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_empresa_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `empresas` (`id`, `nombre`, `created_at`) VALUES
(1, 'NM', '2026-07-20 15:06:10'),
(2, 'Mi lote', '2026-07-20 15:06:01');

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE `proyectos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(190) NOT NULL,
  `empresa_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_proy_empresa` (`empresa_id`),
  CONSTRAINT `fk_proy_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `campanas`;
CREATE TABLE `campanas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(190) NOT NULL,
  `empresa_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_camp_empresa` (`empresa_id`),
  CONSTRAINT `fk_camp_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `canales`;
CREATE TABLE `canales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_canal_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `canales` (`id`, `nombre`, `created_at`) VALUES
(1, 'Facebook', '2026-07-17 10:00:19'),
(2, 'Instagram', '2026-07-17 10:00:19'),
(3, 'WhatsApp', '2026-07-17 10:00:19'),
(4, 'TikTok', '2026-07-17 10:00:19'),
(5, 'Referido', '2026-07-17 10:00:19'),
(6, 'Web', '2026-07-17 10:00:19'),
(7, 'Google Ads', '2026-07-17 10:00:19'),
(8, 'Oficina central', '2026-07-25 17:33:45'),
(9, 'Línea 800', '2026-07-25 17:34:57');

DROP TABLE IF EXISTS `mql_status`;
CREATE TABLE `mql_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nivel` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_mql_nivel` (`nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mql_status` (`id`, `nivel`, `created_at`) VALUES
(1, 'MQL1 - ALTO', '2026-07-17 10:00:19'),
(2, 'MQL2 - MALO', '2026-07-17 10:00:19'),
(3, 'MQL3 - MEDIO', '2026-07-17 10:00:19'),
(4, 'MQL4', '2026-07-17 10:00:19');


-- ----------------------------------------------------------------------
-- 4. MÓDULO CENTRAL OPERATIVO (LEADS Y LEADS REDES)
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(190) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `ciudad_id` int DEFAULT NULL,
  `empresa_id` int DEFAULT NULL,
  `proyecto_id` int DEFAULT NULL,
  `campana_id` int DEFAULT NULL,
  `canal_id` int DEFAULT NULL,
  `mql_id` int DEFAULT NULL,
  `temperatura` enum('frio','tibio','caliente') NOT NULL DEFAULT 'frio',
  `tipo_pago` enum('Contado','Plazo') DEFAULT NULL,
  `comentario` text,
  `agente_id` int DEFAULT NULL,
  `vendedor_id` int DEFAULT NULL,
  `derivado_ventas` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_derivado_ventas` datetime DEFAULT NULL,
  `fecha_lead` date NOT NULL DEFAULT (curdate()),
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_leads_agente` (`agente_id`),
  KEY `idx_leads_fecha_lead` (`fecha_lead`),
  KEY `idx_leads_derivado` (`derivado_ventas`,`fecha_derivado_ventas`),
  CONSTRAINT `fk_lead_agente` FOREIGN KEY (`agente_id`) REFERENCES `agentes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_campana` FOREIGN KEY (`campana_id`) REFERENCES `campanas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_canal` FOREIGN KEY (`canal_id`) REFERENCES `canales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_ciudad` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudad` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_mql` FOREIGN KEY (`mql_id`) REFERENCES `mql_status` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lead_vendedor` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedor` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `leads_redes`;
CREATE TABLE `leads_redes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(190) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `ciudad_id` int DEFAULT NULL,
  `empresa_id` int DEFAULT NULL,
  `proyecto_id` int DEFAULT NULL,
  `campana_id` int DEFAULT NULL,
  `canal_id` int DEFAULT NULL,
  `mql_id` int DEFAULT NULL,
  `temperatura` enum('frio','tibio','caliente') NOT NULL DEFAULT 'frio',
  `tipo_pago` enum('Contado','Plazo') DEFAULT NULL,
  `comentario` text,
  `agente_id` int DEFAULT NULL,
  `fecha_lead` date NOT NULL DEFAULT (curdate()),
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lr_fecha` (`fecha_lead`),
  KEY `idx_lr_agente` (`agente_id`),
  CONSTRAINT `fk_lr_agente` FOREIGN KEY (`agente_id`) REFERENCES `agentes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lr_campana` FOREIGN KEY (`campana_id`) REFERENCES `campanas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lr_canal` FOREIGN KEY (`canal_id`) REFERENCES `canales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lr_ciudad` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudad` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lr_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lr_mql` FOREIGN KEY (`mql_id`) REFERENCES `mql_status` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lr_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------
-- 5. TABLAS HIJAS: TELÉFONOS NORMALIZADOS (1:N)
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS `lead_telefonos`;
CREATE TABLE `lead_telefonos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `tipo` enum('whatsapp','movil','casa','trabajo') NOT NULL DEFAULT 'movil',
  `es_principal` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lead_tel_numero` (`telefono`),
  KEY `fk_tel_lead` (`lead_id`),
  CONSTRAINT `fk_tel_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `leads_redes_telefonos`;
CREATE TABLE `leads_redes_telefonos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_redes_id` int NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `tipo` enum('whatsapp','movil','casa','trabajo') NOT NULL DEFAULT 'whatsapp',
  `es_principal` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lr_tel_numero` (`telefono`),
  KEY `fk_tel_lr` (`lead_redes_id`),
  CONSTRAINT `fk_tel_lr` FOREIGN KEY (`lead_redes_id`) REFERENCES `leads_redes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------
-- 6. MÓDULO DE SEGUIMIENTOS Y CIERRE DE VENTAS
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS `seguimientos`;
CREATE TABLE `seguimientos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int NOT NULL,
  `iteracion` tinyint NOT NULL,
  `estado` enum('contesto','apagado','colgo','ocupado','no_contesta','no_le_interesa','se_envio_mensaje') NOT NULL,
  `comentario` text,
  `fecha_proximo_contacto` datetime DEFAULT NULL,
  `google_event_id` varchar(120) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_lead_iter` (`lead_id`,`iteracion`),
  CONSTRAINT `fk_seg_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_iter` CHECK ((`iteracion` between 1 and 7))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `seguimientos_redes`;
CREATE TABLE `seguimientos_redes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int NOT NULL,
  `iteracion` tinyint NOT NULL,
  `estado` enum('contesto','apagado','colgo','ocupado','no_contesta','no_le_interesa','se_envio_mensaje') NOT NULL,
  `comentario` text,
  `fecha_proximo_contacto` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_lr_iter` (`lead_id`,`iteracion`),
  CONSTRAINT `fk_segr_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads_redes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_iter_r` CHECK ((`iteracion` between 1 and 7))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `seguimiento_ventas`;
CREATE TABLE `seguimiento_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int NOT NULL,
  `vendedor_id` int NOT NULL,
  `estado` enum('pendiente','visita','venta','perdido') NOT NULL DEFAULT 'pendiente',
  `comentario` text,
  `fecha_visita` date DEFAULT NULL,
  `fecha_venta` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sv_lead_fk` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sv_vend_fk` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;