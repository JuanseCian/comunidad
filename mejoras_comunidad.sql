-- =============================================================================
-- MEJORAS BASE DE DATOS: comunidad
-- Generado: 2026-06-15
-- Aplicar en orden. Cada bloque es independiente y puede ejecutarse por separado.
-- RECOMENDADO: hacer backup antes de correr en producción.
-- =============================================================================


-- =============================================================================
-- MEJORA 1: personas.creado_por_id — corregir tipo y agregar FK
-- El campo era INT sin FK, inconsistente con el resto del sistema.
-- RIESGO: NINGUNO en datos existentes si los IDs ya son válidos o NULL.
-- =============================================================================

ALTER TABLE `personas`
    MODIFY COLUMN `creado_por_id` bigint UNSIGNED DEFAULT NULL,
    ADD CONSTRAINT `fk_personas_creado_por`
        FOREIGN KEY (`creado_por_id`) REFERENCES `users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `personas`
    ADD KEY `idx_personas_creado_por` (`creado_por_id`);


-- =============================================================================
-- MEJORA 2: asistencias — agregar sede_id y programa_id
-- Permite reportar asistencia por sede/programa sin joins extra.
-- No rompe nada existente: columnas nullable, sin NOT NULL.
-- Las vistas actuales NO usan asistencias, así que no hay impacto en ellas.
-- =============================================================================

ALTER TABLE `asistencias`
    ADD COLUMN `sede_id`    bigint UNSIGNED DEFAULT NULL AFTER `persona_id`,
    ADD COLUMN `programa_id` bigint UNSIGNED DEFAULT NULL AFTER `sede_id`,
    ADD CONSTRAINT `fk_asistencias_sede`
        FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_asistencias_programa`
        FOREIGN KEY (`programa_id`) REFERENCES `programas_asistencia` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD KEY `idx_asistencias_sede`    (`sede_id`),
    ADD KEY `idx_asistencias_programa` (`programa_id`);


-- =============================================================================
-- MEJORA 3: familias — agregar soft delete
-- Permite borrar lógicamente familias sin perder historial.
-- No impacta vistas existentes (ninguna filtra por deleted_at en familias).
-- ATENCIÓN: después de esto, el modelo Familia en Laravel necesita SoftDeletes.
-- =============================================================================

ALTER TABLE `familias`
    ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`,
    ADD COLUMN `deleted_by` bigint UNSIGNED DEFAULT NULL AFTER `deleted_at`,
    ADD CONSTRAINT `fk_familias_deleted_by`
        FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD KEY `idx_familias_deleted_at` (`deleted_at`);


-- =============================================================================
-- MEJORA 4: personas — agregar soft delete
-- ATENCIÓN CRÍTICA: varias vistas usan personas sin filtrar deleted_at.
-- Después de esto hay que actualizar las vistas listadas abajo,
-- o agregar un scope global en el modelo Eloquent (recomendado).
-- Vistas afectadas:
--   vw_barrios_mas_activos    → JOIN personas
--   vw_beneficios_por_barrio  → JOIN personas
--   vw_destinatarios_genero   → JOIN personas / FROM personas
--   vw_destinatarios_por_barrio → FROM personas
--   vw_destinatarios_por_zona → JOIN personas
--   vw_familias_por_barrio    → JOIN personas
--   vw_personas_por_barrio    → JOIN personas
--   vw_zonas_mas_activas      → JOIN personas
--   vw_dashboard_general      → SELECT COUNT(*) FROM personas
-- =============================================================================

ALTER TABLE `personas`
    ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`,
    ADD COLUMN `deleted_by` bigint UNSIGNED DEFAULT NULL AFTER `deleted_at`,
    ADD CONSTRAINT `fk_personas_deleted_by`
        FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD KEY `idx_personas_deleted_at` (`deleted_at`);


-- =============================================================================
-- MEJORA 4b: actualizar vistas para respetar soft delete en personas
-- Si preferís manejar esto desde Eloquent con SoftDeletes + scope global,
-- podés omitir este bloque. Pero si las vistas se usan directamente en
-- reportes o dashboards fuera de Laravel, hay que actualizarlas.
-- =============================================================================

CREATE OR REPLACE VIEW `vw_barrios_mas_activos` AS
SELECT `b`.`nombre` AS `barrio`, count(`i`.`id`) AS `total_ingresos`
FROM `ingresos` `i`
JOIN `personas` `p` ON `i`.`persona_id` = `p`.`id` AND `p`.`deleted_at` IS NULL
JOIN `domicilio` `d` ON `p`.`domicilio_id` = `d`.`id`
JOIN `barrio` `b`   ON `d`.`barrio_id` = `b`.`id`
GROUP BY `b`.`nombre`;

CREATE OR REPLACE VIEW `vw_beneficios_por_barrio` AS
SELECT `ba`.`nombre` AS `barrio`, `be`.`nombre` AS `beneficio`, count(`bp`.`id`) AS `total`
FROM `beneficio_persona` `bp`
JOIN `personas` `p`  ON `bp`.`persona_id` = `p`.`id` AND `p`.`deleted_at` IS NULL
JOIN `domicilio` `d` ON `p`.`domicilio_id` = `d`.`id`
JOIN `barrio` `ba`   ON `d`.`barrio_id` = `ba`.`id`
JOIN `beneficios` `be` ON `bp`.`beneficio_id` = `be`.`id`
GROUP BY `ba`.`nombre`, `be`.`nombre`;

CREATE OR REPLACE VIEW `vw_destinatarios_genero` AS
SELECT `gp`.`nombre` AS `genero`, count(`p`.`id`) AS `total`
FROM `personas` `p`
JOIN `genero_percibido` `gp` ON `p`.`genero_percibido_id` = `gp`.`id`
WHERE `p`.`deleted_at` IS NULL
GROUP BY `gp`.`nombre`;

CREATE OR REPLACE VIEW `vw_destinatarios_por_barrio` AS
SELECT `personas`.`barrio_id` AS `barrio_id`, count(0) AS `total`
FROM `personas`
WHERE `personas`.`barrio_id` IS NOT NULL
  AND `personas`.`deleted_at` IS NULL
GROUP BY `personas`.`barrio_id`;

CREATE OR REPLACE VIEW `vw_destinatarios_por_zona` AS
SELECT `zb`.`id` AS `id`, `zb`.`nombre` AS `zona`, count(`p`.`id`) AS `total`
FROM `personas` `p`
JOIN `domicilio` `d`   ON `p`.`domicilio_id` = `d`.`id`
JOIN `barrio` `b`      ON `d`.`barrio_id` = `b`.`id`
JOIN `zona_barrio` `zb` ON `b`.`zona_barrio_id` = `zb`.`id`
WHERE `p`.`deleted_at` IS NULL
GROUP BY `zb`.`id`, `zb`.`nombre`;

CREATE OR REPLACE VIEW `vw_familias_por_barrio` AS
SELECT `b`.`nombre` AS `barrio`, count(distinct `gf`.`familia_id`) AS `total`
FROM `grupo_familiar` `gf`
JOIN `personas` `p`  ON `gf`.`persona_id` = `p`.`id` AND `p`.`deleted_at` IS NULL
JOIN `domicilio` `d` ON `p`.`domicilio_id` = `d`.`id`
JOIN `barrio` `b`    ON `d`.`barrio_id` = `b`.`id`
GROUP BY `b`.`nombre`;

CREATE OR REPLACE VIEW `vw_personas_por_barrio` AS
SELECT `b`.`nombre` AS `barrio`, count(0) AS `total`
FROM `personas` `p`
JOIN `domicilio` `d` ON `p`.`domicilio_id` = `d`.`id`
JOIN `barrio` `b`    ON `d`.`barrio_id` = `b`.`id`
WHERE `p`.`deleted_at` IS NULL
GROUP BY `b`.`nombre`;

CREATE OR REPLACE VIEW `vw_zonas_mas_activas` AS
SELECT `zb`.`nombre` AS `zona`, count(`i`.`id`) AS `total`
FROM `ingresos` `i`
JOIN `personas` `p`    ON `i`.`persona_id` = `p`.`id` AND `p`.`deleted_at` IS NULL
JOIN `domicilio` `d`   ON `p`.`domicilio_id` = `d`.`id`
JOIN `barrio` `b`      ON `d`.`barrio_id` = `b`.`id`
JOIN `zona_barrio` `zb` ON `b`.`zona_barrio_id` = `zb`.`id`
GROUP BY `zb`.`nombre`;

CREATE OR REPLACE VIEW `vw_dashboard_general` AS
SELECT
    (SELECT count(0) FROM `personas`  WHERE `deleted_at` IS NULL) AS `total_personas`,
    (SELECT count(0) FROM `familias`  WHERE `deleted_at` IS NULL) AS `total_familias`,
    (SELECT count(0) FROM `ingresos`)                             AS `total_ingresos`,
    (SELECT count(0) FROM `atenciones`)                           AS `total_atenciones`,
    (SELECT count(0) FROM `beneficio_persona`)                    AS `total_beneficios`;


-- =============================================================================
-- MEJORA 5: adjuntos — índice individual en entidad_tipo
-- El compuesto (entidad_tipo, entidad_id) no cubre queries por tipo solo.
-- Sin riesgo de rotura, es solo agregar un índice.
-- =============================================================================

ALTER TABLE `adjuntos`
    ADD KEY `idx_adjuntos_entidad_tipo` (`entidad_tipo`);


-- =============================================================================
-- FIN
-- =============================================================================
