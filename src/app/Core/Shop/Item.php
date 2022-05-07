<?php

namespace App\Core\Shop;

use App\Core\Shop\Contracts\ItemInterface;

class Item implements ItemInterface
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var float
     */
    private float $price;
    /**
     * @var int
     */
    private int $quantity;
    /**
     * @var string
     */
    private string $category;
    /**
     * @var bool
     */
    private bool $isPhysical;
    /**
     * @var float
     */
    private float $weight;
    /**
     * @var string
     */
    private string $color;
    /**
     * @var string
     */
    private string $brand;
    /**
     * @var string
     */
    private string $model;
    /**
     * @var string
     */
    private string $description;

    /**
     * @param string $name
     * @param float $price
     * @param int $quantity
     * @param string $category
     * @param bool $is_physical
     * @param float $weight
     * @param string $color
     * @param string $brand
     * @param string $model
     * @param string $description
     */
    public function __construct(
        string $name, float $price, int $quantity, string $category, bool $is_physical, float $weight, string $color,
        string $brand, string $model, string $description
    )
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->category = $category;
        $this->isPhysical = $is_physical;
        $this->weight = $weight;
        $this->color = $color;
        $this->brand = $brand;
        $this->model = $model;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return bool
     */
    public function isPhysical(): bool
    {
        return $this->isPhysical;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
