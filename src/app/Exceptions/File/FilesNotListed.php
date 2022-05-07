<?php

namespace App\Exceptions\File;


use Illuminate\Http\Response;

class FilesNotListed extends FileException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.file.not-listed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
