<?php

namespace App\Exceptions\Password;

use Illuminate\Http\Response;

class PasswordResetNotFound extends PasswordResetException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.password.reset-not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
