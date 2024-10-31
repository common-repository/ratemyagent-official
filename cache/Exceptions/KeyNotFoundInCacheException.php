<?php

namespace Rma\Cache\Exceptions;

use Exception;

class KeyNotFoundInCacheException extends Exception {
	public string $key;

	public function __construct( string $key ) {
		parent::__construct();
		$this->key = $key;
	}

	public function __toString(): string {
		return __( 'Key was not found in cache.', 'ratemyagent-official');
	}
}
