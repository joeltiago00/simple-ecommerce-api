<?php

namespace App\Exceptions\Address;


use Illuminate\Http\Response;

class AddressNotChanged extends AddressException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.address.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
