<?php

namespace Entity;

use DateTime;

class Post
{
    /** @var int */
    private $id;

    /** @var Category */
    private $category;

    /** @var Author */
    private $author;

    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /** @var \DateTime */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id = null): Post
    {
        $this->id = $id;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category = null): Post
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author = null): Post
    {
        $this->author = $author;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): Post
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): Post
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): Post
    {
        $this->date = $date;

        return $this;
    }
}
