<?php
if (app()->session->exists('login')) {
    RedirectToView('profile');
    exit();
}
?>
<div class="form-container">
    <h2 class="text-center mb-4">Register</h2>
    <form method="post" action="/store">
        <div class="field">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter username">
            </div>
            <?php if (app()->session->hasFlash('errors')): ?>
                <p id="emailHelp" class="form-text text-danger">
                    <?= app()->session->getFlash('errors')['full_name'][0]; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="field">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            </div>
            <?php if (app()->session->hasFlash('errors')): ?>
                <p id="emailHelp" class="form-text text-danger">
                    <?= app()->session->getFlash('errors')['username'][0]; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="field">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <?php if (app()->session->hasFlash('errors')): ?>
                <p id="emailHelp" class="form-text text-danger">
                    <?= app()->session->getFlash('errors')['email'][0]; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="field">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <?php if (app()->session->hasFlash('errors')): ?>
                <p id="emailHelp" class="form-text text-danger">
                    <?= app()->session->getFlash('errors')['password'][0]; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="field">
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm-password" name="password_confirmation"
                       placeholder="Confirm Password">
            </div>
            <?php if (app()->session->hasFlash('errors')): ?>
                <p id="emailHelp" class="form-text text-danger">
                    <?= app()->session->getFlash('errors')['password_confirmation'][0]; ?>
                </p>
            <?php endif; ?>
        </div>
        <button type="submit" class=" w-100 btn btn-primary btn-block">Register</button>
    </form>
</div>