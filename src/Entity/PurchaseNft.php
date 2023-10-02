<?php

namespace App\Entity;

use App\Repository\PurchaseNftRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseNftRepository::class)]
class PurchaseNft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseNfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nft $nft = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column]
    private ?float $nftPriceEth = null;

    #[ORM\Column]
    private ?float $nftPriceEur = null;

    #[ORM\Column]
    private ?int $userId = null;

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
}
