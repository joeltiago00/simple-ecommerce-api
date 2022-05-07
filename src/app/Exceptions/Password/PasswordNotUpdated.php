<?php

namespace App\Exceptions\Password;

use Illuminate\Http\Response;

class PasswordNotUpdated extends PasswordResetException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.password.not-updated'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
