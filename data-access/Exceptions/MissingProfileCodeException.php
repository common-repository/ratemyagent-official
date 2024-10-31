<?php

namespace Rma\DataAccess\Exceptions;

use Exception;

class MissingProfileCodeException extends Exception {
	public function __construct() {
		parent::__construct();
	}

	public function __toString(): string {
		return __( 'Please add your profile code.', 'ratemyagent-official');
	}
}
