<?php

namespace mimilun\controllers;

use mimilun\models\Articles\Article;

class ArticleController extends BaseController
{
    public function showOne(int $id): void
    {
        $article = Article::getById($id);

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

    public function edit(int $id): void
    {
        $this->allowAdmin();

        $article = Article::getById($id);

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
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);

        } catch (\Exception $e) {
            $message = 'Не удалось отредактировать статью';
            $this->view->renderHtml('message.php', ['message' => $message, 'color' => 'bg-danger']);
        }
    }

    public function add(): void
    {
        $this->allowAdmin();

        $article = new Article();

        if (!empty($_POST)) {
            $article->setName($_POST['nameStory']);
            $article->setText($_POST['contentStory']);
            $article->setAuthor($this->user);

            try {
                $article->save();
                $message = 'Статья добавлена';
                $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);

            } catch (\Exception $e) {
                $message = 'Не удалось добавить статью';
                $this->view->renderHtml('message.php', ['message' => $message, 'color' => 'bg-danger']);
            }

        } else {
            $this->view->renderHtml('article/add.php');
        }

    }

    public function delete(int $id): void
    {
        $this->allowAdmin();

        $article = new Article();

        try {
            $article->delete($id);
            $message = 'Статья успешно удалена';
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-success']);

        } catch (\Exception $e) {
            $message = 'Не удалось удалить статью';
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);
        }
    }

    protected function allowAdmin(): void
    {
        if (!$this->user || $this->user->getRole() !== 'admin') {
            $message = 'Нужны права Админа';
            $this->view->renderHtml('message.php', ['message' => $message, 'colorBg' => 'bg-danger']);

            exit();
        }
    }
}