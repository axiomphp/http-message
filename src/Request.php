<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends AbstractMessage implements RequestInterface
{
    /**
     * The method.
     *
     * @var string
     */
    protected $method;

    /**
     * The URI.
     *
     * @var UriInterface
     */
    protected $uri;

    /**
     * Constructor.
     *
     * @param string $protocolVersion The protocol version.
     * @param string $method The method.
     * @param UriInterface $uri The URI.
     * @param string[][] $headers The headers.
     * @param StreamInterface $body The body.
     */
    public function __construct(
        $protocolVersion,
        $method,
        UriInterface $uri,
        array $headers = [],
        StreamInterface $body = null
    ) {
        parent::__construct($protocolVersion, $headers, $body);

        $this->method = $method;
        $this->uri = $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget()
    {
        throw new \RuntimeException('Not yet implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function withRequestTarget($requestTarget)
    {
        throw new \RuntimeException('Not yet implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function withMethod($method)
    {
        if ($method === $this->method) {
            return $this;
        }

        $new = clone $this;
        $new->method = $method;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $new = clone $this;
        $new->uri = $uri;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    protected function getStartLine()
    {
        return sprintf(
            "%s %s HTTP/%s\r\n",
            $this->method,
            $this->uri,
            $this->protocolVersion
        );
    }
}
