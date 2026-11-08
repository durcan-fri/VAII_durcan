<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Material $material */
?>

<div class="page-header">
    <h1>Detail materiálu</h1>
    <div style="display: flex; gap: 0.5rem;">
        <a href="<?= $link->url('material.material') ?>" class="btn btn-secondary">
            &larr; Späť na zoznam
        </a>
        <a href="<?= $link->url('material.edit', ['id' => $material->getId()]) ?>" class="btn btn-primary">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Upraviť
        </a>
        <a href="<?= $link->url('material.delete', ['id' => $material->getId()]) ?>" class="btn btn-danger" onclick="return confirm('Naozaj chcete zmazať tento materiál?');">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            Zmazať
        </a>
    </div>
</div>

<section class="card-container">
    <div class="card-toolbar" style="margin-bottom: 1.5rem;">
        <h2><?= e($material->getTitle()) ?></h2>
        <span class="badge <?= e($material->getStatusBadgeClass()) ?>" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">
            <?= e($material->getStatus()) ?>
        </span>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">Kód materiálu</span>
            <span class="detail-value"><?= e($material->getCode()) ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Množstvo na sklade</span>
            <span class="detail-value"><?= e((string)$material->getInStock()) ?> <?= e($material->getUnit()) ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Umiestnenie skladu</span>
            <span class="detail-value"><?= e($material->getWarehouse()) ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Merná jednotka</span>
            <span class="detail-value"><?= e($material->getUnit()) ?></span>
        </div>

        <div class="detail-item full-width">
            <span class="detail-label">Popis / Poznámka</span>
            <div class="detail-value" style="margin-top: 0.25rem; font-weight: normal; color: var(--text-primary); line-height: 1.6;">
                <?= !empty($material->getDescription()) ? nl2br(e($material->getDescription())) : '<em style="color: var(--text-muted);">Bez popisu</em>' ?>
            </div>
        </div>
    </div>
</section>
