CREATE TABLE IF NOT EXISTS `materials` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `code` VARCHAR(100) NOT NULL,
    `in_stock` INT NOT NULL DEFAULT 0,
    `unit` VARCHAR(50) NOT NULL DEFAULT 'ks',
    `warehouse` VARCHAR(100) NOT NULL DEFAULT 'Hlavný',
    `status` VARCHAR(50) NOT NULL DEFAULT 'Aktívny',
    `description` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `materials` (`title`, `code`, `in_stock`, `unit`, `warehouse`, `status`, `description`) VALUES
('Oceľový profil 40×40', 'PR-40-40', 124, 'ks', 'Hlavný', 'Aktívny', 'Kvalitný oceľový profil vhodný na konštrukcie.'),
('Doska 18 mm', 'PL-18', 18, 'm²', 'Hlavný', 'Aktívny', 'Drevotriesková doska s hrúbkou 18 mm.'),
('Hliníkový profil 30×30', 'AL-30-30', 42, 'ks', 'Rezervný', 'Rezerva', 'Ľahký hliníkový profil pre modulárne systémy.'),
('Čierne PVC rúrky 16 mm', 'PVC-16', 86, 'ks', 'Hlavný', 'Aktívny', 'PVC rúrky pre elektroinštalácie.'),
('Kábel 3×1,5 mm²', 'KB-3-1.5', 31, 'm', 'Rezervný', 'Rezerva', 'Trojžilový medený inštalačný kábel.'),
('Ochranná fólia 0,5 mm', 'FO-0.5', 12, 'm²', 'Hlavný', 'Aktívny', 'Priehľadná ochranná stavebná fólia.'),
('Ochranné rukavice - veľkosť 8', 'PG-8', 0, 'ks', 'Hlavný', 'Kritický', 'Pracovné ochranné rukavice, momentálne vypredané.');
