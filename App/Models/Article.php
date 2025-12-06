<?php

namespace App\Models;

use Framework\Core\Model;

class Article extends Model
{
    protected ?int $id;
    protected ?string $created_at;
    protected ?string $edited_at;
    protected ?string $author;
    protected ?string $title;
    protected ?int $title_image;
    protected ?string $text;
    protected ?string $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?string 
    {
        return $this->created_at;
    }

    public function setCreated(string $newCreated): void 
    {
        $this->created_at = $newCreated;
    }

    public function getEdited(): ?string 
    {
        return $this->edited_at;
    }

    public function setEdited(string $newEdited): void 
    {
        $this->edited_at = $newEdited;
    }

    public function getAuthor(): ?string 
    {
        return $this->author;
    }

    public function setAuthor(string $newAuthor): void 
    {
        $this->author = $newAuthor;
    }

    public function getTitle(): ?string 
    {
        return $this->title;
    }

    public function setTitle(string $newTitle): void 
    {
        $this->title = $newTitle; 
    }

    public function getTitleImage(): ?int 
    {
        return $this->title_image;
    }

    public function setTitleImage(int $newImage): void 
    {
        $this->title_image = $newImage;
    }

    public function getText(): ?string 
    {
        return $this->text;
    }

    public function setText(string $newText): void 
    {
        $this->text = $newText;
    }

    public function getTags(): ?string 
    {
        return $this->tags;
    }

    public function setTags(string $newTags): void 
    {
        $this->tags = $newTags;
    }
}