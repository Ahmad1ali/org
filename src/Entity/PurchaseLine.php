<?php

namespace App\Entity;

use App\Repository\PurchaseLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseLineRepository::class)]
class PurchaseLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateUpdate = null;

    /**
     * @var Collection<int, Purchase>
     */
    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'purchaseLine')]
    private Collection $Purchase;

    public function __construct()
    {
        $this->Purchase = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): static
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchase(): Collection
    {
        return $this->Purchase;
    }

    public function addPurchase(Purchase $purchase): static
    {
        if (!$this->Purchase->contains($purchase)) {
            $this->Purchase->add($purchase);
            $purchase->setPurchaseLine($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): static
    {
        if ($this->Purchase->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getPurchaseLine() === $this) {
                $purchase->setPurchaseLine(null);
            }
        }

        return $this;
    }
}
