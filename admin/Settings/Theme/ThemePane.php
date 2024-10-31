<?php

namespace RMA\Admin\Settings\Theme;

use Rma\Helpers\TemplateHelpers;
use Rma\Options\RmaOptions;

class ThemePane {
	const MENU_SLUG = 'rma-settings-theme';

	private static array $inputs = [
		'star'           => 'rma_review_theme_star',
		'text_primary'   => 'rma_review_theme_text_primary',
		'text_secondary' => 'rma_review_theme_text_secondary',
		'bg'             => 'rma_review_theme_bg',
		'pagination'     => 'rma_review_pagination',
		'update_action'  => 'rma_admin_update_review_theme',
	];

	public function __construct() {
		add_action( 'admin_menu', [ self::class, 'add_submenu_item' ] );
	}

	public static function add_submenu_item() {
		add_submenu_page( 'rma-settings', __( 'RateMyAgent theme settings' ), __( 'Theme', 'ratemyagent-official' ), 'edit_pages', self::MENU_SLUG,
			[ self::class, 'render' ], null );
	}


	public static function render(): void {
		$path         = dirname( __FILE__ ) . '/partial.php';
		$inputs       = (object) self::$inputs;
		$notification = null;

		if ( self::hasAction( $inputs->update_action ) ) {
			$notification = self::update( sanitize_hex_color( $_POST[ $inputs->star ] ), sanitize_hex_color( $_POST[ $inputs->text_primary ] ), sanitize_hex_color( $_POST[ $inputs->text_secondary ] ), sanitize_hex_color( $_POST[ $inputs->bg ] ) );
		}

		$data = [
			'notification' => $notification,
			'theme'        => RmaOptions::get_options()->review_theme,
			'inputs'       => $inputs,
		];

		echo TemplateHelpers::render_partial( $path, $data );
	}

	private static function update( $star, $text_primary, $text_secondary, $bg ) {
		RmaOptions::set_review_theme( compact( 'star', 'text_primary', 'text_secondary', 'bg' ) );

		return TemplateHelpers::notification( 'success', __( 'Theme settings have been updated' ) );
	}

	private static function hasAction( string $action ): bool {
		return isset( $_POST[ $action ] ) && wp_validate_boolean( $_POST[ $action ] );
	}
}
