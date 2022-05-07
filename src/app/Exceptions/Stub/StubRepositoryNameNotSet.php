<?php

namespace App\Exceptions\Stub;

use Exception;
use Illuminate\Http\Response;

class StubRepositoryNameNotSet extends StubException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.stub.name-not-set'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
