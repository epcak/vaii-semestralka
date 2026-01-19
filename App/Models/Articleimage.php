<?php

namespace App\Models;

use Framework\Core\Model;

class Articleimage extends Model
{
    protected ?int $id;
    protected ?int $article_id;
    protected ?int $image_id;

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getArticle(): ?int 
    {
        return $this->article_id;
    }

    public function setArticle(int $newArticle): void 
    {
        $this->article_id = $newArticle;
    }

    public function getImage(): ?int 
    {
        return $this->image_id;
    }

    public function setImage(int $newImage): void 
    {
        $this->image_id = $newImage;
    }
}