<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['category:read','nft:read']],
    denormalizationContext: ['groups' => 'nft:write', 'nft:update']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['nft:read', 'category:read', 'nft:update'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'category:read', 'nft:update'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'category:read', 'nft:update'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Nft::class)]
    #[Groups(['nft:read', 'category:read', 'nft:update'])]

    private Collection $nfts;

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Nft>
     */
    public function getNfts(): Collection
    {
        return $this->nfts;
    }

    public function addNft(Nft $nft): static
    {
        if (!$this->nfts->contains($nft)) {
            $this->nfts->add($nft);
            $nft->setCategory($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getCategory() === $this) {
                $nft->setCategory(null);
            }
        }

        return $this;
    }
}
