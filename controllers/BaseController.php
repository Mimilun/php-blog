<?php
declare(strict_types=1);

namespace mimilun\controllers;

use mimilun\models\Users\User;
use mimilun\models\Users\UserAuthService;
use mimilun\view\View;

abstract class BaseController
{
    protected View $view;
    protected ?User $user = null;

    public function __construct()
    {
        $this->view = new View();
        $this->user = UserAuthService::getUserByToken();
        $this->view->setValue('user', $this->user);
    }
}