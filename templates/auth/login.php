<?php require __DIR__ . '/../header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="mb-4">Connexion</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>
    <form method="post" action="/login/">
      <div class="mb-3">
        <label for="nickname" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="nickname" name="nickname" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../footer.php'; ?>
