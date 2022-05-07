<?php

namespace App\Exceptions\Cart;

use App\Models\Logging;
use Illuminate\Http\Response;

class CartItemNotStored extends CartException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.cart_item.not-stored', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
