<?php require __DIR__ . '/../header.php'; ?>

<div class="row align-items-center g-5 py-5">
  <div class="col-lg-6">
    <h1 class="display-5 fw-bold lh-1 mb-3"><?= htmlspecialchars($poll->getTitle()) ?></h1>
    <p class="lead"><?= nl2br(htmlspecialchars($poll->getDescription())) ?></p>
  </div>
  <div class="col-10 col-sm-8 col-lg-6">
    <h2>Résultats</h2>
    <div class="results">
      <?php 
      $totalVotes = array_sum(array_column($results, 'count'));
      foreach ($items as $index => $item) {
        $votes = $results[$item->getId()]['count'] ?? 0;
        $percent = $totalVotes ? ($votes / $totalVotes * 100) : 0;
      ?>
        <h3><?= htmlspecialchars($item->getName()) ?></h3>
        <div class="progress mb-2" role="progressbar" aria-label="<?= htmlspecialchars($item->getName()) ?>" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
          <div class="progress-bar progress-bar-striped progress-color-<?= $index ?>" style="width: <?= $percent ?>%">
            <?= htmlspecialchars($item->getName()) ?> <?= round($percent, 2) ?>%
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="mt-5">
      <?php if (!empty($_SESSION['user'])) { ?>
        <form method="post" action="/poll/vote/?id=<?= $poll->getId() ?>">
          <h2>Votez pour ce sondage :</h2>
          <div class="btn-group" role="group" aria-label="Choix du sondage">
            <?php foreach ($items as $item) { ?>
              <input type="radio" class="btn-check" id="btncheck<?= $item->getId() ?>" autocomplete="off" value="<?= $item->getId() ?>" name="option" required>
              <label class="btn btn-outline-primary" for="btncheck<?= $item->getId() ?>"><?= htmlspecialchars($item->getName()) ?></label>
            <?php } ?>
          </div>
          <?php if (!empty($error)) { ?>
            <div class="alert alert-danger mt-2" role="alert">
              <?= htmlspecialchars($error) ?>
            </div>
          <?php } ?>
          <div class="mt-2">
            <input type="submit" class="btn btn-primary" value="Voter">
          </div>
        </form>
      <?php } else { ?>
        <div class="alert alert-warning mt-3">
          Vous devez être connecté pour voter.
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<a href="/poll/list/" class="btn btn-secondary mt-4">Retour à la liste</a>
<?php require __DIR__ . '/../footer.php'; ?>
