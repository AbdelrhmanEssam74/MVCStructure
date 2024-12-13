<?php
if (app()->session->exists('login')) {
  RedirectToView('profile');
  exit();
}
?>
<div class="form-container p-4 rounded shadow-sm bg-light">
  <?php if (app()->session->hasFlash('success')): ?>
    <p class="alert alert-success text-center fw-semibold">
      <?= app()->session->getFlash('success'); ?>
    </p>
  <?php endif; ?>

  <h2 class="text-center mb-4">Welcome Back</h2>

  <form method="post" novalidate>
    <!-- Email Field -->
    <div class="form-group mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input
        type="email"
        class="form-control <?= app()->session->hasFlash('email') ? 'is-invalid' : ''; ?>"
        id="email"
        name="email"
        placeholder="Enter your email"
        value="<?= app()->session->hasFlash('oldEmail') ? app()->session->getFlash('oldEmail') : ''; ?>">
      <?php if (app()->session->hasFlash('email')): ?>
        <div class="invalid-feedback">
          <?= app()->session->getFlash('email')[0]; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Password Field -->
    <div class="form-group mb-4">
      <label for="password" class="form-label">Password</label>
      <input
        type="password"
        class="form-control <?= app()->session->hasFlash('password') ? 'is-invalid' : ''; ?>"
        id="password"
        name="password"
        placeholder="Enter your password">
      <?php if (app()->session->hasFlash('password')): ?>
        <div class="invalid-feedback">
          <?= app()->session->getFlash('password')[0]; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>