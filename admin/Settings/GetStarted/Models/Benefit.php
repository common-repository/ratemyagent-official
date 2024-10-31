<?php

namespace Rma\Admin\Settings\GetStarted\Models;


class Benefit {
	public $icon;
	public $title;
	public $body;

	public function __construct( string $icon, string $title, string $body ) {
		$this->icon  = $icon;
		$this->title = $title;
		$this->body  = $body;
	}
}

