<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

abstract class StatusCode
{
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NO_CONTENT = 204;

    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const NOT_MODIFIED = 304;

    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const CONFLICT = 409;

    const INTERNAL_SERVER_ERROR = 500;
    const SERVICE_UNAVAILABLE = 503;

    public static $reasonPhrase = [
        // 2xx
        self::OK => 'OK',
        self::CREATED => 'Created',
        self::ACCEPTED => 'Accepted',
        self::NO_CONTENT => 'No Content',

        // 3xx
        self::MOVED_PERMANENTLY => 'Moved Permanently',
        self::FOUND => 'Found',
        self::NOT_MODIFIED => 'Not Modified',

        // 4xx
        self::BAD_REQUEST => 'Bad Request',
        self::UNAUTHORIZED => 'Unauthorized',
        self::FORBIDDEN => 'Forbidden',
        self::NOT_FOUND => 'Not Found',
        self::METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::NOT_ACCEPTABLE => 'Not Acceptable',
        self::CONFLICT => 'Conflict',

        // 5xx
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::SERVICE_UNAVAILABLE => 'Service Unavailable'
    ];
}
