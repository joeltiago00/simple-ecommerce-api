<?php

namespace App\Exceptions\Mail;

use App\Exceptions\User\UserException;
use App\Models\Logging;
use Illuminate\Http\Response;
use function trans;

class MailChangeStatusNotUpdated extends UserException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.email-change-status-not-updated', ['error_code' => Logging::critical($e)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
