<?php

namespace App\Models;

use Framework\Core\Model;

class Comment extends Model
{
    protected ?int $id;
    protected ?int $article_id;
    protected ?string $user_id;
    protected ?string $comment;
    protected ?string $created_at;
    protected ?string $edited_at;
    protected ?int $deleted; // 0 alebo nic - navymazane, 1 - vymazane uzivatelom, 2 - vymazane redaktorom/administratorom

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

    public function getUser(): ?string 
    {
        return $this->user_id;
    }

    public function setUser(string $newUser): void 
    {
        $this->user_id = $newUser;
    }

    public function getComment(): ?string 
    {
        return $this->comment;
    }

    public function setComment(string $newComment): void 
    {
        $this->comment = $newComment;
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

    public function getDeleted(): ?int 
    {
        return $this->deleted;
    }

    public function setDeleted(int $newDeleted): void 
    {
        $this->deleted = $newDeleted;
    }
}