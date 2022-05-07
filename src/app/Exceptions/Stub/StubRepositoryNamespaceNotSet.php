<?php

namespace App\Exceptions\Stub;

use Exception;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class StubRepositoryNamespaceNotSet extends StubException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.stub.namespace-not-set'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
