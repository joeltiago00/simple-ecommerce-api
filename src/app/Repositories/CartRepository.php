<?php

namespace App\Repositories;

use App\Core\Shop\Contracts\CartInterface;
use App\Exceptions\Cart\{
    CartItemNotDeleted,
    CartItemNotStored,
    CartItemNotUpdated,
};
use App\Models\CartItem;
use MongoDB\BSON\ObjectId;

class CartRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(CartItem::class);
    }

    /**
     * @param CartInterface $cart
     * @return CartItem
     * @throws CartItemNotStored
     */
    public function store(CartInterface $cart): CartItem
    {
        try {
            return self::getModel()::create([
                'user_id' => new ObjectId($cart->getUserID()),
                'item_id' => new ObjectId($cart->getItemId()),
                'item_quantity' => $cart->getItemQuantity(),
                'deleted_at' => null
            ]);
        } catch (\Exception $e) {
            throw new CartItemNotStored($e);
        }
    }

    /**
     * @param CartItem $cart_item
     * @return bool
     * @throws CartItemNotDeleted
     */
    public function destroy(CartItem $cart_item): bool
    {
        try {
            return $cart_item->delete();
        } catch (\Exception $e) {
            throw new CartItemNotDeleted($e);
        }
    }

    /**
     * @param CartItem $cart_item
     * @param int $quantity
     * @return bool
     * @throws CartItemNotUpdated
     */
    public function update(CartItem $cart_item, int $quantity): bool
    {
        try {
            return $cart_item->update(['quantity' => $quantity]);
        } catch (\Exception $e) {
            throw new CartItemNotUpdated($e);
        }
    }
}
