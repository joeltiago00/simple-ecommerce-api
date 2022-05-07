<?php

namespace App\Exceptions\Base64;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class Base64Invalid extends Base64Exception
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.general.invalid-base64')
        );
    }
}
