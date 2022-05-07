<?php

namespace App\Exceptions\User;


use Illuminate\Http\Response;

class UserImageProfileHistoryNotCreated extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.image-profile-history-not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
