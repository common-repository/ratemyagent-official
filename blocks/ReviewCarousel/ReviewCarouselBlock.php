<?php

namespace Rma\Blocks\ReviewCarousel;

use Rma\Blocks\ReviewCarousel\Shortcode\ReviewCarouselShortcode;
use Rma\Helpers\TemplateHelpers;
use Rma\Options\RmaOptions;
use Rma\StaticAssets\RmaStaticAssets;
use WP_Block;

class ReviewCarouselBlock {
	static string $SHORTCODE_NAME = 'rma-review-carousel';

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
		wp_enqueue_script( 'rma-carousel-script', self::asset_path( 'carousel.asset.js' ), [ $handle ], false, true );
	}

	public static function add_styles() {
		$handle = RmaStaticAssets::SWIPER_STYLE_HANDLE;
		wp_enqueue_style( $handle );
		wp_enqueue_style( 'rma-carousel-styles', self::asset_path( 'carousel.asset.css' ), [ $handle ] );
	}

	public static function add_styles_admin() {
		$handle = RmaStaticAssets::SWIPER_STYLE_HANDLE;
		wp_enqueue_style( $handle );
		wp_enqueue_style( 'rma-carousel-styles', self::asset_path( 'carousel.asset.css' ), [ $handle ] );
	}
	/**
	 * This function is called when the block is being rendered on the front end of the site
	 *
	 * @param array $attributes The array of attributes for this block.
	 * @param string $content Rendered block output. ie. <InnerBlocks.Content />.
	 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
	 */
	public static function render_cb( array $attributes, string $content, WP_Block $block_instance ) {
		$shortcodeName = self::$SHORTCODE_NAME;

		return TemplateHelpers::render_shortcode( $shortcodeName, $attributes );
	}

	private function register_short_code() {
		add_shortcode( self::$SHORTCODE_NAME, [ new ReviewCarouselShortcode, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ self::class, 'add_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ self::class, 'add_styles' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'add_styles_admin' ] );
	}

	private static function register_block(): void {
		add_action( 'init', [ self::class, 'block_init' ] );
	}

	private static function asset_path( string $asset ): string {
		return plugin_dir_url( __FILE__ ) . 'Shortcode/assets/' . $asset;
	}
}
