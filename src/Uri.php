<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    /**
     * The scheme.
     *
     * @var string
     */
    protected $scheme;

    /**
     * The user.
     *
     * @var string
     */
    protected $user;

    /**
     * The password.
     *
     * @var string
     */
    protected $password;

    /**
     * The host.
     *
     * @var string
     */
    protected $host;

    /**
     * The port.
     *
     * @var int|null
     */
    protected $port;

    /**
     * The path.
     *
     * @var string
     */
    protected $path;

    /**
     * The query.
     *
     * @var string
     */
    protected $query;

    /**
     * The fragment.
     *
     * @var string
     */
    protected $fragment;

    /**
     * Constructor.
     *
     * @param string $uri The URI.
     */
    public function __construct($uri = '')
    {
        $components = parse_url($uri);

        if ($components === false) {
            throw new InvalidArgumentException(sprintf(
                'Could not parse URI: %s',
                $uri
            ));
        }

        $this->scheme = isset($components['scheme']) ? strtolower($components['scheme']) : '';
        $this->host = isset($components['host']) ? strtolower($components['host']) : '';
        $this->user = isset($components['user']) ? $components['user'] : '';
        $this->password = isset($components['pass']) ? $components['pass'] : '';
        $this->host = isset($components['host']) ? $components['host'] : '';
        $this->port = isset($components['port']) ? $components['port'] : null;
        $this->path = $components['path'];
        $this->query = isset($components['query']) ? $components['query'] : '';
        $this->fragment = isset($components['fragment']) ? $components['fragment'] : '';
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $uri = '';

        if ($this->scheme !== '') {
            $uri .= $this->scheme . '://';
        }

        $authority = $this->getAuthority();

        if ($authority !== '') {
            $uri .= $authority;
        }

        $uri .= $this->path;

        if ($this->query !== '') {
            $uri .= '?' . $this->query;
        }

        if ($this->fragment !== '') {
            $uri .= '#' . $this->fragment;
        }

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * {@inheritdoc}
     */
    public function withScheme($scheme)
    {
        $new = clone $this;
        $new->scheme = strtolower($scheme);

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthority()
    {
        $authority = $this->host;

        if ($authority === '') {
            return '';
        }

        $userInfo = $this->getUserInfo();

        if ($userInfo !== '') {
            $authority = $userInfo . '@' . $authority;
        }

        if ($this->port !== null) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo()
    {
        $userInfo = $this->user;

        if ($userInfo === '') {
            return '';
        }

        if ($this->password !== '') {
            $userInfo .= ':' . $this->password;
        }

        return $userInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function withUserInfo($user, $password = null)
    {
        $new = clone $this;
        $new->user = $user;
        $new->password = $password ?: '';

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function withHost($host)
    {
        $new = clone $this;
        $new->host = strtolower($host);

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * {@inheritdoc}
     */
    public function withPort($port)
    {
        $new = clone $this;
        $new->port = $port;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function withPath($path)
    {
        $new = clone $this;
        $new->path = $path;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function withQuery($query)
    {
        $new = clone $this;
        $new->query = $query;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function withFragment($fragment)
    {
        $new = clone $this;
        $new->fragment = $fragment;

        return $new;
    }
}
