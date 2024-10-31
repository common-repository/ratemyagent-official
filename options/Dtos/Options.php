<?php

namespace Rma\Options\Dtos;


class Options {
	public ProfileOptions $profile;
	public ClientOptions $client;
	public ReviewThemeOptions $review_theme;
	public bool $setup_complete;
	public string $cache_duration;
	public int $rating_limit;
	public ?string $region;

	public function __construct( ?array $vars = null ) {
		$this->profile        = new ProfileOptions( $vars['profile'] ?? null );
		$this->client         = new ClientOptions( $vars['client'] ?? null );
		$this->review_theme   = new ReviewThemeOptions( $vars['review_theme'] ?? null );
		$this->rating_limit   = $vars['rating_limit'] ?? 1;
		$this->region         = $vars['region'] ?? null;
		$this->cache_duration = $vars['cache_duration'] ?? '604800';
		$this->setup_complete = $vars['setup_complete'] ?? false;
	}

	public function __toString() {
		return json_encode( $this );
	}
}
