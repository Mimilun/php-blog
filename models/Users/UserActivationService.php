<?php

namespace mimilun\models\Users;

use mimilun\services\Db;

class UserActivationService
{
    private const TABLE_NAME = 'users_activation_codes';

    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $db = Db::getInstance();

        $query = 'INSERT INTO' . ' ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)';

        $db->query($query, [':user_id' => $user->getId(), ':code' => $code]);

        return $code;
    }

    public static function checkActivationCode(User $user, string $code): bool
    {
        $db = Db::getInstance();

        $query = 'SELECT * FROM' . ' ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code';

        $result = $db->query($query, [':user_id' => $user->getId(), ':code' => $code]);

        return !empty($result);
    }
}