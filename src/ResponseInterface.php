<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseInterface extends
    MessageInterface,
    PsrResponseInterface
{
    public function isInformational(): bool;
    public function isSuccess(): bool;
    public function isRedirection(): bool;
    public function isClientError(): bool;
    public function isServerError(): bool;
    public function isError(): bool;
}
