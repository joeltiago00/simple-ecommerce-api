<?php

namespace App\Exceptions\User;


use App\Models\Logging;
use Illuminate\Http\Response;

class UserNotStored extends UserException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.not-stored', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
