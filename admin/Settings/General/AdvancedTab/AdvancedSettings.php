<?php

namespace Rma\Admin\Settings\General\AdvancedTab;

use Rma\Helpers\TemplateHelpers;
use Rma\Cache\Cache;
use Rma\Options\RmaOptions;

class AdvancedSettings
{
	private static array $INPUTS = [
		'duration'      			=> 'rma_cache_duration',
		'rating_limit'      		=> 'rma_rating_limit',
		'update_advanced_config'	=> 'update_advanced_config',
		'update_action' 			=> 'rma_admin_update_cache_settings',
		'clear_action'  			=> 'rma_admin_clear_cache',
	];

	public static function handle_tab(): string
	{
		$template      = dirname(__FILE__) . '/partial.php';
		$cache         = Cache::get_instance();
		$hasPermission = $cache->check_folder_permissions();
		$notification  = self::process_actions($cache, $hasPermission);

		$data = [
			'inputs'        	=> (object) self::$INPUTS,
			'duration'      	=> RmaOptions::get_options()->cache_duration,
			'ratingLimit'     	=> RmaOptions::get_options()->rating_limit,
			'hasPermission' 	=> $hasPermission,
			'cacheFolder'   	=> $cache->get_cache_path(),
			'notification'  	=> $notification,
		];

		return TemplateHelpers::render_partial($template, $data);
	}

	private static function process_actions(Cache $cache, bool $hasPermission): ?string
	{
		$inputs = (object) self::$INPUTS;
		if (!$hasPermission) {
			return TemplateHelpers::notification('error', __('We could not access the cache folder'), false);
		}

		if (self::hasAction($inputs->update_action)) {
			self::update_cache_details($_POST[$inputs->duration]);

			return TemplateHelpers::notification('success', __('Cache details has updated', 'ratemyagent-official'));
		}

		if (self::hasAction($inputs->update_advanced_config)) {
			self::update_advanced_config($_POST[$inputs->rating_limit]);

			return TemplateHelpers::notification('success', __('Configuration has updated', 'ratemyagent-official'));
		}

		if (self::hasAction($inputs->clear_action)) {
			self::clear_cache($cache);

			return TemplateHelpers::notification('success', __('Cache has been clear', 'ratemyagent-official'));
		}

		return null;
	}

	private static function update_advanced_config(int $rating_limit): void
	{
		RmaOptions::set_rating_limit($rating_limit);
	}

	private static function update_cache_details(string $duration): void
	{
		RmaOptions::set_cache_duration($duration);
	}

	private static function clear_cache(Cache $cache): void
	{
		$cache->clear();
	}

	private static function hasAction($action): bool
	{
		return isset($_POST[$action]) && $_POST[$action] === 'true';
	}
}
