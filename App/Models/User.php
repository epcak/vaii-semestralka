<?php

namespace App\Models;

use Framework\Core\Model;

class User extends Model
{
    protected ?string $username;
    protected ?string $email;
    protected ?string $displayname;
    protected ?string $password;
    protected ?int $role; // 0 - klasicky uzivatel, 1 - externy prispievatel, 2 - redaktor, 9 - administrator
    protected ?string $description;
    protected ?int $ban; // 0 alebo nic - ziaden ban, 1 - shadow ban, 2 - tvrdy ban
    protected ?string $session;

    protected static ?string $primaryKey = 'username';

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $newUsername): void 
    {
        $this->username = $newUsername;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $newEmail): void
    {
        $this->email = $newEmail;
    }

    public function getDisplayname(): ?string
    {
        return $this->displayname;
    }

    public function setDisplayname(string $newDisplayname): void
    {
        $this->displayname = $newDisplayname;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $newRole): void
    {
        $this->role = $newRole;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $newDescription): void
    {
        $this->description = $newDescription;
    }

    public function getBan(): ?int
    {
        return $this->ban;
    }

    public function setBan(int $newBan): void
    {
        $this->ban = $newBan;
    }

    public function getSession(): ?string 
    {
        return $this->session;
    }

    public function setSession(string $newSession): void 
    {
        $this->session = $newSession;
    }
}