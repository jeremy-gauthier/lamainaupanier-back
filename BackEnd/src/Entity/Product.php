<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use symfony\component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"products:list", "product:show", "product:add", "producer:commands"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"products:list", "product:show", "product:add", "producer:commands"})
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Groups({"products:list", "product:show", "product:add", "producer:commands"})
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $availability;

    /**
     * @ORM\ManyToOne(targetEntity=ProductType::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $product_type;

    /**
     * @ORM\ManyToMany(targetEntity=Label::class, inversedBy="products")
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity=Measure::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $measure;

    /**
     * @ORM\ManyToOne(targetEntity=Producer::class, inversedBy="product")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"products:list", "product:show", "product:add"})
     */
    private $producer;

    /**
     * @ORM\ManyToMany(targetEntity=Command::class, mappedBy="product")
     */
    private $commands;

    public function __construct()
    {
        $this->label = new ArrayCollection();
        $this->commands = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getProductType(): ?ProductType
    {
        return $this->product_type;
    }

    public function setProductType(?ProductType $product_type): self
    {
        //$product_type->addProduct($this);
        $this->product_type = $product_type;

        return $this;
    }

    /**
     * @return Collection|Label[]
     */
    public function getLabel(): Collection
    {
        return $this->label;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->label->contains($label)) {
            $this->label[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        if ($this->label->contains($label)) {
            $this->label->removeElement($label);
        }

        return $this;
    }

    public function getMeasure(): ?Measure
    {
        return $this->measure;
    }

    public function setMeasure(?Measure $measure): self
    {
        $this->measure = $measure;

        return $this;
    }

    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    public function setProducer(?Producer $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->addProduct($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            $command->removeProduct($this);
        }

        return $this;
    }
}
