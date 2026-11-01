<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */

$currentAction = $_GET['a'] ?? 'index';
$currentController = $_GET['c'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= App\Configuration::APP_NAME ?></title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $link->asset('favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $link->asset('favicons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $link->asset('favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= $link->asset('favicons/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= $link->asset('favicons/favicon.ico') ?>">

    <link rel="stylesheet" href="<?= $link->asset('css/layout.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/material.css') ?>">
</head>
<body>

<div class="app-layout">
    <!-- Bočný navigačný panel (Left Sidebar) -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="<?= $link->url('summary.summary') ?>" class="nav-item <?= ($currentAction === 'summary' || empty($_GET['a'])) && strtolower($currentController) === 'summary' ? 'active' : '' ?>">Prehľad</a>
            <a href="<?= $link->url('material.material') ?>" class="nav-item <?= ($currentAction === 'material' || empty($_GET['a'])) && strtolower($currentController) === 'material' ? 'active' : '' ?>">Materiál</a>
            <a href="<?= $link->url('supplier.supplier') ?>" class="nav-item <?= ($currentAction === 'supplier' || empty($_GET['a'])) && strtolower($currentController) === 'supplier' ? 'active' : '' ?>">Dodávatelia</a>
            <a href="<?= $link->url('settings.settings') ?>" class="nav-item <?= ($currentAction === 'settings' || empty($_GET['a'])) && strtolower($currentController) === 'settings' ? 'active' : '' ?>">Nastavenia</a>

        </nav>
    </aside>

    <!-- Hlavný kontajner aplikácie -->
    <div class="main-wrapper">
        <!-- Horná informačná lišta -->
        <header class="top-header">
            <div class="brand">
                <div class="logo-icon">
                    <img src="<?= $link->asset('images/vaiicko_logo.png') ?>" alt="Logo" width="32" height="32">
                </div>
                <span class="app-title"><?= App\Configuration::APP_NAME ?></span>
            </div>
            <div class="header-right">
                <div class="datetime-info">
                    <span class="label">Dátum</span>
                    <span class="value"><?= date('d. m. Y') ?></span>
                </div>
                <div class="user-profile">
                    <?php if (isset($user) && $user->isLoggedIn()) { ?>
                        <div class="avatar"><?= strtoupper(substr($user->getName(), 0, 2)) ?></div>
                        <div class="user-details">
                            <span class="user-name"><?= e($user->getName()) ?></span>
                            <span class="user-role"><a href="<?= $link->url('auth.logout') ?>" style="color: inherit; text-decoration: none;">Odhlásiť sa</a></span>
                        </div>
                    <?php } else { ?>
                        <div class="avatar">JN</div>
                        <div class="user-details">
                            <span class="user-name">Ján Novák</span>
                            <span class="user-role">Admin</span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </header>

        <!-- Hlavná oblasť pre obsah -->
        <main class="main-content">
            <?= $contentHTML ?>
        </main>
    </div>
</div>

</body>
</html>
