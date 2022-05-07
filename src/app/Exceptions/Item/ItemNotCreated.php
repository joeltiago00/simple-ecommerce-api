<?php

namespace App\Exceptions\Item;

use Illuminate\Http\Response;

class ItemNotCreated extends ItemException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.item.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
