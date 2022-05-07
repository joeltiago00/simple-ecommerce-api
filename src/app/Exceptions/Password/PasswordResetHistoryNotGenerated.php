<?php

namespace App\Exceptions\Password;

use Exception;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class PasswordResetHistoryNotGenerated extends PasswordResetException
{
    public function __construct()
    {
        parent::__construct(
            trans('exception.user.password.history-reset-not-generated'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
