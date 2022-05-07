<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class UserEmailChangeNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.email-change-not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
