<?php

namespace App\Entity;

use App\Repository\NftPriceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NftPriceRepository::class)]
class NftPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $priceDate = null;

    #[ORM\Column]
    private ?float $ethValue = null;

    #[ORM\OneToOne(inversedBy: 'nftPrice', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nft $nft = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceDate(): ?\DateTimeInterface
    {
        return $this->priceDate;
    }

    public function setPriceDate(\DateTimeInterface $priceDate): static
    {
        $this->priceDate = $priceDate;

        return $this;
    }

    public function getEthValue(): ?float
    {
        return $this->ethValue;
    }

    public function setEthValue(float $ethValue): static
    {
        $this->ethValue = $ethValue;

        return $this;
    }

    public function getNft(): ?Nft
    {
        return $this->nft;
    }

    public function setNft(Nft $nft): static
    {
        $this->nft = $nft;

        return $this;
    }
}
