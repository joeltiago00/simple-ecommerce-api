<?php

namespace App\Exceptions\Cart;

use Illuminate\Http\Response;

class CartItemNotExcluded extends CartException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.cart_item.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
