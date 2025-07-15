<?php
declare(strict_types=1);

require_once '../bootstrap.php';

class AuthUtil
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

     public static function login(string $username, string $password): bool
    {
        self::init();

        $users = require STATICDATA_PATH . '/dummies/users.staticData.php';

        foreach ($users as $user) {
            if (
                $user['username'] === $username &&
                $user['password'] === $password
            ) {
                $_SESSION['user'] = $user;
                return true;
            }
        }

        return false;
    }

    public static function user(): array|null
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        self::init();
        return isset($_SESSION['user']);
    }

    public static function logout(): void
    {
        self::init();
        session_unset();
        session_destroy();
    }
}
