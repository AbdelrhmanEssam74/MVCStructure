<?php
if (app()->session->exists('login')) {
    RedirectToView('profile');
    exit();
}
?>
<div class="form-container p-4 rounded shadow-sm bg-light">
    <h2 class="text-center mb-4">Sign Up</h2>
    <form method="post" action="/store" novalidate>
        <!-- Full Name -->
        <div class="form-group mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input 
                type="text" 
                class="form-control <?= app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['full_name']) ? 'is-invalid' : ''; ?>" 
                id="full_name" 
                name="full_name" 
                placeholder="Enter your full name" 
                value="<?= old('full_name') ?? ''; ?>" 
            >
            <?php if (app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['full_name'])): ?>
                <div class="invalid-feedback">
                    <?= app()->session->getFlash('errors')['full_name'][0]; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Username -->
        <div class="form-group mb-3">
            <label for="username" class="form-label">Username</label>
            <input 
                type="text" 
                class="form-control <?= app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['username']) ? 'is-invalid' : ''; ?>" 
                id="username" 
                name="username" 
                placeholder="Enter a username" 
                value="<?= old('username') ?? ''; ?>" 
            >
            <?php if (app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['username'])): ?>
                <div class="invalid-feedback">
                    <?= app()->session->getFlash('errors')['username'][0]; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input 
                type="email" 
                class="form-control <?= app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['email']) ? 'is-invalid' : ''; ?>" 
                id="email" 
                name="email" 
                placeholder="Enter your email address" 
                value="<?= old('email') ?? ''; ?>" 
            >
            <?php if (app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['email'])): ?>
                <div class="invalid-feedback">
                    <?= app()->session->getFlash('errors')['email'][0]; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Password -->
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
                type="password" 
                class="form-control <?= app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['password']) ? 'is-invalid' : ''; ?>" 
                id="password" 
                name="password" 
                placeholder="Enter a password" 
            >
            <?php if (app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['password'])): ?>
                <div class="invalid-feedback">
                    <?= app()->session->getFlash('errors')['password'][0]; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Confirm Password -->
        <div class="form-group mb-4">
            <label for="confirm-password" class="form-label">Confirm Password</label>
            <input 
                type="password" 
                class="form-control <?= app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['password_confirmation']) ? 'is-invalid' : ''; ?>" 
                id="confirm-password" 
                name="password_confirmation" 
                placeholder="Confirm your password" 
            >
            <?php if (app()->session->hasFlash('errors') && isset(app()->session->getFlash('errors')['password_confirmation'])): ?>
                <div class="invalid-feedback">
                    <?= app()->session->getFlash('errors')['password_confirmation'][0]; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
