<?php

namespace App\Core\Storage;

use App\Core\Storage\Contracts\StorageInterface;
use App\Exceptions\File\FileNotExcluded;
use App\Exceptions\File\FileNotUploaded;
use App\Exceptions\File\FilesNotListed;
use App\Files\Contracts\FileInterface;
use App\Services\Storage\AWSS3BucketService\AWSS3BucketService;
use App\Services\Storage\Contracts\ServiceStorageInterface;
use App\Types\StorageProviderTypes;

class Storage implements StorageInterface
{
    /**
     * @var ServiceStorageInterface
     */
    private ServiceStorageInterface $provider;

    public function __construct()
    {
        if (config('files.default_storage_provider') === StorageProviderTypes::S3)
            $this->provider = new AWSS3BucketService();
    }

    /**
     * @param FileInterface $file
     * @return object
     * @throws FileNotUploaded
     * @throws \Exception
     */
    public function putObject(FileInterface $file): object
    {
        if (!$this->provider->putObject($file))
            throw new FileNotUploaded();

        return (object)[
            'url' => $this->provider->getURL(),
            'version_id' => $this->provider->getVersionId()
        ];
    }

    /**
     * @param FileInterface $file
     * @return void
     * @throws FileNotExcluded
     */
    public function deleteObject(FileInterface $file): void
    {
        if (!$this->provider->deleteObject($file))
            throw new FileNotExcluded();
    }

    /**
     * @return array
     * @throws FilesNotListed
     * @throws \Exception
     */
    public function listObjects(): array
    {
        if (!$list = $this->provider->getObjectsList())
            throw new FilesNotListed();

        return $list;
    }

    public function getObject(FileInterface $file): array
    {
        // TODO: Implement getObject() method.
    }
}
