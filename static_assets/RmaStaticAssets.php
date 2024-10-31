<?php

namespace Rma\StaticAssets;

use Rma\Options\RmaOptions;

class RmaStaticAssets {
	public const SWIPER_SCRIPT_HANDLE = 'rma-swiper-script';
	public const SWIPER_STYLE_HANDLE = 'rma-swiper-styles';

	public static function register_static(): void {
		add_action( 'wp_enqueue_scripts', [ self::class, 'register_swiper' ] );
		add_action( 'wp_enqueue_scripts', [ self::class, 'inline_css' ] );

		//
		add_action( 'admin_enqueue_scripts', [ self::class, 'register_swiper' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'inline_css' ] );
	}

	public static function register_swiper(): void {
		$swiper_script = self::static_path( 'swiper-bundle.js' );
		$swiper_styles = self::static_path( 'swiper-bundle.css' );
		wp_register_script( self::SWIPER_SCRIPT_HANDLE, $swiper_script, [], 8, true );
		wp_register_style( self::SWIPER_STYLE_HANDLE, $swiper_styles, [], 8 );
	}

	public static function inline_css(): void {
		$theme       = RmaOptions::get_options()->review_theme;
		$global_vars = ":root {
                --rma-color-star: {$theme->star};
                --rma-color-text-primary: {$theme->text_primary};
                --rma-color-text-secondary: {$theme->text_secondary};
                --rma-color-bg: {$theme->bg};
                --rma-color-pagination: {$theme->pagination};
            }";
		wp_add_inline_style( self::SWIPER_STYLE_HANDLE, $global_vars );
	}

	private static function static_path( string $asset ): string {
		return plugins_url( 'assets/' . $asset, __FILE__ );
	}

}
