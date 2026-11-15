CREATE TABLE IF NOT EXISTS `material_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `code` VARCHAR(100) NOT NULL UNIQUE,
    `unit` VARCHAR(50) NOT NULL DEFAULT 'ks',
    `description` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `owned_materials` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `material_type_id` INT NOT NULL,
    `warehouse` VARCHAR(100) NOT NULL DEFAULT 'Hlavný',
    `in_stock` INT NOT NULL DEFAULT 0,
    `min_stock` INT NOT NULL DEFAULT 0,
    `description` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_owned_mat_type` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `suppliers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NULL,
    `phone` VARCHAR(50) NULL,
    `ico` VARCHAR(50) NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `material_supplier` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `material_type_id` INT NOT NULL,
    `supplier_id` INT NOT NULL,
    `price_per_unit` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `delivery_days` INT NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_mat_sup_type` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_mat_sup_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_material_supplier` (`material_type_id`, `supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `material_types` (`id`, `title`, `code`, `unit`, `description`) VALUES
(1, 'Oceľový profil 40×40', 'PR-40-40', 'ks', 'Kvalitný oceľový profil vhodný na konštrukcie.'),
(2, 'Doska 18 mm', 'PL-18', 'm²', 'Drevotriesková doska s hrúbkou 18 mm.'),
(3, 'Hliníkový profil 30×30', 'AL-30-30', 'ks', 'Ľahký hliníkový profil pre modulárne systémy.'),
(4, 'Čierne PVC rúrky 16 mm', 'PVC-16', 'ks', 'PVC rúrky pre elektroinštalácie.'),
(5, 'Kábel 3×1,5 mm²', 'KB-3-1.5', 'm', 'Trojžilový medený inštalačný kábel.'),
(6, 'Ochranná fólia 0,5 mm', 'FO-0.5', 'm²', 'Priehľadná ochranná stavebná fólia.'),
(7, 'Ochranné rukavice - veľkosť 8', 'PG-8', 'ks', 'Pracovné ochranné rukavice, momentálne vypredané.');

INSERT INTO `owned_materials` (`id`, `material_type_id`, `warehouse`, `in_stock`, `min_stock`, `description`) VALUES
(1, 1, 'Hlavný', 124, 20, 'Uskladnené v regáli A1'),
(2, 2, 'Hlavný', 18, 10, 'Uskladnené v regáli B3'),
(3, 3, 'Rezervný', 42, 15, 'Uskladnené v sklade B'),
(4, 4, 'Hlavný', 86, 30, 'Uskladnené v regáli E2'),
(5, 5, 'Rezervný', 31, 20, 'Uskladnené v sklade B'),
(6, 6, 'Hlavný', 12, 10, 'Uskladnené v regáli F1'),
(7, 7, 'Hlavný', 0, 10, 'Momentálne vypredané na sklade');

INSERT INTO `suppliers` (`id`, `name`, `address`, `email`, `phone`, `ico`, `description`) VALUES
(1, 'Oceľ & Kov s.r.o.', 'Priemyselná 14, 010 01 Žilina', 'kontakt@ocelakov.sk', '+421 912 345 678', '12345678', 'Špecialista na oceľové a hliníkové profily a hutnícky materiál.'),
(2, 'Drevomax Slovakia a.s.', 'Bratislavská 45, 949 01 Nitra', 'info@drevomax.sk', '+421 905 111 222', '23456789', 'Dodávateľ drevotrieskových a masívnych dosiek a nábytkárskych materiálov.'),
(3, 'Elektro Inštalacie Trade s.r.o.', 'Vajnorská 120, 831 04 Bratislava', 'obchod@elektrotrade.sk', '+421 948 777 888', '34567890', 'Kompletný sortiment káblov, PVC rúrok a elektroinštalačného materiálu.'),
(4, 'Safety & Build Pro s.r.o.', 'Južná trieda 82, 040 01 Košice', 'objednavky@safetybuild.sk', '+421 911 999 000', '45678901', 'Ochranné pracovné pomôcky, stavebné fólie a bezpečnostné vybavenie.');

INSERT INTO `material_supplier` (`material_type_id`, `supplier_id`, `price_per_unit`, `stock`, `delivery_days`) VALUES
(1, 1, 14.50, 500, 2),
(1, 4, 16.20, 120, 4),
(2, 2, 22.80, 85, 3),
(3, 1, 9.90, 250, 2),
(3, 3, 11.20, 60, 5),
(4, 3, 1.45, 800, 1),
(4, 4, 1.60, 300, 3),
(5, 3, 0.85, 1500, 1),
(6, 4, 3.20, 400, 2),
(6, 2, 3.60, 150, 3),
(7, 4, 2.10, 350, 1),
(7, 1, 2.40, 100, 2);
