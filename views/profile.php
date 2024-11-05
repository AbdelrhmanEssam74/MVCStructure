<?php
// Check if user is logged in
if (!app()->session->get('login')) {
    RedirectToView('login');
    exit();
}

// Determine the user ID from the query string or session
$user_id = $_GET['id'] ?? app()->session->get('user_id') ?? '';

// If user_id is available in session but not in the URL, redirect to add it
$filename = strstr(basename(__FILE__), ".", true);
if (empty($_GET['id']) && !empty($user_id)) {
    header("Location: " . env('HOST') . $filename . "?id=" . urlencode($user_id));
    exit();
}
// Validate that user_id is set and is numeric
if (!$user_id) {
    RedirectToView('404');
    exit();
}

// Fetch user data
$userData = app()->db->row("SELECT * FROM `users` WHERE user_id = ?", [$user_id]);
// Check if user data was found
if (!$userData) {
    RedirectToView('404');
    exit();
}
?>
<div class="alert alert-success text-center fw-bold">
    Welcome <?= htmlspecialchars($userData[0]->full_name, ENT_QUOTES, 'UTF-8') ?>
</div>

