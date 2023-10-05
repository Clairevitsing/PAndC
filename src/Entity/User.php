<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $roles = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\OneToOne(inversedBy: 'users', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adress $adress = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PurchaseNft::class, orphanRemoval: true)]
    private Collection $purchaseNft;

    public function __construct()
    {
        $this->purchaseNft = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(?string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $Pseudo): static
    {
        $this->Pseudo = $pseudo;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $Lastname): static
    {
        $this->Lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $Firstname): static
    {
        $this->Firstname = $firstname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getAdress(): ?Adress
    {
        return $this->adress;
    }

    public function setAdress(Adress $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseNft>
     */
    public function getPurchaseNft(): Collection
    {
        return $this->purchaseNft;
    }

    public function addPurchaseNft(PurchaseNft $purchaseNft): static
    {
        if (!$this->purchaseNft->contains($purchaseNft)) {
            $this->purchaseNft->add($purchaseNft);
            $purchaseNft->setUser($this);
        }

        return $this;
    }

    public function removePurchaseNft(PurchaseNft $purchaseNft): static
    {
        if ($this->purchaseNft->removeElement($purchaseNft)) {
            // set the owning side to null (unless already changed)
            if ($purchaseNft->getUser() === $this) {
                $purchaseNft->setUser(null);
            }
        }

        return $this;
    }
}
