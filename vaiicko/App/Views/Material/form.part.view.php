<?php

/** @var \App\Models\Material|null $material */
/** @var string[] $errors */

$currentUnit = $material?->getUnit() ?? 'ks';
$currentWarehouse = $material?->getWarehouse() ?? 'Hlavný';
?>

<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger">
        <ul style="margin-left: 1.25rem;">
            <?php foreach ($errors as $error) { ?>
                <li><?= e($error) ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<div class="form-grid">
    <div class="form-group">
        <label for="title" class="form-label">
            Názov materiálu <span class="required">*</span>
        </label>
        <input type="text" name="title" id="title" class="form-control"
               value="<?= e($material?->getTitle() ?? '') ?>"
               placeholder="napr. Oceľový profil 40×40" required>
    </div>

    <div class="form-group">
        <label for="code" class="form-label">
            Kód materiálu <span class="required">*</span>
        </label>
        <input type="text" name="code" id="code" class="form-control"
               value="<?= e($material?->getCode() ?? '') ?>"
               placeholder="napr. PR-40-40" required>
    </div>

    <div class="form-group">
        <label for="in_stock" class="form-label">
            Množstvo na sklade <span class="required">*</span>
        </label>
        <input type="number" name="in_stock" id="in_stock" class="form-control"
               min="0" step="1"
               value="<?= e((string)($material?->getInStock() ?? 0)) ?>" required>
    </div>

    <div class="form-group">
        <label for="min_stock" class="form-label">
            Minimálne množstvo na sklade <span class="required">*</span>
        </label>
        <input type="number" name="min_stock" id="min_stock" class="form-control"
               min="0" step="1"
               value="<?= e((string)($material?->getMinStock() ?? 0)) ?>" required>
    </div>

    <div class="form-group">
        <label for="unit" class="form-label">
            Merná jednotka <span class="required">*</span>
        </label>
        <input type="text" name="unit" id="unit" class="form-control" list="units-list"
               value="<?= e($currentUnit) ?>"
               placeholder="napr. ks, m, m², kg" required>
        <datalist id="units-list">
            <option value="ks">
            <option value="m">
            <option value="m²">
            <option value="m³">
            <option value="kg">
            <option value="l">
            <option value="bal">
        </datalist>
    </div>

    <div class="form-group">
        <label for="warehouse" class="form-label">
            Sklad <span class="required">*</span>
        </label>
        <select name="warehouse" id="warehouse" class="form-control" required>
            <option value="Hlavný" <?= $currentWarehouse === 'Hlavný' ? 'selected' : '' ?>>Hlavný</option>
            <option value="Rezervný" <?= $currentWarehouse === 'Rezervný' ? 'selected' : '' ?>>Rezervný</option>
            <option value="Príručný" <?= $currentWarehouse === 'Príručný' ? 'selected' : '' ?>>Príručný</option>
            <option value="Externý" <?= $currentWarehouse === 'Externý' ? 'selected' : '' ?>>Externý</option>
        </select>
    </div>

    <div class="form-group full-width">
        <label for="description" class="form-label">Popis / Poznámka</label>
        <textarea name="description" id="description" class="form-control"
                  placeholder="Doplňujúce informácie o materiáli..."><?= e($material?->getDescription() ?? '') ?></textarea>
    </div>
</div>
