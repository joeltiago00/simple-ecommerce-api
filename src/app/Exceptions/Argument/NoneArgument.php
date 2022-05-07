<?php

namespace App\Exceptions\Argument;


use Illuminate\Http\Response;

class NoneArgument extends ArgumentException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.argument.none'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
