<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

class LazyStream extends AbstractStream
{
    protected $file;
    protected $mode;

    public function __construct($file, $mode)
    {
        $this->file = $file;
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->openFile();

        return parent::close();
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
        $this->openFile();

        return parent::detach();
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        $this->openFile();

        return parent::getSize();
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
        $this->openFile();

        return parent::tell();
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
        $this->openFile();

        return parent::eof();
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
        $this->openFile();

        return parent::isSeekable();
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        $this->openFile();

        return parent::seek($offset, $whence);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->openFile();

        return parent::rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        $this->openFile();

        return parent::isWritable();
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
        $this->openFile();

        return parent::write($string);
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
        $this->openFile();

        return parent::isReadable();
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        $this->openFile();

        return parent::read($length);
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        $this->openFile();

        return parent::getContents();
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
        $this->openFile();

        return parent::getMetadata($key);
    }

    protected function openFile()
    {
        if ($this->resource === null) {
            $this->resource = fopen($this->file, $this->mode);
        }
    }
}
