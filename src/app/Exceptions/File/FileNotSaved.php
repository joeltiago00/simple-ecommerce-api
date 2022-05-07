<?php

namespace App\Exceptions\File;

use Illuminate\Http\Response;

class FileNotSaved extends FileException
{
    public function __construct(string $code_error)
    {
        parent::__construct(
            trans('exceptions.services.aws-bucket.file-not-saved', ['code_error' => $code_error]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
