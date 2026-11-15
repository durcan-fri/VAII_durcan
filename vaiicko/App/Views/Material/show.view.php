<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Material $material */
/** @var \App\Models\MaterialSupplier[]|null $materialSuppliers */

$materialSuppliers = $materialSuppliers ?? $material->getMaterialSuppliers();
$matType = $material->getMaterialType();
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

<section class="card-container" style="margin-bottom: 1.5rem;">
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
            <span class="detail-label">Min. množstvo na sklade</span>
            <span class="detail-value"><?= e((string)($material->getMinStock() ?? 0)) ?> <?= e($material->getUnit()) ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Umiestnenie skladu</span>
            <span class="detail-value"><?= e($material->getWarehouse()) ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Merná jednotka</span>
            <span class="detail-value"><?= e($material->getUnit()) ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Popis typu materiálu</span>
            <span class="detail-value"><?= !empty($material->getTypeDescription()) ? e($material->getTypeDescription()) : '<em style="color: var(--text-muted);">Bez popisu</em>' ?></span>
        </div>

        <div class="detail-item full-width">
            <span class="detail-label">Poznámka k uskladneniu</span>
            <div class="detail-value" style="margin-top: 0.25rem; font-weight: normal; color: var(--text-primary); line-height: 1.6;">
                <?= !empty($material->getDescription()) ? nl2br(e($material->getDescription())) : '<em style="color: var(--text-muted);">Bez poznámky</em>' ?>
            </div>
        </div>
    </div>
</section>

<!-- Rozšírené informácie: Dodávatelia materiálu -->
<section class="card-container">
    <div class="card-toolbar">
        <div>
            <h2>Rozšírené informácie &bull; Dodávatelia materiálu</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">
                Prehľad všetkých externých dodávateľov, ktorí majú materiál k dispozícii s aktuálnymi cenami a skladovými zásobami.
            </p>
        </div>
    </div>

    <div class="table-wrapper">
        <?php if (!empty($materialSuppliers)) { ?>
            <table>
                <thead>
                <tr>
                    <th>Dodávateľ</th>
                    <th>Adresa</th>
                    <th>Kontakt</th>
                    <th>Cena za jednotku (€)</th>
                    <th>Skladom u dodávateľa</th>
                    <th>Dodacia lehota</th>
                    <th>Operácie</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($materialSuppliers as $ms) {
                    $supplier = $ms->getSupplier();
                    if (!$supplier) continue;
                ?>
                    <tr>
                        <td class="font-bold">
                            <a href="<?= $link->url('supplier.show', ['id' => $supplier->getId()]) ?>" style="color: inherit; text-decoration: none;">
                                <?= e($supplier->getName()) ?>
                            </a>
                        </td>
                        <td><?= e($supplier->getAddress()) ?></td>
                        <td>
                            <?php if (!empty($supplier->getEmail())) { ?>
                                <div><a href="mailto:<?= e($supplier->getEmail()) ?>" style="color: var(--green-primary); text-decoration: none; font-size: 0.85rem;"><?= e($supplier->getEmail()) ?></a></div>
                            <?php } ?>
                            <?php if (!empty($supplier->getPhone())) { ?>
                                <div style="color: var(--text-muted); font-size: 0.85rem;"><?= e($supplier->getPhone()) ?></div>
                            <?php } ?>
                            <?php if (empty($supplier->getEmail()) && empty($supplier->getPhone())) { ?>
                                <span style="color: var(--text-muted);">-</span>
                            <?php } ?>
                        </td>
                        <td>
                            <strong style="color: var(--green-primary); font-size: 0.95rem;">
                                <?= e($ms->getFormattedPrice()) ?> / <?= e($material->getUnit()) ?>
                            </strong>
                        </td>
                        <td>
                            <span class="badge badge-active" style="font-size: 0.85rem;">
                                <?= number_format($ms->getStock() ?? 0, 0, ',', ' ') ?> <?= e($material->getUnit()) ?>
                            </span>
                        </td>
                        <td>
                            <?= e((string)($ms->getDeliveryDays() ?? 1)) ?> <?= ($ms->getDeliveryDays() ?? 1) === 1 ? 'deň' : (($ms->getDeliveryDays() ?? 1) >= 2 && ($ms->getDeliveryDays() ?? 1) <= 4 ? 'dni' : 'dní') ?>
                        </td>
                        <td>
                            <div class="actions-group">
                                <a href="<?= $link->url('supplier.show', ['id' => $supplier->getId()]) ?>" class="btn-action" style="text-decoration: none;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    Detail dodávateľa
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="empty-state">
                <p>K tomuto materiálu zatiaľ nie sú evidovaní žiadni dodávatelia.</p>
            </div>
        <?php } ?>
    </div>
</section>
