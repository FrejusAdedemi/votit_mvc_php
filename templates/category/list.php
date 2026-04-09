<?php require __DIR__ . '/../header.php'; ?>

<h1>Catégories</h1>
<div class="row mt-4">
    <?php if (!empty($categories)) {
        foreach ($categories as $category) {
            ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($category->getName()); ?></h5>
                        <a href="/category/?id=<?= htmlspecialchars($category->getId()); ?>" class="btn btn-primary">Voir les sondages</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>Aucune catégorie disponible.</p>';
    } ?>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
