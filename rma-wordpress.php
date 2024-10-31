<?php

/**
 * Plugin Name: RateMyAgent Official
 * Plugin URI: https://wordpress-widget.ratemyagent.com.au/
 * Description: Tools for bringing RateMyAgent into your WordPress
 * Author: RateMyAgent
 * Author URI: https://www.ratemyagent.com
 * Version: 1.4.0
 * Requires PHP: 8.0
 * Requires at least: 6.6.1
 * Text Domain: ratemyagent-official
 *
 * @package ratemyagent-official
 */

use Rma\Admin\AdminLoader;
use Rma\Blocks\BlocksLoader;
use Rma\InternalApi\InternalApiLoader;
use Rma\Options\RmaOptions;
use Rma\StaticAssets\RmaStaticAssets;

define('RMA_PLUGIN_VERSION', '1.4.0');

defined('ABSPATH') || exit;

require_once 'vendor/autoload.php';

class RmaWordpressPlugin
{
	const NOTIFICATION_TRANSIENT = 'rma-plugin-installation-message';

	public function __construct()
	{
		$this->register_translations();

		RmaOptions::setup_options();
		RmaStaticAssets::register_static();

		new BlocksLoader();

		new InternalApiLoader();

		if (is_admin()) {
			$this->load_admin_functionality();
			$this->add_block_category();
		}
	}

	private function register_translations(): void
	{
		add_action('init', [self::class, 'plugin_load_textdomain']);
	}

	private function add_block_category(): void
	{
		add_filter('block_categories_all', [self::class, 'add_rma_category'], 10, 2);
	}

	private function load_admin_functionality(): void
	{
		new AdminLoader();
		add_filter(
			'plugin_action_links_' . basename(dirname(__FILE__)) . '/rma-wordpress.php',
			[self::class, 'add_settings_link_to_plugin_page']
		);
	}


	static function plugin_load_textdomain(): void
	{
		load_plugin_textdomain('ratemyagent', false, basename(dirname(__FILE__)) . '/languages/');
	}

	static function add_settings_link_to_plugin_page($links): array
	{
		$url = esc_url(add_query_arg('page', 'rma-settings', get_admin_url() . 'admin.php'));
		$settings_link = "<a href='$url'>" . __('Settings') . '</a>';
		$links[] = $settings_link;

		return $links;
	}

	public static function add_rma_category($block_categories, $block_editor_context)
	{
		if (!empty($block_editor_context->post)) {
			// We don't want to be first, but we also don't want to be last. So .... third
			array_splice(
				$block_categories,
				3,
				0,
				[
					[
						'slug' => 'ratemyagent',
						'title' => __('RateMyAgent', 'ratemyagent-official'),
						'icon' => null,
					]
				]
			);
		}

		return $block_categories;
	}

}

new RmaWordpressPlugin();
