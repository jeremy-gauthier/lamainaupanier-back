<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"categories:list", "category:show", "producttypes:list", "producttype:show", "products:list", "product:show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"categories:list", "category:show", "producttypes:list", "producttype:show", "products:list", "product:show"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ProductType::class, mappedBy="category", orphanRemoval=true)
     * @Groups({"categories:list", "category:show"})
     */
    private $productTypes;

    public function __construct()
    {
        $this->productTypes = new ArrayCollection();
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

    /**
     * @return Collection|ProductType[]
     */
    public function getProductTypes(): Collection
    {
        return $this->productTypes;
    }

    public function addProductType(ProductType $productType): self
    {
        if (!$this->productTypes->contains($productType)) {
            $this->productTypes[] = $productType;
            $productType->setCategory($this);
        }

        return $this;
    }

    public function removeProductType(ProductType $productType): self
    {
        if ($this->productTypes->contains($productType)) {
            $this->productTypes->removeElement($productType);
            // set the owning side to null (unless already changed)
            if ($productType->getCategory() === $this) {
                $productType->setCategory(null);
            }
        }

        return $this;
    }
}
