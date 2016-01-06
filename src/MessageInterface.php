<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

use Psr\Http\Message\MessageInterface as PsrMessageInterface;

interface MessageInterface extends PsrMessageInterface
{
    /**
     * Retrieves the string representation of the message.
     *
     * @return string
     */
    public function __toString(): string;
}
