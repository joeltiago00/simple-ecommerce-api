<?php

namespace App\Exceptions\User;

use Illuminate\Http\Response;
use function trans;

class UserEmailChangeRequestNotCreated extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.email-change-token-not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
