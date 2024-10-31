<?php

namespace Rma\Blocks\ListingCarousel;

use Rma\Blocks\ListingCarousel\Shortcode\ListingCarouselShortcode;
use Rma\Helpers\TemplateHelpers;
use Rma\StaticAssets\RmaStaticAssets;

class ListingCarouselBlock {
	static $SHORTCODE_NAME = 'rma-listings-carousel';

	public function __construct() {
		$this->register_short_code();
		$this->register_block();
	}

	public static function block_init() {
		register_block_type( __DIR__ . '/Block', [ 'render_callback' => [ self::class, 'render_cb' ] ] );
	}

	public static function add_scripts() {
		$handle = RmaStaticAssets::SWIPER_SCRIPT_HANDLE;
		wp_enqueue_script( $handle );
		wp_enqueue_script( 'rma-listing-carousel-script', self::asset_path( 'carousel.asset.js' ), [ $handle ], false, true );
	}

	public static function add_styles() {
		$handle = RmaStaticAssets::SWIPER_STYLE_HANDLE;
		wp_enqueue_style( $handle );
		wp_enqueue_style( 'rma-listing-carousel-styles', self::asset_path( 'carousel.asset.css' ), [ $handle ] );
	}

	public static function render_cb( $attributes, $content, $block_instance ) {
		$shortcodeName = self::$SHORTCODE_NAME;

		return TemplateHelpers::render_shortcode( $shortcodeName, $attributes );
	}

	private function register_short_code() {
		add_shortcode( self::$SHORTCODE_NAME, [ new ListingCarouselShortcode, 'render' ] );
		add_action( 'wp_enqueue_scripts', [ self::class, 'add_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ self::class, 'add_styles' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'add_styles' ] );
	}

	private function register_block() {
		add_action( 'init', [ self::class, 'block_init' ] );
	}

	private static function asset_path( string $asset ): string {
		return plugin_dir_url( __FILE__ ) . 'Shortcode/assets/' . $asset;
	}
}
