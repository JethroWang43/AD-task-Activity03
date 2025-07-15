<?php
declare(strict_types=1);

require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (AuthUtil::login($username, $password)) {
    header('Location: /pages/welcome/index.php?login=success');
    exit;
} else {
    $error = urlencode("Invalid username or password");
    header("Location: /pages/login/index.php?error=$error");
    exit;
}
