<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PurchaseNftRepository;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: PurchaseNftRepository::class)]
#[ApiResource()]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class PurchaseNft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['purchaseNft:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseNfts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['purchaseNft:read', 'user:read'])]
    private ?Nft $nft = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['purchaseNft:read', 'user:read', 'nft:read'])]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column]
    #[Groups(['purchaseNft:read', 'user:read', 'nft:read'])]
    private ?float $nftPriceEth = null;

    #[ORM\Column]
    #[Groups(['purchaseNft:read', 'user:read', 'nft:read'])]
    private ?float $nftPriceEur = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseNft')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['purchaseNft:read', 'user:read'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNft(): ?Nft
    {
        return $this->nft;
    }

    public function setNft(?Nft $nft): static
    {
        $this->nft = $nft;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTimeInterface $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getNftPriceEth(): ?float
    {
        return $this->nftPriceEth;
    }

    public function setNftPriceEth(float $nftPriceEth): static
    {
        $this->nftPriceEth = $nftPriceEth;

        return $this;
    }

    public function getNftPriceEur(): ?float
    {
        return $this->nftPriceEur;
    }

    public function setNftPriceEur(float $nftPriceEur): static
    {
        $this->nftPriceEur = $nftPriceEur;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
