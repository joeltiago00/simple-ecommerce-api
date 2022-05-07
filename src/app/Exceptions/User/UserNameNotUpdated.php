<?php

namespace App\Exceptions\User;


use Illuminate\Http\Response;

class UserNameNotUpdated extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.name-not-updated'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
