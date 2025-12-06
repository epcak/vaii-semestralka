<?php

namespace App\Models;

use Framework\Core\Model;

class Articleimage extends Model
{
    protected ?int $id;
    protected ?int $article;
    protected ?int $image;

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getArticle(): ?int 
    {
        return $this->article;
    }

    public function setArticle(int $newArticle): void 
    {
        $this->article = $newArticle;
    }

    public function getImage(): ?int 
    {
        return $this->image;
    }

    public function setImage(int $newImage): void 
    {
        $this->image = $newImage;
    }
}