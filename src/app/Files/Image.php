<?php
declare(strict_types=1);

namespace App\Files;

use App\Exceptions\File\FileInvalidExtension;

class Image extends File
{
    /**
     * @var array
     */
    protected array $extensions_allowed;
    /**
     * Path of file
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
     * @param array $data = [
     *      (required)'file' => 'Path of file or link', OR 'base64' => 'String Base64',
     *      (required)'name' => 'Name to save file',
     *      (sometimes)'folder' => 'Folder to save'
     *      ];
     * @throws FileInvalidExtension
     */
    public function __construct(array $data)
    {
        $this->file = $data['file'] ?? $data['base64'];
        $this->name = sprintf('%s/%s', $data['folder'], $data['name'] ?? basename($data['file']),
        );
        $this->extension = isset($data['file'])
            ? $this->setExtensionByFile($data['file'])
            : $this->setExtensionByBase64($data['base64']);
        $this->folder = $data['folder'] ?? '';
        $this->extensions_allowed = config('files.extensions_allowed.image');
        $this->validateExtension();
    }
}
