<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    /**
     * The server parameters.
     *
     * @var mixed[]
     */
    protected $serverParams;

    /**
     * The cookie parameters.
     *
     * @var mixed[]
     */
    protected $cookieParams;

    /**
     * The query parameters.
     *
     * @var mixed[]
     */
    protected $queryParams;

    /**
     * The uploaded files.
     *
     * @var mixed[]
     */
    protected $uploadedFiles;

    /**
     * The attributes.
     *
     * @var mixed[]
     */
    protected $attributes;

    /**
     * Constructor.
     *
     * @param string $protocolVersion The protocol version.
     * @param string $method The method.
     * @param UriInterface $uri The URI.
     * @param string[][] $headers The headers.
     * @param mixed[] $serverParams The server parameters.
     * @param mixed[] $cookieParams The cookie parameters.
     * @param mixed[] $queryParams The query parameters.
     * @param mixed[] $uploadedFiles The uploaded files.
     * @param mixed[] $attributes The attributes.
     */
    public function __construct(
        $protocolVersion,
        $method,
        UriInterface $uri,
        array $headers = [],
        StreamInterface $body = null,
        array $serverParams = [],
        array $cookieParams = [],
        array $queryParams = [],
        array $uploadedFiles = [],
        array $attributes = []
    ) {
        parent::__construct($protocolVersion, $method, $uri, $headers, $body);

        $this->serverParams = $serverParams;
        $this->cookieParams = $cookieParams;
        $this->queryParams = $queryParams;
        $this->uploadedFiles = $uploadedFiles;
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerParams()
    {
        return $this->serverParams;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookieParams()
    {
        return $this->cookieParams;
    }

    /**
     * {@inheritdoc}
     */
    public function withCookieParams(array $cookies)
    {
        $new = clone $this;
        $new->cookieParams = $cookies;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * {@inheritdoc}
     */
    public function withQueryParams(array $query)
    {
        $new = clone $this;
        $new->queryParams = $query;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * {@inheritdoc}
     */
    public function withUploadedfiles(array $uploadedFiles)
    {
        $new = clone $this;
        $new->uploadedFiles = $uploadedFiles;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getParsedBody()
    {
        throw new \RuntimeException('Not yet implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function withParsedBody($data)
    {
        throw new \RuntimeException('Not yet implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $default = null)
    {
        if (!array_key_exists($name, $this->attributes)) {
            return $default;
        }

        return $this->attributes[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function withAttribute($name, $value)
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutAttribute($name)
    {
        $new = clone $this;
        unset($new->attributes[$name]);

        return $new;
    }
}
