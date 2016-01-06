<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\RequestInterface as PsrRequestInterface;

interface RequestInterface extends
    MessageInterface,
    PsrRequestInterface
{
}
