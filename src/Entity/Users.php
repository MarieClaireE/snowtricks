<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $tokenNewPassword = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNewPassword = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $expireTokenNewPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $tokenNewUser = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $dateTokenNewUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTokenNewPassword(): ?string
    {
        return $this->tokenNewPassword;
    }

    public function setTokenNewPassword(string $tokenNewPassword): self
    {
        $this->tokenNewPassword = $tokenNewPassword;

        return $this;
    }

    public function getDateNewPassword(): ?\DateTimeInterface
    {
        return $this->dateNewPassword;
    }

    public function setDateNewPassword(\DateTimeInterface $dateNewPassword): self
    {
        $this->dateNewPassword = $dateNewPassword;

        return $this;
    }

    public function getExpireTokenNewPassword(): ?\DateTimeInterface
    {
        return $this->expireTokenNewPassword;
    }

    public function setExpireTokenNewPassword(\DateTimeInterface $expireTokenNewPassword): self
    {
        $this->expireTokenNewPassword = $expireTokenNewPassword;

        return $this;
    }

    public function getTokenNewUser(): ?string
    {
        return $this->tokenNewUser;
    }

    public function setTokenNewUser(string $tokenNewUser): self
    {
        $this->tokenNewUser = $tokenNewUser;

        return $this;
    }

    public function getDateTokenNewUser(): ?\DateTimeInterface
    {
        return $this->dateTokenNewUser;
    }

    public function setDateTokenNewUser(\DateTimeInterface $dateTokenNewUser): self
    {
        $this->dateTokenNewUser = $dateTokenNewUser;

        return $this;
    }
}
