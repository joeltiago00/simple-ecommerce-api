<?php

namespace App\Exceptions\Item;


use Illuminate\Http\Response;

class ItemNotExcluded extends ItemException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.item.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
