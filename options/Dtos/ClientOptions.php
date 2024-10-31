<?php

namespace Rma\Options\Dtos;


class ClientOptions {
	public ?string $id;
	public ?string $secret;

	public function __construct( ?array $vars = null ) {
		$this->id = $vars['id'] ?? null;
		$this->secret = $vars['secret'] ?? null;
	}

	public function __toString() {
		return json_encode( $this );
	}
}
