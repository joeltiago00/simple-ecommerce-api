<?php

namespace App\Exceptions\User;


use Illuminate\Http\Response;

class UserEmailChangeNotExcluded extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.email-change-not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
