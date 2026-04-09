<?php require __DIR__ . '/../header.php'; ?>

<h1><?= htmlspecialchars($category->getName()); ?></h1>
<p class="lead">Sondages pour cette catégorie</p>

<div class="row mt-4">
    <?php if (!empty($polls)) {
        foreach ($polls as $poll) {
            include __DIR__ . '/../poll/poll_part.php';
        }
    } else {
        echo '<p>Aucun sondage disponible pour cette catégorie.</p>';
    } ?>
</div>

<a href="/category/list" class="btn btn-secondary mt-4">Retour aux catégories</a>

<?php require __DIR__ . '/../footer.php'; ?>
