<?php

namespace App\Exceptions\Password;


use Illuminate\Http\Response;

class PasswordResetTokenExpired extends PasswordResetException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.password.token-expired'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
