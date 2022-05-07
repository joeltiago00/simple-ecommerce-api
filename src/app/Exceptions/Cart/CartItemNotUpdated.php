<?php

namespace App\Exceptions\Cart;

use App\Models\Logging;
use Illuminate\Http\Response;

class CartItemNotUpdated extends CartException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.cart_item.not-updated', ['code_error' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
