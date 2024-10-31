<?php

namespace Rma\Admin\Settings;

use Rma\Admin\Settings\General\GeneralPage;
use Rma\Admin\Settings\GetStarted\GetStartedPage;
use Rma\Admin\Settings\Theme\ThemePane;
use Rma\Options\RmaOptions;

class SettingsLoader {
	private const  SLUG = 'rma-settings';

	public function __construct() {
		add_action( 'admin_menu', [ self::class, 'add_menu_item' ] );

		if ( RmaOptions::get_options()->setup_complete ) {
			new GeneralPage();
			new ThemePane();
		} else {
			new GetStartedPage();
		}
	}

	static function add_menu_item() {
		add_menu_page( 'RateMyAgent', __( 'RateMyAgent', 'ratemyagent-official'), 'edit_pages', self::SLUG, null, self::get_icon() );
		add_action( 'admin_enqueue_scripts', [ self::class, 'add_styles' ] );
	}

	static function add_styles( $hook ) {
		if ( strpos( $hook, self::SLUG ) === false ) {
			return;
		}
		wp_enqueue_style( 'rma-admin-page-styles', plugin_dir_url( __FILE__ ) . 'assets/rma-settings.asset.css', [], '1.0' );
	}

	private static function get_icon(): string {
		$svgData = file_get_contents( dirname( __FILE__ ) . '/assets/rma-logo.svg' );

		return 'data:image/svg+xml;base64,' . base64_encode( $svgData );
	}
}
