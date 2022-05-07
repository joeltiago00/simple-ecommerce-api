<?php

namespace App\Exceptions\Mail;


use Illuminate\Http\Response;

class MailNotSent extends MailException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.general.mail-not-sent'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
