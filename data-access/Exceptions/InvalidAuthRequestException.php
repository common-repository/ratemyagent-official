<?php

namespace Rma\DataAccess\Exceptions;

use Exception;

class InvalidAuthRequestException extends Exception {
	public function __construct( string $message ) {
		parent::__construct( $message );
	}

	public function __toString(): string {
		return __( 'There was an error making the request. Please check the credentials and try again.', 'ratemyagent-official');
	}
}
