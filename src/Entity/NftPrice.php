<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftPriceRepository;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NftPriceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'nft:read'],
    denormalizationContext: ['groups' => 'nft:write', 'nft:update']
)]
#[ApiFilter(SearchFilter::class, properties: ['price_date' => 'ipartial'])]

class NftPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['nft:read', 'category:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['nft:read', 'category:read', 'user:read'])]
    private ?\DateTimeInterface $priceDate = null;

    #[ORM\Column]
    #[Groups(['nft:read', 'category:read', 'user:read'])]
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
