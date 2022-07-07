<?php

declare(strict_types=1);

namespace mimilun\controllers;

use mimilun\exceptions\UnauthorizedException;
use mimilun\models\Articles\Article;

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

    public function showAll(): void
    {
        $articles = Article::findAll();
        if (!empty($articles)) {
            $this->view->renderHtml('article/articles.php', ['articles' => $articles]);
        } else {
            $this->view->renderHtml('404.php', [], 404);
        }
    }

    public function edit(string $id): void
    {
        $article = Article::getById((int)$id);

        try {
            $this->checkAuthor($article);
        } catch (UnauthorizedException $e) {
            $message = $e->getMessage();
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
            exit();
        }

        if (empty($_POST)) {
            $this->view->renderHtml('article/edit.php', ['article' => $article]);
            exit();
        }

        $name = $_POST['nameStory'];
        $text = $_POST['contentStory'];

        $article->setName($name);
        $article->setText($text);

        try {
            $article->save();
            $message = 'Статья отредактирована';
        } catch (\Exception $e) {
            $message = 'Не удалось отредактировать статью';
        }
        $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);
    }

    public function add(): void
    {
        try {
            $this->checkAuthorisation();
        } catch (UnauthorizedException $e) {
            $message = $e->getMessage();
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
            exit();
        }

        $article = new Article();

        if (empty($_POST)) {
            $this->view->renderHtml('article/add.php');
            exit();
        }
        $article->setName($_POST['nameStory']);
        $article->setText($_POST['contentStory']);
        $article->setAuthor($this->user);

        try {
            $article->save();
        } catch (\Exception $e) {
            $message = 'Не удалось добавить статью';
            $this->view->renderHtml('message.php', ['message' => $message, 'color' => 'bg-danger']);
            exit();
        }

        $message = 'Статья добавлена';
        $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);
    }

    public function delete(string $id): void
    {
        $article = Article::getById((int)$id);

        try {
            $this->checkAuthor($article);
        } catch (UnauthorizedException $e) {
            $message = $e->getMessage();
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
            exit();
        }

        try {
            $article->delete((int)$id);
        } catch (\Exception $e) {
            $message = 'Не удалось удалить статью';
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
        }
        $message = 'Статья успешно удалена';
        $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);
    }

    protected function checkAuthorisation(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходима авторизация');
        }
    }

    protected function checkAuthor(?Article $article): void
    {
        if ($article === null) {
            $this->view->renderHtml('404.php', [], 404);
            exit();
        }
        if ($this->user->getId() !== $article->getAuthorId()) {
            throw new UnauthorizedException('Вы не являетесь автором статьи');
        }
    }
}