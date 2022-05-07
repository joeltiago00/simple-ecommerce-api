<?php

namespace App\Exceptions\User;

use Illuminate\Http\Response;
use function trans;

class UserEmailNotChanged extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.email.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
