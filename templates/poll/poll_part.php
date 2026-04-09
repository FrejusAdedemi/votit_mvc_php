<div class="col-md-4 my-2 d-flex">
    <div class="card w-100">
        <div class="card-header d-flex align-items-center gap-2">
            <img width="40" src="/assets/images/icon-arrow.png" alt="icone flèche haut">
            <?= htmlspecialchars($poll->getCategory()?->getName() ?? 'Sans catégorie'); ?>
        </div>
        <div class="card-body d-flex flex-column">
            <h3 class="card-title"><?= htmlspecialchars($poll->getTitle()); ?></h3>
            <p class="card-text"><?= nl2br(htmlspecialchars($poll->getDescription())); ?></p>
            <div class="mt-auto text-end">
                <a href="/poll/?id=<?= htmlspecialchars($poll->getId()); ?>" class="btn btn-primary">Voir le sondage</a>
            </div>
        </div>
    </div>
</div>
