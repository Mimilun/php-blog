<?php

namespace mimilun\models\Users;

use mimilun\contracts\Model;
use mimilun\exceptions\InvalidArgumentException;
use mimilun\exceptions\InvalidAuthException;
use mimilun\models\ActiveRecordEntity;
use mimilun\services\Db;

class User extends ActiveRecordEntity implements Model
{
    protected int $id;
    protected string $nickName;
    protected string $email;
    protected string $isConfirmed;
    protected string $role;
    protected string $passwordHash;
    protected string $authToken;

    public static function singUp($userData): static
    {
        if (!empty($_POST)) {
            if (empty($userData['name'])) {
                throw new InvalidArgumentException('Не передан nickname');
            }

            if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['name'])) {
                throw new InvalidArgumentException('Login может содержать только латинские символы');
            }

            if (empty($userData['email'])) {
                throw new InvalidArgumentException('Не передан email');
            }

            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Не верный email');
            }

            if (empty($userData['pass'])) {
                throw new InvalidArgumentException('Не передан password');
            }

            if (mb_strlen($userData['pass']) < 6) {
                throw new InvalidArgumentException('Пароль не менее 6 символов');
            }

            if (empty($userData['pass_confirm'])) {
                throw new InvalidArgumentException('Не подтвержден password');
            }

            if ($userData['pass'] !== $userData['pass_confirm']) {
                throw new InvalidArgumentException('Не совпадают пароли');
            }

            if (static::getOneByColumn('nick_name', $userData['name']) !== null) {
                throw new InvalidArgumentException('Данное имя уже занято');
            }

            if (static::getOneByColumn('email', $userData['email']) !== null) {
                throw new InvalidArgumentException('Данный email уже существует');
            }
        }
        $user = new User();

        $user->nickName = $userData['name'];
        $user->email = $userData['email'];
        $user->isConfirmed = 0;
        $user->role = 'user';
        $user->passwordHash = password_hash($userData['pass'], PASSWORD_DEFAULT);
        $user->authToken = $user->refreshAuthToken();

        $user->save();

        $db = Db::getInstance();
        $user->id = $db->getLastId();

        return $user;
    }

    public static function login($userData): static
    {
        if (empty($userData['login'])) {
            throw new InvalidArgumentException('Не заполнено поле login');
        }

        if (empty($userData['pass'])) {
            throw new InvalidArgumentException('Не заполнено поле password');
        }

        $user = static::getOneByColumn('nick_name', $userData['login']);

        if ($user === null || !password_verify($userData['pass'], $user->passwordHash)) {
            throw new InvalidAuthException('Не верный логин или пароль');
        }

        if (!$user->getConfirmed()) {
            throw new InvalidAuthException('Не подтверждена активация');
        }

        $user->authToken = $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function setConfirmed(): void
    {
        $this->isConfirmed = 1;
        $this->save();
    }

    public function getConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function getNickName(): string
    {
        return $this->nickName;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    protected function refreshAuthToken(): string
    {
        return sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}