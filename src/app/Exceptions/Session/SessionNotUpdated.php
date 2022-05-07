<?php

namespace App\Exceptions\Session;


use App\Models\Logging;
use Illuminate\Http\Response;

class SessionNotUpdated extends SessionException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.session.not-updated', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
