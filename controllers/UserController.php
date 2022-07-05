<?php

namespace mimilun\controllers;

use mimilun\exceptions\InvalidArgumentException;
use mimilun\exceptions\InvalidAuthException;
use mimilun\models\Users\User;
use mimilun\models\Users\UserAuthService;

class UserController extends BaseController
{
    public function singUp(): void
    {
        if (!empty($_POST)) {
            try {
                User::singUp($_POST);
            } catch (InvalidArgumentException $e) {
                $error = $e->getMessage();
                $this->view->renderHtml('users/register.php', ['error' => $error]);

                return;
            }
            $message = 'Вы успешно зарегистрированы';
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);

            return;
        }
        $this->view->renderHtml('users/register.php');
    }

    public function login(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UserAuthService::createCookieToken($user);

                $path = '/';
                header('Location: ' . $path);
                exit;

            } catch (InvalidArgumentException $e) {
                $error = $e->getMessage();
                $this->view->renderHtml('users/login.php', ['error' => $error]);

                return;
            } catch (InvalidAuthException $e) {
                $error = $e->getMessage();
                $this->view->renderHtml('users/login.php', ['error' => $error]);

                return;
            }
        }

        $this->view->renderHtml('users/login.php', ['user' => $this->user]);
    }

    public function logOut(): void
    {
        UserAuthService::deleteCookieToken();
        $path = '/';
        header('Location: ' . $path);
        exit;
    }
}