<?php

namespace App\Core\Storage\Contracts;

use App\Files\Contracts\FileInterface;

interface StorageInterface
{
    public function putObject(FileInterface $file): object;

    public function deleteObject(FileInterface $file): void;

    public function listObjects(): array;

    public function getObject(FileInterface $file): array;
}
