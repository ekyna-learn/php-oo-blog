<?php

// src/Entity/Category.php

namespace Entity;

class Category
{
    /** @var int */
    private $id = null;

    /** @var string */
    private $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Category
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Category
    {
        $this->title = $title;

        return $this;
    }
}
