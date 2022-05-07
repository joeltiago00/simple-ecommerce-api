<?php

namespace App\Exceptions\Stub;

use Illuminate\Http\Response;

class StubRepositoryModelNotSet extends StubException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.stub.model-not-set'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
