<?php

return [
    '~^/?$~i'                         => [mimilun\controllers\MainController::class, 'main'],
    '~^about/?$~i'                    => [mimilun\controllers\MainController::class, 'about'],
    '~^contacts/?$~i'                 => [mimilun\controllers\MainController::class, 'contacts'],
    '~^articles/?(\d+)/?$~i'          => [mimilun\controllers\ArticleController::class, 'showOne'],
    '~^articles/?(\d+)/edit/?$~i'     => [mimilun\controllers\ArticleController::class, 'edit'],
    '~^articles/?(\d+)/delete/?$~i'   => [mimilun\controllers\ArticleController::class, 'delete'],
    '~^articles/?$~i'                 => [mimilun\controllers\ArticleController::class, 'showAll'],
    '~^articles/add/?$~i'             => [mimilun\controllers\ArticleController::class, 'add'],
    '~^error/?$~i'                    => [mimilun\controllers\ErrorController::class, 'error'],
    '~^users/login/?$~i'              => [mimilun\controllers\UserController::class, 'login'],
    '~^users/logout/?$~i'             => [mimilun\controllers\UserController::class, 'logOut'],
    '~^users/register/?$~i'           => [mimilun\controllers\UserController::class, 'singUp'],
    '~^users/(\d+)/activate/(.+)?$~i' => [mimilun\controllers\UserController::class, 'activate'],
];