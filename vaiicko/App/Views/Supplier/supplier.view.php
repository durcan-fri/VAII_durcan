<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Supplier[] $suppliers */
/** @var string|null $search */
?>

<!-- Nadpis sekcie + Tlačidlo pridať -->
<div class="page-header">
    <h1>Dodávatelia</h1>
    <a href="<?= $link->url('supplier.create') ?>" class="btn btn-add">
        <span class="plus-icon">+</span> Pridať dodávateľa
    </a>
</div>

<!-- Karta s tabuľkou a filtrami -->
<section class="card-container">
    <div class="card-toolbar">
        <h2>Zoznam dodávateľov</h2>
        <form method="get" action="<?= $link->url('supplier.supplier') ?>" class="toolbar-actions">
            <input type="hidden" name="c" value="supplier">
            <input type="hidden" name="a" value="supplier">
            <div class="search-input-wrapper">
                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Hľadať dodávateľa">
            </div>
            <button type="submit" class="btn btn-filter">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtruj
            </button>
            <?php if (!empty($search)) { ?>
                <a href="<?= $link->url('supplier.supplier') ?>" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.45rem 0.75rem;">
                    Zrušiť filter
                </a>
            <?php } ?>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (!empty($suppliers)) { ?>
            <table>
                <thead>
                <tr>
                    <th>Názov dodávateľa</th>
                    <th>Adresa</th>
                    <th>IČO</th>
                    <th>Kontakt</th>
                    <th>Dodávané materiály</th>
                    <th>Skladom celkom</th>
                    <th>Operácie</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($suppliers as $supplier) { ?>
                    <tr>
                        <td class="font-bold">
                            <a href="<?= $link->url('supplier.show', ['id' => $supplier->getId()]) ?>" style="color: inherit; text-decoration: none;">
                                <?= e($supplier->getName()) ?>
                            </a>
                        </td>
                        <td><?= e($supplier->getAddress()) ?></td>
                        <td><?= !empty($supplier->getIco()) ? e($supplier->getIco()) : '<span style="color: var(--text-muted);">-</span>' ?></td>
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
                            <span class="badge badge-active" style="font-size: 0.8rem;">
                                <?= $supplier->getSuppliedMaterialsCount() ?> <?= $supplier->getSuppliedMaterialsCount() === 1 ? 'položka' : ($supplier->getSuppliedMaterialsCount() >= 2 && $supplier->getSuppliedMaterialsCount() <= 4 ? 'položky' : 'položiek') ?>
                            </span>
                        </td>
                        <td>
                            <strong><?= number_format($supplier->getTotalStock(), 0, ',', ' ') ?></strong>
                        </td>
                        <td>
                            <div class="actions-group">
                                <a href="<?= $link->url('supplier.show', ['id' => $supplier->getId()]) ?>" class="btn-action" style="text-decoration: none;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    Zobraziť
                                </a>
                                <a href="<?= $link->url('supplier.edit', ['id' => $supplier->getId()]) ?>" class="btn-action" style="text-decoration: none;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    Upraviť
                                </a>
                                <a href="<?= $link->url('supplier.delete', ['id' => $supplier->getId()]) ?>" class="btn-action btn-action-danger" style="text-decoration: none;" onclick="return confirm('Naozaj chcete zmazať tohto dodávateľa?');">
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
                <p>Nenašli sa žiadni dodávatelia<?= !empty($search) ? ' vyhovujúci vyhľadávaniu' : '' ?>.</p>
                <a href="<?= $link->url('supplier.create') ?>" class="btn btn-primary">
                    <span class="plus-icon">+</span> Pridať nového dodávateľa
                </a>
            </div>
        <?php } ?>
    </div>
</section>
