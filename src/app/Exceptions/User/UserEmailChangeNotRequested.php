<?php

namespace App\Exceptions\User;

use App\Models\Logging;
use Illuminate\Http\Response;

class UserEmailChangeNotRequested extends UserException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.email.change-not-requested', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
