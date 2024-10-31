<?php

namespace Rma\Admin\Settings\General\SettingsTab;

use Exception;
use Rma\DataAccess\AgencyRosterApi;
use Rma\Helpers\TemplateHelpers;
use Rma\DataAccess\Authorization;
use Rma\Helpers\ProfileTypes;
use Rma\Options\RmaOptions;

class Settings {

	private const INPUTS = [
		'region'        => 'rma-settings-region',
		'profile_code'  => 'rma-profile-code',
		'profile_type'  => 'rma-profile-type',
		'client_id'     => 'rma-client-id',
		'client_secret' => 'rma-client-secret',
		'update_action' => 'rma_admin_update_api_settings',
		'test_action'   => 'rma_test_api_access',
		'reset_action'  => 'rma_reset_api_details',
	];

	public static function handle_tab(): string {
		$path         = dirname( __FILE__ ) . '/partial.php';
		$fields       = (object) self::INPUTS;
		$notification = self::handle_actions();
		$options      = RmaOptions::get_options();

		$data = [
			'options'       => $options,
			'notification'  => $notification,
			'profile_types' => ProfileTypes::get_profile_types( $options->region ),
			'inputs'        => $fields,
			'debug'         => isset( $_GET['debug'] ) && wp_validate_boolean( $_GET['debug'] ),
		];

		return TemplateHelpers::render_partial( $path, $data );
	}

	private static function test_token( $client_id, $client_secret ): void {
		$auth = new Authorization();
		$auth->test_token( $client_id, $client_secret );
	}

	private static function test_credentials(): string {
		$options = RmaOptions::get_options();
		try {
			self::test_token( $options->client->id, $options->client->secret );

			return TemplateHelpers::notification( 'success', __( 'API credentials working correctly', 'ratemyagent-official' ) );
		} catch ( Exception $e ) {
			return TemplateHelpers::notification( 'error', $e );
		}
	}

	private static function reset_credentials(): string {
		try {
			RmaOptions::reset();

			return TemplateHelpers::notification( 'success', __( 'API details reset', 'ratemyagent-official' ) );
		} catch ( Exception $e ) {
			return TemplateHelpers::notification( 'error', $e );
		}
	}

	private static function attempt_update( $client_id, $client_secret, $region, $profile_type, $profile_code ): string {
		try {
			self::test_token( $client_id, $client_secret );
			self::update_options( $client_id, $client_secret, $region, $profile_type, $profile_code );

			return TemplateHelpers::notification( 'success', __( 'API credentials updated and working correctly', 'ratemyagent-official' ) );
		} catch ( Exception $e ) {
			return TemplateHelpers::notification( 'error', $e );
		}
	}

	private static function update_options( $id, $secret, $region, $profile_type, $profile_code ): void {
		RmaOptions::set_region( $region );
		RmaOptions::set_client_options( $id, $secret );
		RmaOptions::set_profile_options( $profile_type, $profile_code );
	}

	private static function hasAction( $action ): bool {
		return isset( $_POST[ $action ] ) && wp_validate_boolean( $_POST[ $action ] );
	}

	private static function handle_actions(): ?string {
		$notification = null;
		$fields       = (object) self::INPUTS;

		if ( self::hasAction( $fields->update_action ) ) {
			$client_id     = sanitize_text_field( $_POST[ $fields->client_id ] );
			$client_secret = sanitize_text_field( $_POST[ $fields->client_secret ] );
			$region        = sanitize_text_field( $_POST[ $fields->region ] );
			$profile_type  = sanitize_text_field( $_POST[ $fields->profile_type ] );
			$profile_code  = sanitize_text_field( $_POST[ $fields->profile_code ] );

			$notification = self::attempt_update( $client_id, $client_secret, $region, $profile_type, $profile_code );
		}

		if ( self::hasAction( $fields->test_action ) ) {
			$notification = self::test_credentials();
		}

		if ( self::hasAction( $fields->reset_action ) ) {
			$notification = self::reset_credentials();
		}

		return $notification;
	}

}
