<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

class ServerRequestFactory
{
    public function createFromGlobals(): ServerRequestInterface
    {
        list(, $protocolVersion) = explode('/', $_SERVER['SERVER_PROTOCOL']);

        return new ServerRequest(
            $protocolVersion,
            $_SERVER['REQUEST_METHOD'],
            new Uri($_SERVER['REQUEST_URI']),
            $this->prepareHeaders(getallheaders()),
            new LazyStream('php://input', 'r'),
            $_SERVER,
            $_COOKIE,
            $_GET,
            $this->normalizeUploadedFiles($_FILES),
            $_POST
        );
    }

    protected function prepareHeaders(array $headers): array
    {
        $prepHeaderNames = [];
        $prepHeaders = [];

        foreach ($headers as $name => $value) {
            $normalizedName = strtolower($name);

            if (!isset($prepHeaderNames[$normalizedName])) {
                $prepHeaderNames[$normalizedName] = $name;
                $prepHeaders[$name] = [];
            }

            $prepHeaders[$prepHeaderNames[$normalizedName]][] = $value;
        }

        return $prepHeaders;
    }

    protected function normalizeUploadedFiles(array $files): array
    {
        $normalized = [];

        foreach ($files as $key => $value) {
            if (isset($value['tmp_name'])) {
                if (is_array($value['tmp_name'])) {
                    $flipped = [];

                    foreach ($value as $k => $v) {
                        foreach ($v as $index => $actualValue) {
                            $flipped[$index][$k] = $actualValue;
                        }
                    }

                    $normalized[$key] = $this->normalizeUploadedFiles($flipped);
                } else {
                    $normalized[$key] = new UploadedFile($value);
                }
            } else {
                $normalized[$key] = $this->normalizeUploadedFiles($value);
            }
        }

        return $normalized;
    }
}
