<?php

namespace App\Exceptions\Item;

use App\Models\Logging;
use Illuminate\Http\Response;

class ItemNotStored extends ItemException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.item.not-stored', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
