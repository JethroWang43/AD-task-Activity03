<?php
function renderFlashMessages(): void
{
    if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
        echo '<div class="success-message">✅ You have been logged out successfully.</div>';
    }

    if (isset($_GET['error'])) {
        $error = htmlspecialchars($_GET['error']);
        echo "<div class=\"error-message\">$error</div>";
    }

    if (isset($_GET['success'])) {
        $success = htmlspecialchars($_GET['success']);
        echo "<div class=\"success-message\">$success</div>";
    }
}
