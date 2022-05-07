<?php

namespace App\Exceptions\File;


use Illuminate\Http\Response;

class FileNotExcluded extends FileException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.file.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
