<?php

namespace App\Http\Controllers;

use App\Core\Shop\Cart;
use App\Models\Item;
use App\Exceptions\Cart\{
    CartItemNotAdded,
    CartItemNotDeleted,
    CartItemNotExcluded,
    CartItemNotQuantityNotUpdated,
    CartItemNotStored,
    CartItemNotUpdated,
};
use App\Helpers\ResponseHelper;
use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Models\User;
use App\Repositories\CartRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new CartRepository();
    }

    /**
     * @param CartRequest $request
     * @param Item $item
     * @return JsonResponse
     * @throws CartItemNotAdded
     * @throws CartItemNotStored
     */
    public function store(CartRequest $request, Item $item): JsonResponse
    {
        $cart = new Cart((string)$request->user_id, (string)$item->_id, $request->item_quantity);

        if (!$model = $this->repository->store($cart))
            throw new CartItemNotAdded();

        return ResponseHelper::created(['message' => trans('cart.item.added')]);
    }

    /**
     * @param CartRequest $request
     * @param CartItem $cart_item
     * @return JsonResponse
     * @throws CartItemNotQuantityNotUpdated
     * @throws CartItemNotUpdated
     */
    public function update(CartRequest $request, CartItem $cart_item): JsonResponse
    {
        if (!$this->repository->update($cart_item, $request->quantity))
            throw new CartItemNotQuantityNotUpdated();

        return ResponseHelper::results(['message' => trans('cart.item.quantity-updated')]);
    }

    /**
     * @param CartItem $cart_item
     * @return JsonResponse
     * @throws CartItemNotExcluded
     * @throws CartItemNotDeleted
     */
    public function destroy(CartItem $cart_item): JsonResponse
    {
        if (!$this->repository->destroy($cart_item))
            throw new CartItemNotExcluded();

        return ResponseHelper::results(['message' => trans('cart.item.destroyed')]);
    }
}
