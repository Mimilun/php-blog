<?php

declare(strict_types=1);

namespace mimilun\models;

use mimilun\exceptions\NotFoundException;
use mimilun\exceptions\UnauthorizedException;
use mimilun\models\Articles\Article;
use mimilun\models\Users\User;

class Validation
{
    public static function checkAuthorisation(?User $user): void
    {
        if ($user === null) {
            throw new UnauthorizedException('Необходима авторизация');
        }
    }

    public static function checkAuthor(?Article $article, User $user): void
    {
        if ($article === null) {
           throw new NotFoundException('Статья не найдена');
        }
        if ($user->getId() !== $article->authorId) {
            throw new UnauthorizedException('Вы не являетесь автором статьи');
        }
    }
}