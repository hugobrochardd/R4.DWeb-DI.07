<?php

namespace App\Entity;

class Lego
{
    private int $id;
    private string $name;
    private string $collection;
    private string $description;
    private float $price;
    private int $pieces;
    private string $boxImage;
    private string $legoImage;

    public function __construct(int $id, string $name, string $collection)
    {
        $this->id = $id;
        $this->name = $name;
        $this->collection = $collection;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Lego
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Lego
    {
        $this->name = $name;
        return $this;
    }

    public function getCollection(): string
    {
        return $this->collection;
    }

    public function setCollection(string $collection): Lego
    {
        $this->collection = $collection;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Lego
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Lego
    {
        $this->price = $price;
        return $this;
    }

    public function getPieces(): int
    {
        return $this->pieces;
    }

    public function setPieces(int $pieces): Lego
    {
        $this->pieces = $pieces;
        return $this;
    }

    public function getBoxImage(): string
    {
        return $this->boxImage;
    }

    public function setBoxImage(string $boxImage): Lego
    {
        $this->boxImage = $boxImage;
        return $this;
    }

    public function getLegoImage(): string
    {
        return $this->legoImage;
    }

    public function setLegoImage(string $legoImage): Lego
    {
        $this->legoImage = $legoImage;
        return $this;
    }
}


