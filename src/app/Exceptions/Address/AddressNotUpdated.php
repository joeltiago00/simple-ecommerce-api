<?php

namespace App\Exceptions\Address;


use Illuminate\Http\Response;

class AddressNotUpdated extends AddressException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.address.not-updated'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
