<?php
declare(strict_types=1);

require_once '../utils/auth.util.php';

AuthUtil::logout();

// Redirect to login page
header('Location: /pages/login/index.php?logout=success');
exit;
