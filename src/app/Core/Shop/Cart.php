<?php

namespace App\Core\Shop;

use App\Core\Shop\Contracts\CartInterface;

class Cart implements CartInterface
{
    /**
     * @var string
     */
    private string $userID;
    /**
     * @var string
     */
    private string $itemID;
    /**
     * @var int
     */
    private int $itemQuantity;

    /**
     * @param string $userID
     * @param string $itemID
     * @param int $itemQuantity
     */
    public function __construct(string $userID, string $itemID, int $itemQuantity)
    {
        $this->userID = $userID;
        $this->itemID = $itemID;
        $this->itemQuantity = $itemQuantity;
    }

    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->userID;
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemID;
    }

    /**
     * @return int
     */
    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }
}
