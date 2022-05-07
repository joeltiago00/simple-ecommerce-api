<?php

declare(strict_types=1);

namespace App\Files;

use App\Exceptions\File\FileInvalidExtension;
use App\Files\Contracts\FileInterface;

abstract class File implements FileInterface
{
    /**
     * Extensions allowed
     * @var array
     */
    protected array $extensions_allowed;
    /**
     * Path of file or Base64
     * @var string
     */
    protected string $file;
    /**
     * Name of file
     * @var string
     */
    protected string $name;
    /**
     * Extension file
     * @var string
     */
    protected string $extension;
    /**
     * Folder to save
     * @var string
     */
    protected string $folder;

    /**
     * @param string $file
     * @return string
     */
    protected function setExtensionByFile(string $file): string
    {
        $extension = basename($file);
        $extension = explode('.', $extension);

        return ".{$extension[1]}";
    }

    /**
     * @param string $base64
     * @return string
     */
    protected function setExtensionByBase64(string $base64): string
    {
        $extension = explode(';', $base64);
        $extension = explode('/', $extension[0]);

        return ".{$extension[1]}";
    }

    protected function validateExtension()
    {
        if (!in_array($this->getExtension(), $this->extensions_allowed))
            throw new FileInvalidExtension();
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getFolder(): string
    {
        return $this->folder;
    }
}
