<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressRepository::class)]
class Adress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    private ?string $ZIPCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\OneToOne(mappedBy: 'adress', cascade: ['persist', 'remove'])]
    private ?User $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getZIPCode(): ?string
    {
        return $this->ZIPCode;
    }

    public function setZIPCode(string $ZIPCode): static
    {
        $this->ZIPCode = $ZIPCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(User $users): static
    {
        // set the owning side of the relation if necessary
        if ($users->getAdress() !== $this) {
            $users->setAdress($this);
        }

        $this->users = $users;

        return $this;
    }
}
