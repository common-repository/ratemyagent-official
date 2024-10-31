<?php

namespace Rma\DataAccess\Exceptions;

use Exception;

class MissingCredentialsException extends Exception {
	public function __construct() {
		parent::__construct();
	}

	public function __toString(): string {
		return __( 'Please enter your API credentials in the RateMyAgent settings', 'ratemyagent-official');
	}
}
