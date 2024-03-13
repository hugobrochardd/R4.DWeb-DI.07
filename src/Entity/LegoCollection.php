<?php

namespace App\Entity;

use App\Repository\LegoCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegoCollectionRepository::class)]
class LegoCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Lego::class, mappedBy: 'Collection')]
    private Collection $Collection;

    public function __construct()
    {
        $this->Collection = new ArrayCollection();
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

    /**
     * @return Collection<int, Lego>
     */
    public function getCollection(): Collection
    {
        return $this->Collection;
    }

    public function addCollection(Lego $collection): static
    {
        if (!$this->Collection->contains($collection)) {
            $this->Collection->add($collection);
            $collection->setCollection($this);
        }

        return $this;
    }

    public function removeCollection(Lego $collection): static
    {
        if ($this->Collection->removeElement($collection)) {
            // set the owning side to null (unless already changed)
            if ($collection->getCollection() === $this) {
                $collection->setCollection(null);
            }
        }

        return $this;
    }
}
