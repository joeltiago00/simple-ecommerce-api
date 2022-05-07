<?php

namespace App\Exceptions\Cart;

use Illuminate\Http\Response;

class CartItemNotQuantityNotUpdated extends CartException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.cart_item.quantity-item-not-updated'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
