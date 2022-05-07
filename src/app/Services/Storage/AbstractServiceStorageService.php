<?php

declare(strict_types=1);

namespace App\Services\Storage;

use App\Files\Contracts\FileInterface;
use App\Services\Storage\Contracts\ServiceStorageInterface;
use Exception;

abstract class AbstractServiceStorageService implements ServiceStorageInterface
{
    /**
     * @param FileInterface $file
     * @return mixed
     */
    abstract function putObject(FileInterface $file);

    /**
     * @param FileInterface $file
     * @return mixed
     */
    abstract function deleteObject(FileInterface $file);

    /**
     * @return array
     * @throws Exception
     */
    abstract function getObjectsList(): array;

    /**
     * @return string
     */
    abstract function getUrl(): string;

    /**
     * @return string
     */
    abstract function getVersionId(): string;
}
