<?php

namespace Rma\DataAccess\Exceptions;

use Exception;

class AuthTokenException extends Exception {

	public function __construct( $message ) {
		parent::__construct( $message );
	}

	public function __toString(): string {
		return __( 'There was an error retrieving the token. Please check the credentials and try again.', 'ratemyagent-official');
	}
}
