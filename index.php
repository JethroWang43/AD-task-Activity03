<?php
declare(strict_types=1);

require_once BASE_PATH . '/vendor/autoload.php';
require_once HANDLERS_PATH . '/flashMessage.handler.php'; // ✅ Include the handler
?>

<link rel="stylesheet" href="/assets/css/style.css">

<main class="login-container">
    <section class="login-box">
        <h2>Login to Your Account</h2>

        <?php renderFlashMessages(); ?> 

        <form action="/handlers/auth.handler.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </section>
</main>
