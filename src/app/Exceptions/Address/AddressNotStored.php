<?php

namespace App\Exceptions\Address;

use App\Models\Logging;
use Illuminate\Http\Response;

class AddressNotStored extends AddressException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.address.not-stored', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
