<?php

namespace App\Exceptions\Respository;


use Illuminate\Http\Response;

class RepositoryNotCreated extends RepositoryException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.general.repository-not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
