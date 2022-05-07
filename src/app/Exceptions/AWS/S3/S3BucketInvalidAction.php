<?php

namespace App\Exceptions\AWS\S3;

class S3BucketInvalidAction extends \Exception
{

    public function __construct(\Throwable $e)
    {
    }
}
