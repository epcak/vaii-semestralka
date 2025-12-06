<?php

namespace App\Models;

use Framework\Core\Model;

class Image extends Model
{
    protected ?int $id;
    protected ?string $location;
    protected ?string $name;
    protected ?string $description;
    protected ?string $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string 
    {
        return $this->location;
    }

    public function setLocation(string $newLocation): void 
    {
        $this->location = $newLocation;
    }

    public function getName(): ?string 
    {
        return $this->name;
    }

    public function setName(string $newName): void 
    {
        $this->name = $newName;
    }

    public function getDescription(): ?string 
    {
        return $this->description;
    }

    public function setDescription(string $newDescription): void 
    {
        $this->description = $newDescription;
    }

    public function getUser(): ?string 
    {
        return $this->user;
    }

    public function setUser(string $newUser): void
    {
        $this->user = $newUser;
    }
}