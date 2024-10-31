<?php

namespace Rma\Admin\Settings\General;

use Rma\Admin\Settings\General\AdvancedTab\AdvancedSettings;
use Rma\Admin\Settings\General\SettingsTab\Settings;
use Rma\Helpers\TemplateHelpers;

class GeneralPage {
	private const MENU_SLUG = 'rma-settings';

	public function __construct() {
		add_action( 'admin_menu', [ self::class, 'add_menu_item' ] );
	}

	static function add_menu_item() {
		//we use the same slug as the parent in order to have a different menu item as the first child (ie not RateMyAgent> RateMyAgent
		add_submenu_page(
			self::MENU_SLUG,
			__( 'ratemyagent-official' ),
			__( 'Api', 'ratemyagent-official' ),
			'edit_pages',
			self::MENU_SLUG, [
			self::class,
			'render'
		] );
	}

	static function render() {
		$template = dirname( __FILE__ ) . '/partial.php';
		$page     = self::MENU_SLUG;
		$tab      = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : null;
		$content  = self::get_tab_content( $tab );

		echo TemplateHelpers::render_partial( $template, compact( 'page', 'tab', 'content' ) );
	}

	private static function get_tab_content( $tab ) {
		switch ( $tab ) {
			case 'advanced':
				return AdvancedSettings::handle_tab();
			default:
				return Settings::handle_tab();
		}
	}
}
