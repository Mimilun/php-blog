<?php

declare(strict_types=1);

namespace mimilun\models\Articles;

use mimilun\contracts\Model;
use mimilun\exceptions\InvalidArgumentException;
use mimilun\models\ActiveRecordEntity;
use mimilun\models\Users\User;
use mimilun\services\Db;

class Article extends ActiveRecordEntity implements Model
{
    protected int $authorId;
    protected string $name;
    protected string $text;
    protected string $createdAt;
    protected int $id;

    /**
     * @throws \mimilun\exceptions\InvalidArgumentException
     */
    public static function create(array $articleData, User $user, Article $article = new Article()): Article
    {
        $title = htmlspecialchars(trim($articleData['nameStory']));
        $content = htmlspecialchars(trim($articleData['contentStory']));

        if ($title === '' || $content === '') {
            throw new InvalidArgumentException('Заполните все поля');
        }

        $article->setName($title);
        $article->setText($content);
        $article->setAuthor($user);

        $article->save();
        $article->id = $article->id ?? Db::getInstance()
                                         ->getLastId();

        return $article;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @throws \mimilun\exceptions\InvalidArgumentException
     */
    public function edit(array $articleData, User $user, Article $article): Article
    {
        return static::create($articleData, $user, $article);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    public function __get(string $nameProperty): mixed
    {
        return $this->$nameProperty;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function getDate(): string
    {
        $timestamp = strtotime($this->createdAt);

        return date('d.m.Y - H:i', $timestamp);
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

}