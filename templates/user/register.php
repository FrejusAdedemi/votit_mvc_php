<?php require __DIR__ . '/../header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="mb-4">Inscription</h2>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <p> <?= htmlspecialchars($error) ?> </p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <form method="post" action="/register/">
      <div class="mb-3">
        <label for="nickname" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="nickname" name="nickname" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../footer.php'; ?>
