<?php

namespace App\Core\Shop\Contracts;

interface CartInterface
{
    public function getUserID(): string;

    public function getItemId(): string;

    public function getItemQuantity(): int;
}
