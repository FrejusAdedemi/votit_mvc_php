<?php require __DIR__ . '/../header.php'; ?>
<div class="row text-center">
    <h2>Liste des sondages</h2>
    <div class="row">
        <?php if (!empty($polls)) {
            foreach ($polls as $poll) {
                include __DIR__ . '/../poll/poll_part.php';
            }
        } else {
            echo '<p class="mt-3">Aucun sondage disponible pour le moment.</p>';
        } ?>
    </div>
</div>
<?php require __DIR__ . '/../footer.php'; ?>
