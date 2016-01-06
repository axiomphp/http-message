<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

class Response extends AbstractMessage implements ResponseInterface
{
    /**
     * The default protocol version.
     *
     * @var string
     */
    const DEFAULT_PROTOCOL_VERSION = '1.1';

    /**
     * The status code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * The reason phrase.
     *
     * @var string
     */
    protected $reasonPhrase;

    /**
     * Constructor.
     *
     * @param string $protocolVersion The protocol version.
     * @param int $statusCode The status code.
     * @param string $reasonPhrase The reason phrase.
     * @param string[][] $headers The headers.
     * @param StreamInterface $body The body.
     */
    public function __construct(
        $protocolVersion = self::DEFAULT_PROTOCOL_VERSION,
        $statusCode = StatusCode::OK,
        $reasonPhrase = '',
        array $headers = [],
        StreamInterface $body = null
    ) {
        parent::__construct($protocolVersion, $headers, $body);

        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase === '' ? StatusCode::$reasonPhrase[$statusCode] : $reasonPhrase;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $new = clone $this;
        $new->statusCode = $code;
        $new->reasonPhrase = $reasonPhrase === '' ? StatusCode::$reasonPhrase[$statusCode] : $reasonPhrase;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * {@inheritdoc}
     */
    public function isInformational(): bool
    {
        return $this->statusCode >= 100 && $this->statusCode < 200;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccess(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * {@inheritdoc}
     */
    public function isRedirection(): bool
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    /**
     * {@inheritdoc}
     */
    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * {@inheritdoc}
     */
    public function isServerError(): bool
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    /**
     * {@inheritdoc}
     */
    public function isError(): bool
    {
        return $this->isClientError() || $this->isServerError();
    }

    /**
     * {@inheritdoc}
     */
    protected function getStartLine(): string
    {
        return sprintf(
            "HTTP/%s %d %s\r\n",
            $this->protocolVersion,
            $this->statusCode,
            $this->reasonPhrase
        );
    }
}
