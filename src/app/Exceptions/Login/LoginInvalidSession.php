<?php

namespace App\Exceptions\Login;

use Illuminate\Http\Response;

class LoginInvalidSession extends LoginException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.session.invalid-session'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
