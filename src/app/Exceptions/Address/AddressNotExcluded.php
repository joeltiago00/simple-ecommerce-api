<?php

namespace App\Exceptions\Address;


use Illuminate\Http\Response;

class AddressNotExcluded extends AddressException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.address.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
