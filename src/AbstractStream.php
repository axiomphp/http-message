<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\StreamInterface;
use RuntimeException;

class AbstractStream implements StreamInterface
{
    /**
     * The resource.
     *
     * @var resource
     */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        try {
            $this->rewind();
            $contents = $this->getContents();
        } catch (RuntimeException $e) {
            $contents = '';
        }

        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if (fclose($this->resource) === false) {
            throw new RuntimeException('Could not close stream');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
        $resource = $this->resource;
        $this->resource = null;

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return fstat($this->resource)['size'];
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
        $position = ftell($this->resource);

        if ($position === false) {
            throw new RuntimeException('Could not determine file pointer position');
        }

        return $position;
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
        return feof($this->resource);
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
        return stream_get_meta_data($this->resource)['seekable'];
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->isSeekable()) {
            throw new RuntimeException('Stream is not seekable');
        }

        if (fseek($this->resource, $offset, $whence) !== 0) {
            throw new RuntimeException(sprintf(
                'Could not seek to offset: %d (whence: %d)',
                $offset,
                $whence
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->seek(0);
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return is_writable(stream_get_meta_data($this->resource)['uri']);
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
        $numBytes = fwrite($this->resource, $string);

        if ($numBytes === false) {
            throw new RuntimeException('Could not write to stream');
        }

        return $numBytes;
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        $contents = stream_get_contents($this->resource);

        if ($contents === false) {
            throw new RuntimeException('Could not retrieve stream contents');
        }

        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
    }
}
