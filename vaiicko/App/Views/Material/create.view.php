<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Material $material */
/** @var string[] $errors */
?>

<div class="page-header">
    <h1>Pridať nový materiál</h1>
    <a href="<?= $link->url('material.material') ?>" class="btn btn-secondary">
        &larr; Späť na zoznam
    </a>
</div>

<section class="card-container">
    <div class="card-toolbar" style="margin-bottom: 1.5rem;">
        <h2>Informácie o materiáli</h2>
    </div>

    <form method="post" action="<?= $link->url('material.save') ?>">
        <?php require __DIR__ . '/form.part.view.php'; ?>

        <div class="form-actions">
            <a href="<?= $link->url('material.material') ?>" class="btn btn-secondary">
                Zrušiť
            </a>
            <button type="submit" class="btn btn-primary">
                Vytvoriť materiál
            </button>
        </div>
    </form>
</section>
