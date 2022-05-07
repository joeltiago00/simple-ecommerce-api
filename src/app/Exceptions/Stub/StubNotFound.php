<?php

namespace App\Exceptions\Stub;

use Illuminate\Http\Response;

class StubNotFound extends StubException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.stub.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
