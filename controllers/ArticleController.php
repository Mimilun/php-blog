<?php

declare(strict_types=1);

namespace mimilun\controllers;

use mimilun\exceptions\InvalidArgumentException;
use mimilun\exceptions\NotFoundException;
use mimilun\exceptions\UnauthorizedException;
use mimilun\models\Articles\Article;
use mimilun\models\Validation;

class ArticleController extends BaseController
{
    public function showOne(string $id): void
    {
        $article = Article::getById((int)$id);

        if ($article !== null) {
            $this->view->renderHtml('article/article.php', ['article' => $article]);
        } else {
            $this->view->renderHtml('404.php', [], 404);
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function showAll(): void
    {
        $articles = Article::findAll();
        if (!empty($articles)) {
            $this->view->renderHtml('article/articles.php', ['articles' => $articles]);
        } else {
            $this->view->renderHtml('404.php', [], 404);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function add(): void
    {
        try {
            Validation::checkAuthorisation($this->user);
        } catch (UnauthorizedException $e) {
            $message = $e->getMessage();
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
            exit();
        }

        if (empty($_POST)) {
            $this->view->renderHtml('article/add.php');
            exit();
        }

        try {
            $article = Article::create($_POST, $this->user);
        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();
            $this->view->renderHtml('article/add.php', ['error' => $error, 'colorBg' => 'bg-danger']);
            exit();
        }

        header('Location: ' . '/articles/' . $article->getId());
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function edit(string $id): void
    {
        $article = Article::getById((int)$id);

        try {
            Validation::checkAuthorisation($this->user);
            Validation::checkAuthor($article, $this->user);
        } catch (UnauthorizedException|NotFoundException $e) {
            $message = $e->getMessage();
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
            exit();
        }

        if (empty($_POST)) {
            $this->view->renderHtml('article/edit.php', ['article' => $article]);
            exit();
        }
        try {
            $article->edit($_POST, $this->user, $article);
        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();
            $this->view->renderHtml('article/add.php',
                ['article' => $article, 'error' => $error, 'colorBg' => 'bg-danger']);
            exit();
        }

        header('Location: ' . '/articles/' . $article->getId());
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function delete(string $id): void
    {
        $article = Article::getById((int)$id);

        try {
            Validation::checkAuthorisation($this->user);
            Validation::checkAuthor($article, $this->user);
        } catch (UnauthorizedException|NotFoundException $e) {
            $message = $e->getMessage();
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
            exit();
        }
        $article->delete((int)$id);

        $message = 'Статья успешно удалена';
        $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);
    }
}