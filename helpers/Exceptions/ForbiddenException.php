<?php

namespace Rma\Helpers\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    private string $path;

    public function __construct(string $key)
    {
        parent::__construct();
        $this->path = $key;
    }

    public function __toString()
    {
        return  printf( __( 'You do not have permission to view that asset', 'ratemyagent-official'), $this->path );
    }
}
