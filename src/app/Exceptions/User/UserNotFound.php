<?php

namespace App\Exceptions\User;

use Illuminate\Http\Response;
use function trans;

class UserNotFound extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
