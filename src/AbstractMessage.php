<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\StreamInterface;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * The protocol version.
     *
     * @var string
     */
    protected $protocolVersion;

    /**
     * The headers.
     *
     * @var string[][]
     */
    protected $headers;

    /**
     * The header names.
     *
     * @var string[]
     */
    protected $headerNames;

    /**
     * The body.
     *
     * @var StreamInterface
     */
    protected $body;

    /**
     * Constructor.
     *
     * @param string $protocolVersion The protocol version.
     * @param string[][] $headers The headers.
     * @param StreamInterface $body The body.
     */
    public function __construct(
        $protocolVersion,
        array $headers = [],
        StreamInterface $body = null
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers;
        $this->body = isset($body) ? $body : new LazyStream('php://memory', 'r+');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        $str = $this->getStartLine();

        foreach ($this->getHeaders() as $name => $values) {
            $str .= sprintf(
                "%s: %s\r\n",
                $name,
                implode(', ', $values)
            );
        }

        $str .= "\r\n";

        $this->body->rewind();
        $str .= $this->body->getContents();

        return $str;
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
        if ($version === $this->protocolVersion) {
            return $this;
        }

        $new = clone $this;
        $new->protocolVersion = $version;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
        return isset($this->headerNames[strtolower($name)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        return $this->headers[$this->headerNames[strtolower($name)]];
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
        if (!$this->hasHeader($name)) {
            return '';
        }

        return implode(', ', $this->getHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
        $new = clone $this;
        $new->headers[$name] = (array)$value;
        $new->headerNames[strtolower($name)] = $name;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        $new = clone $this;

        if (!$new->hasHeader($name)) {
            $new->headers[$name] = [];
            $new->headerNames[strtolower($name)] = $name;
        }

        $new->headers[$name] = array_merge(
            $new->headers[$name],
            (array)$value
        );

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return $this;
        }

        $new = clone $this;

        unset($new->headers[$new->headerNames[strtolower($name)]]);
        unset($new->headerNames[strtolower($name)]);

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
        $new = clone $this;
        $new->body = $body;

        return $new;
    }

    /**
     * Retrieves the start line.
     *
     * @return string
     */
    abstract protected function getStartLine(): string;
}
