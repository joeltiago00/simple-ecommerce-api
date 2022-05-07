<?php

namespace App\Exceptions\Password;

use Illuminate\Http\Response;

class PasswordNotChanged extends PasswordResetException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.password.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
