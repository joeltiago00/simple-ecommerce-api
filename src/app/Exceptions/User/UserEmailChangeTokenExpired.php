<?php

namespace App\Exceptions\User;


use Illuminate\Http\Response;

class UserEmailChangeTokenExpired extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.email-change-token-expired'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
