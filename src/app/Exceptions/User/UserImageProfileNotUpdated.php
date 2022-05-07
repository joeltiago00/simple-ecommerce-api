<?php

namespace App\Exceptions\User;

use Illuminate\Http\Response;

class UserImageProfileNotUpdated extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.image.not-updated'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
