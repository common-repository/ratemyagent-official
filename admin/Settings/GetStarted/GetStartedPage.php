<?php

namespace Rma\Admin\Settings\GetStarted;

use Rma\Admin\Settings\GetStarted\Models\Benefit;
use Rma\Helpers\TemplateHelpers;

class GetStartedPage {

	private const MENU_SLUG = 'rma-settings';

	public function __construct() {
		add_action( 'admin_menu', [ self::class, 'add_submenu_item' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'add_styles' ] );
	}

	public static function add_submenu_item() {
		add_submenu_page(
			self::MENU_SLUG,
			__( 'Get started' ),
			__( 'Get Started', 'ratemyagent-official' ),
			'edit_pages',
			self::MENU_SLUG,
			[ self::class, 'render' ],
			null );
	}

	public static function add_styles( $hook ) {
		if ( strpos( $hook, self::MENU_SLUG ) === false ) {
			return;
		}
		wp_enqueue_style( 'rma-admin-get-started-styles', plugin_dir_url( __FILE__ ) . 'assets/get-started.asset.css', [], '1.0' );
	}

	public static function render(): void {
		$path = dirname( __FILE__ ) . '/partial.php';

		$data = [
			'page'     => self::MENU_SLUG,
			'benefits' => self::get_benefits(),
		];

		echo TemplateHelpers::render_partial( $path, $data );
	}

	private static function get_benefits(): array {
		return [
			new Benefit( self::get_icon_url( 'library_books' ), __( 'Social Proof', 'ratemyagent-official' ), __( 'Showcase your reviews and promote your best customer experiences directly on your website.', 'ratemyagent-official' ) ),
			new Benefit( self::get_icon_url( 'format_paint' ), __( 'On Brand', 'ratemyagent-official' ), __( 'Simply copy and paste our pre-generated code onto your website to display your reviews in the perfect place.', 'ratemyagent-official' ) ),
			new Benefit( self::get_icon_url( 'wifi_tethering' ), __( 'Boost SEO', 'ratemyagent-official' ), __( 'Give your reviews a branded look by choosing the colors and design best suited to your business.', 'ratemyagent-official' ) ),
		];
	}

	private static function get_icon_url( string $icon ): string {
		return plugin_dir_url( __FILE__ ) . 'assets/' . $icon . '.svg';
	}
}
