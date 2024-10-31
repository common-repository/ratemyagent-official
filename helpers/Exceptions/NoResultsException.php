<?php

namespace Rma\Helpers\Exceptions;

use Exception;

class NoResultsException extends Exception
{
    private string $path;

    public function __construct(string $key)
    {
        parent::__construct();
        $this->path = $key;
    }

    public function __toString()
    {
        return  printf( __( 'No Results where returned from Dev API for : %s', 'ratemyagent-official'), $this->path );
    }
}
