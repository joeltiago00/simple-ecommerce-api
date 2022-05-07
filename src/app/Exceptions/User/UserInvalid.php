<?php

namespace App\Exceptions\User;

use Illuminate\Http\Response;

class UserInvalid extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.invalid'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
