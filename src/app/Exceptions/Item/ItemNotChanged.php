<?php

namespace App\Exceptions\Item;


use Illuminate\Http\Response;

class ItemNotChanged extends ItemException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.item.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
