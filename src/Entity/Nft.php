<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NftRepository;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NftRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['nft:read','user:read']], order: ['launch_date' => 'DESC'],
    denormalizationContext: ['groups' => 'nft:write', 'nft:update']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'nft:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'nft:read', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'nft:read', 'user:read','nft:write', 'nft:update'])]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'nft:read', 'user:read', 'nft:write','nft:update'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['category:read', 'nft:read', 'user:read', 'nft:write'])]
    private ?\DateTimeInterface $launchDate = null;

    #[ORM\Column]
    #[Groups(['category:read', 'nft:read', 'user:read', 'nft:write'])]
    private ?float $launchPriceEur = null;

    #[ORM\Column]
    #[Groups(['category:read', 'nft:read', 'user:read', 'nft:write'])]
    private ?float $launchPriceEth = null;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    #[ORM\JoinColumn(name:"category_id", nullable: false, referencedColumnName: "id")]
    #[Groups('nft:read','user:read')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'nft', targetEntity: PurchaseNft::class, orphanRemoval: true)]
    #[Groups('nft:read')]
    private Collection $purchaseNfts;

    public function __construct()
    {
        $this->purchaseNfts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launchDate;
    }

    public function setLaunchDate(\DateTimeInterface $launchDate): static
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    public function getLaunchPriceEur(): ?float
    {
        return $this->launchPriceEur;
    }

    public function setLaunchPriceEur(float $launchPriceEur): static
    {
        $this->launchPriceEur = $launchPriceEur;

        return $this;
    }

    public function getLaunchPriceEth(): ?float
    {
        return $this->launchPriceEth;
    }

    public function setLaunchPriceEth(float $launchPriceEth): static
    {
        $this->launchPriceEth = $launchPriceEth;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseNft>
     */
    public function getPurchaseNfts(): Collection
    {
        return $this->purchaseNfts;
    }

    public function addPurchaseNft(PurchaseNft $purchaseNft): static
    {
        if (!$this->purchaseNfts->contains($purchaseNft)) {
            $this->purchaseNfts->add($purchaseNft);
            $purchaseNft->setNft($this);
        }

        return $this;
    }

    public function removePurchaseNft(PurchaseNft $purchaseNft): static
    {
        if ($this->purchaseNfts->removeElement($purchaseNft)) {
            // set the owning side to null (unless already changed)
            if ($purchaseNft->getNft() === $this) {
                $purchaseNft->setNft(null);
            }
        }

        return $this;
    }
}
