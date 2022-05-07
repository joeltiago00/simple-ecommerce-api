<?php

namespace App\Exceptions\Address;


use Illuminate\Http\Response;

class AddressNotCreated extends AddressException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.address.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
