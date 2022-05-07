<?php

namespace App\Exceptions\Password;

use App\Models\Logging;
use Illuminate\Http\Response;

class PasswordResetNotExpired extends PasswordResetException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.password.token-not-expired', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}