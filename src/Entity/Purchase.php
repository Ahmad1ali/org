<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Amount = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'purchase')]
    private Collection $prodcut;

    #[ORM\ManyToOne(inversedBy: 'Purchase')]
    private ?PurchaseLine $purchaseLine = null;

    public function __construct()
    {
        $this->prodcut = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): static
    {
        $this->Amount = $Amount;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProdcut(): Collection
    {
        return $this->prodcut;
    }

    public function addProdcut(Product $prodcut): static
    {
        if (!$this->prodcut->contains($prodcut)) {
            $this->prodcut->add($prodcut);
            $prodcut->setPurchase($this);
        }

        return $this;
    }

    public function removeProdcut(Product $prodcut): static
    {
        if ($this->prodcut->removeElement($prodcut)) {
            // set the owning side to null (unless already changed)
            if ($prodcut->getPurchase() === $this) {
                $prodcut->setPurchase(null);
            }
        }

        return $this;
    }

    public function getPurchaseLine(): ?PurchaseLine
    {
        return $this->purchaseLine;
    }

    public function setPurchaseLine(?PurchaseLine $purchaseLine): static
    {
        $this->purchaseLine = $purchaseLine;

        return $this;
    }
}
