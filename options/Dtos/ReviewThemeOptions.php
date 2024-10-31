<?php

namespace Rma\Options\Dtos;


class ReviewThemeOptions {
	public string $bg;
	public string $pagination;
	public string $star;
	public string $text_primary;
	public string $text_secondary;

	public function __construct( ?array $vars = null ) {
		$this->star           = $vars['star'] ?? '#FBB116';
		$this->text_primary   = $vars['text_primary'] ?? '#1A222C';
		$this->text_secondary = $vars['text_secondary'] ?? '#484E56';
		$this->bg             = $vars['bg'] ?? '#FFFFFF';
		$this->pagination     = $vars['pagination'] ?? '#1A222C';
	}

	public function __toString() {
		return json_encode( $this );
	}
}
