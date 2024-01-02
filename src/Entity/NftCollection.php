<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NftCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NftCollectionRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['collection:read','nft:read']])]
class NftCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('nft:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('nft:read')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable:true)]
    #[Groups('nft:read')]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'nftCollection', targetEntity: Nft::class, orphanRemoval: true)]
    #[Groups('nft:read')]
    private Collection $Nft;

    public function __construct()
    {
        $this->Nft = new ArrayCollection();
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
    public function getNft(): Collection
    {
        return $this->Nft;
    }

    public function addNft(Nft $nft): static
    {
        if (!$this->Nft->contains($nft)) {
            $this->Nft->add($nft);
            $nft->setNftCollection($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): static
    {
        if ($this->Nft->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getNftCollection() === $this) {
                $nft->setNftCollection(null);
            }
        }

        return $this;
    }
}
