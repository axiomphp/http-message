<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;

class UploadedFile implements UploadedFileInterface
{
    /**
     * The stream.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * The path.
     *
     * @var string
     */
    protected $path;

    /**
     * The size.
     *
     * @var int
     */
    protected $size;

    /**
     * The error.
     *
     * @var int
     */
    protected $error;

    /**
     * The client filename.
     *
     * @var string
     */
    protected $clientFilename;

    /**
     * The client media type.
     *
     * @var string
     */
    protected $clientMediaType;

    /**
     * Constructor.
     *
     * @param mixed[] $file The file data.
     */
    public function __construct(array $file)
    {
        $this->stream = new LazyStream($file['tmp_name'], 'r');
        $this->path = $file['tmp_name'];
        $this->size = $file['size'];
        $this->error = $file['error'];
        $this->clientFilename = $file['name'];
        $this->clientMediaType = $file['type'];
    }

    /**
     * {@inheritdoc}
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * {@inheritdoc}
     */
    public function moveTo($targetPath)
    {
        if (move_uploaded_file($this->path, $targetPath) === false) {
            throw new RuntimeException(sprintf(
                'Could not move uploaded file from %s to %s',
                $this->path,
                $targetPath
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientFilename()
    {
        return $this->clientFilename;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientMediaType()
    {
        return $this->clientMediaType;
    }
}
