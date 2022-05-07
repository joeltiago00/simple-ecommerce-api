<?php

namespace App\Exceptions\File;


use Illuminate\Http\Response;

class FileInvalidExtension extends FileException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.file.invalid-extension'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
