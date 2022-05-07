<?php

namespace App\Exceptions\Session;


use Illuminate\Http\Response;

class SessionNotCreated extends SessionException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.session.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
