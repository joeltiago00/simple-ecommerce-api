<?php

namespace App\Files\Contracts;

interface FileInterface
{
    public function getFile(): string;

    public function getName(): string;

    public function getExtension(): string;

    public function getFolder(): string;
}
