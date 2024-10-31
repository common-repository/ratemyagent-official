<?php

namespace Rma\Admin\SetupWizard;

use Rma\DataAccess\Authorization;
use Rma\DataAccess\Exceptions\MissingCredentialsException;
use Rma\Helpers\ProfileTypes;
use Rma\Helpers\TemplateHelpers;
use Rma\Options\RmaOptions;

class SetupWizardPage
{
	private static int $step = 1;
	private static ?string $notification = null;

	private const MENU_SLUG = 'rma-settings-wizard';
	private const TOTAL = 3;
	private const INPUTS = [
		'region'             => 'rma-settings-region',
		'profile_code'       => 'rma-profile-code',
		'profile_type'       => 'rma-profile-type',
		'client_id'          => 'rma-client-id',
		'client_secret'      => 'rma-client-secret',
		'set_region_action'  => 'rma-wizard-set-region',
		'set_client_action'  => 'rma-wizard-set-client-details',
		'set_profile_action' => 'rma-wizard-set-profile',
	];

	public function __construct()
	{
		add_action('admin_menu', [self::class, 'add_submenu_item']);
		// We don't want this showing up in the navigation
		add_action('admin_head', [self::class, 'hide_submenu_item']);
	}

	public static function add_submenu_item()
	{
		add_submenu_page(
			'rma-settings',
			__('RateMyAgent Setup Wizard'),
			__('Setup Wizard', 'ratemyagent-official'),
			'edit_pages',
			self::MENU_SLUG,
			[self::class, 'render']
		);
	}

	public static function hide_submenu_item(): void
	{
		remove_submenu_page('rma-settings', self::MENU_SLUG);
	}

	public static function render(): void
	{
		self::handle_actions();
		$path    = dirname(__FILE__) . '/partial.php';
		$fields  = (object) self::INPUTS;
		$options = RmaOptions::get_options();

		$data = [
			'options'       => $options,
			'profile_types' => ProfileTypes::get_profile_types($options->region),
			'inputs'        => $fields,
			'step'          => self::$step,
			'total'         => self::TOTAL,
			'notification'  => self::$notification,
		];

		echo TemplateHelpers::render_partial($path, $data);
	}

	private static function handle_actions(): void
	{

	
		if (self::has_action('set_region_action')) {
			self::update_region(self::get_post_value('region'));
			self::$step = 2;
		}

		if (self::has_action('set_client_action')) {
			try {
				$id     = self::get_post_value('client_id');
				$secret = self::get_post_value('client_secret');
				self::update_credentials($id, $secret);
				self::$step = 3;
			} catch (\Exception $e) {
				self::$notification = \Rma\Helpers\TemplateHelpers::notification('error', __('There was an error saving. Please check your credentials.'));
				self::$step = 2;
			}
		}

		if (self::has_action('set_profile_action')) {
			$code = self::get_post_value('profile_code');
			$type = self::get_post_value('profile_type');
			self::update_profile_details($type, $code);
			RmaOptions::set_setup_complete(true);
			self::$step = 4;
		}
	}

	private static function update_region(string $region)
	{
		RmaOptions::set_region($region);
	}

	/**
	 * @throws MissingCredentialsException
	 */
	private static function update_credentials(string $id, string $secret)
	{
		$auth = new Authorization();
		$auth->test_token($id, $secret);

		RmaOptions::set_client_options($id, $secret);
	}

	private static function update_profile_details($type, $code)
	{
		RmaOptions::set_profile_options($type, $code);
	}

	private static function has_action(string $action): bool
	{
		$key = self::INPUTS[$action];

		return isset($_POST[$key]) && wp_validate_boolean($_POST[$key]);
	}

	private static function get_post_value(string $action)
	{
		$key = self::INPUTS[$action];

		return sanitize_text_field($_POST[$key]);
	}
}
