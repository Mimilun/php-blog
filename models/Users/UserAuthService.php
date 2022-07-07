<?php
declare(strict_types=1);

namespace mimilun\models\Users;

class UserAuthService
{
    public static function createCookieToken(User $user): void
    {
        $token = $user->getAuthToken();
        $id = $user->getId();

        $token = $id . ':' . $token;

        $time = isset($_POST['remember']) ? (time() + 60 * 60 * 24 * 30) : 0;

        setcookie('auth_token', $token, $time, '/');
    }

    public static function deleteCookieToken(): void
    {
        setcookie('auth_token', '/', time() - 3600, '/');
    }

    public static function getUserByToken(): ?User
    {
        if (empty($_COOKIE['auth_token'])) {
            return null;
        }
        [$id, $token] = explode(':', $_COOKIE['auth_token']);

        $user = User::getById((int)$id);

        if ($user->getAuthToken() !== $token) {
            return null;
        }

        return $user;
    }
}