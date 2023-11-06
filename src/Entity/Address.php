<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['address:read','user:read']],
    denormalizationContext: ['groups' => 'user:write']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','user:create'])]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','user:create'])]
    private ?string $ZIPCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','user:create'])]
    private ?string $city = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    #[Groups(['user:read','user:create'])]
    private ?User $user = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getAddress() !== $this) {
            $user->setAddress($this);
        }

        $this->user = $user;

        return $this;
    }
}
