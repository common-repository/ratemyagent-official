<?php

namespace Rma\Options\Exceptions;

use Exception;

class OptionNotFoundException extends Exception
{
    private $key;

    public function __construct($key)
    {
        parent::__construct();
        $this->key = $key;
    }

    public function __toString()
    {
        return  printf( __( 'There is no option for : %s', 'ratemyagent-official'), $this->key );
    }
}
