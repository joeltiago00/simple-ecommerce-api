<?php

namespace App\Core\Shop\Contracts;

interface ItemInterface
{
    public function getName(): string;

    public function getPrice(): float;

    public function getQuantity(): int;

    public function getCategory(): string;

    public function isPhysical(): bool;

    public function getWeight(): float;

    public function getColor(): string;

    public function getBrand(): string;

    public function getModel(): string;

    public function getDescription(): string;
}
