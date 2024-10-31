<?php

namespace Rma\Options\Dtos;

class ProfileOptions {
	public ?string $code;
	public ?string $type;

	public function __construct( ?array $vars = null ) {
		$this->code = $vars['code'] ?? null;
		$this->type = $vars['type'] ?? null;
	}

	public function isAgency(): bool {
		return $this->type === 'agency';
	}

	public function __toString() {
		return json_encode( $this );
	}
}
