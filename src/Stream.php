<?php
declare(strict_types=1);

namespace AxiomPhp\Http\Message;

class Stream extends AbstractStream
{
    public function __construct($resource)
    {
        $this->resource = $resource;
    }
}
