<?php

declare(strict_types=1);

namespace App\Services\Storage\AWSS3BucketService;

use App\Exceptions\AWS\S3\S3BucketFailGetObjects;
use App\Exceptions\AWS\S3\S3BucketInvalidAction;
use App\Files\Contracts\FileInterface;
use App\Models\Logging;
use App\Services\Storage\AbstractServiceStorageService;
use Aws\Result;
use Aws\S3\S3Client;
use Exception;
use function config;

class AWSS3BucketService extends AbstractServiceStorageService
{
    /**
     * Instance of S3Client
     * @var S3Client
     */
    private S3Client $s3;

    /**
     * Response upload from S3
     * @var Result
     */
    private Result $uploadResponse;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => config('aws.bucket.default_region'),
            'credentials' => [
                'key' => config('aws.bucket.access_key'),
                'secret' => config('aws.bucket.secret_access_key')
            ]]);
    }

    /**
     * @param FileInterface $file
     * @return bool
     */
    public function putObject(FileInterface $file): bool
    {
        try {
            $this->uploadResponse = $this->s3->putObject([
                'Bucket' => config('aws.bucket.name'),
                'Key' => sprintf('%s.%s', $file->getName(), $file->getExtension()),
                'SourceFile' => $file->getFile(),
            ]);
        } catch (Exception $e) {
            Logging::critical($e);
            return false;
        }

        return true;
    }

    /**
     * @param FileInterface $file
     * @return bool
     */
    public function deleteObject(FileInterface $file): bool
    {
        try {
            $this->s3->deleteObject([
                'Bucket' => config('aws.bucket.name'),
                'Key' => $file->getName()
            ]);
        } catch (Exception $e) {
            Logging::critical($e);
            return false;
        }

        return true;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getObjectsList(): array
    {
        try {
            $objects = $this->s3->listObjects([
                'Bucket' => config('aws.bucket.name')
            ]);
        } catch (Exception $e) {
            throw new S3BucketFailGetObjects($e);
        }

        return $objects;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getURL(): string
    {
        return $this->uploadResponse['ObjectURL'] ??
            throw new S3BucketInvalidAction();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getVersionId(): string
    {
        return $this->uploadResponse['VersionId'] ??
            throw new S3BucketInvalidAction();
    }
}
