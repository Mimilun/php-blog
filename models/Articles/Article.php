<?php
declare(strict_types=1);

namespace mimilun\models\Articles;

use mimilun\contracts\Model;
use mimilun\models\ActiveRecordEntity;
use mimilun\models\Users\User;

class Article extends ActiveRecordEntity implements Model
{
    protected int $authorId;
    protected string $name;
    protected string $text;
    protected string $createdAt;
    protected int $id;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
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
        $date = date('d.m.Y', $timestamp);
        return $date;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}