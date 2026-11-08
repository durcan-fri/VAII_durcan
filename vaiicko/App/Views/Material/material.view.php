<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Material[] $materials */
/** @var string|null $search */
?>

<!-- Nadpis sekcie + Tlačidlo pridať -->
<div class="page-header">
    <h1>Materiál</h1>
    <a href="<?= $link->url('material.create') ?>" class="btn btn-add">
        <span class="plus-icon">+</span> Pridať materiál
    </a>
</div>

<!-- Karta s tabuľkou a filtrami -->
<section class="card-container">
    <div class="card-toolbar">
        <h2>Zoznam materiálov</h2>
        <form method="get" action="<?= $link->url('material.material') ?>" class="toolbar-actions">
            <input type="hidden" name="c" value="material">
            <input type="hidden" name="a" value="material">
            <div class="search-input-wrapper">
                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Hľadať materiál">
            </div>
            <button type="submit" class="btn btn-filter">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtruj
            </button>
            <?php if (!empty($search)) { ?>
                <a href="<?= $link->url('material.material') ?>" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.45rem 0.75rem;">
                    Zrušiť filter
                </a>
            <?php } ?>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (!empty($materials)) { ?>
            <table>
                <thead>
                <tr>
                    <th>Názov materiálu</th>
                    <th>Kód</th>
                    <th>Na sklade</th>
                    <th>Jednotka</th>
                    <th>Sklad</th>
                    <th>Stav</th>
                    <th>Operácie</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($materials as $material) { ?>
                    <tr>
                        <td class="font-bold">
                            <a href="<?= $link->url('material.show', ['id' => $material->getId()]) ?>" style="color: inherit; text-decoration: none;">
                                <?= e($material->getTitle()) ?>
                            </a>
                        </td>
                        <td><?= e($material->getCode()) ?></td>
                        <td><?= e((string)$material->getInStock()) ?></td>
                        <td><?= e($material->getUnit()) ?></td>
                        <td><?= e($material->getWarehouse()) ?></td>
                        <td>
                            <span class="badge <?= e($material->getStatusBadgeClass()) ?>">
                                <?= e($material->getStatus()) ?>
                            </span>
                        </td>
                        <td>
                            <div class="actions-group">
                                <a href="<?= $link->url('material.show', ['id' => $material->getId()]) ?>" class="btn-action" style="text-decoration: none;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    Zobraziť
                                </a>
                                <a href="<?= $link->url('material.edit', ['id' => $material->getId()]) ?>" class="btn-action" style="text-decoration: none;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    Upraviť
                                </a>
                                <a href="<?= $link->url('material.delete', ['id' => $material->getId()]) ?>" class="btn-action btn-action-danger" style="text-decoration: none;" onclick="return confirm('Naozaj chcete zmazať tento materiál?');">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Zmazať
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="empty-state">
                <p>Nenašli sa žiadne materiály<?= !empty($search) ? ' vyhovujúce vyhľadávaniu' : '' ?>.</p>
                <a href="<?= $link->url('material.create') ?>" class="btn btn-primary">
                    <span class="plus-icon">+</span> Pridať nový materiál
                </a>
            </div>
        <?php } ?>
    </div>
</section>
