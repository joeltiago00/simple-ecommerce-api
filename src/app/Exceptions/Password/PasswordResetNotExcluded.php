<?php

namespace App\Exceptions\Password;

use Exception;
use Illuminate\Http\Response;

class PasswordResetNotExcluded extends Exception
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.password.reset-not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
