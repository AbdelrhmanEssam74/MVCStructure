<?php
if (!app()->session->exists('login')) {
    RedirectToView('login');
    exit();
}
$userData = (app()->session->get('userData'));
?>
<div class="alert alert-success text-center fw-bold"> Welcome
    <?= $userData->full_name ?>
</div>
