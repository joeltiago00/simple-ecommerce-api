<?php

namespace App\Services\Storage\Contracts;

use App\Files\Contracts\FileInterface;

interface ServiceStorageInterface
{
    public function putObject(FileInterface $file);

    public function deleteObject(FileInterface $file);

    public function getObjectsList(): array;

    public function getURL(): string;

    public function getVersionId(): string;
}
