<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "get"={},
 *     "post"={},
 *     },
 *     itemOperations={
 *     "get"={},
 *     "put"={},
 *     "delete"={},
 *     }
 * )
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $enabledFrom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $enabledUntil;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="menu")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEnabledFrom(): ?\DateTimeInterface
    {
        return $this->enabledFrom;
    }

    public function setEnabledFrom(?\DateTimeInterface $enabledFrom): self
    {
        $this->enabledFrom = $enabledFrom;

        return $this;
    }

    public function getEnabledUntil(): ?\DateTimeInterface
    {
        return $this->enabledUntil;
    }

    public function setEnabledUntil(?\DateTimeInterface $enabledUntil): self
    {
        $this->enabledUntil = $enabledUntil;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setMenu($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getMenu() === $this) {
                $product->setMenu(null);
            }
        }

        return $this;
    }
}
