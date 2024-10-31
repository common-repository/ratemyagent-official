<?php

namespace Rma\Options;

use Rma\Options\Dtos\ClientOptions;
use Rma\Options\Dtos\Options;
use Rma\Options\Dtos\ProfileOptions;
use Rma\Options\Dtos\ReviewThemeOptions;
use Rma\Options\Exceptions\OptionNotFoundException;

class RmaOptions
{

	private static $instance;

	private const OPTION_KEY = 'rma-plugin-settings';

	public static function setup_options(): void
	{
		add_option(self::OPTION_KEY, json_encode(new Options()));
	}

	public static function is_setup(): bool
	{
		return isset(self::get_options()->region);
	}

	// Getters
	public static function get_options(): Options
	{
		if (self::$instance === null) {
			$options        = json_decode(get_option(self::OPTION_KEY), true);
			self::$instance = new Options($options);
		}

		return self::$instance;
	}

	// Setters
	public static function set_profile_options(string $type, string $code): void
	{
		$options          = self::get_options();
		$options->profile = new ProfileOptions(compact('type', 'code'));
		self::update($options);
	}

	public static function set_client_options(string $id, string $secret): void
	{
		$options         = self::get_options();
		$options->client = new ClientOptions(compact('id', 'secret'));
		self::update($options);
	}

	public static function set_region(string $value): void
	{
		$options         = self::get_options();
		$options->region = $value;
		self::update($options);
	}

	public static function set_rating_limit(int $value): void
	{
		$options        		= self::get_options();
		$options->rating_limit 	= $value;
		self::update($options);
	}

	public static function set_cache_duration(string $value): void
	{
		$options                 = self::get_options();
		$options->cache_duration = $value;
		self::update($options);
	}

	public static function set_review_theme(array $theme): void
	{
		$options               = self::get_options();
		$options->review_theme = new ReviewThemeOptions($theme);
		self::update($options);
	}

	public static function set_setup_complete(bool $complete): void
	{
		$options                 = self::get_options();
		$options->setup_complete = $complete;
		self::update($options);
	}


	public static function reset(): void
	{
		$options = self::$instance = new Options();
		self::update($options);
	}

	// helpers
	public static function update(Options $options): void
	{
		update_option(self::OPTION_KEY, json_encode($options));
		self::$instance = $options;
	}
}
