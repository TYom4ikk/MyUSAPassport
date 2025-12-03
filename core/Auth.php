<?php
class Auth
{
    public static function userId(): ?int
    {
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }

    public static function check(): bool
    {
        return self::userId() !== null;
    }

    public static function login(int $id): void
    {
        $_SESSION['user_id'] = $id;
    }

    public static function logout(): void
    {
        unset($_SESSION['user_id']);
    }
}
