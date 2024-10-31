<?php

namespace Rma\Helpers;

use Rma\Options\RmaOptions;

class UrlHelpers {

	public static function get_rma_config_url(): string {
		$path = 'dashboard/integrations/wordpress';

		return self::get_rma_url( $path );
	}

	public static function get_rma_url( string $path = '' ): string {
		$region = RmaOptions::get_options()->region;

		switch ( $region ) {
			case 'NZ':
				return 'https://www.ratemyagent.co.nz/' . $path;
			case 'US':
				return 'https://www.ratemyagent.com/' . $path;
			default:
				return 'https://www.ratemyagent.com.au/' . $path;
		}
	}

	public static function get_dev_api_domain( ?string $path ): string {
		$region = RmaOptions::get_options()->region;
		switch ( $region ) {
			case 'NZ':
				return 'https://developers.ratemyagent.co.nz/' . $path;
			case 'US':
				return 'https://developers.ratemyagent.com/' . $path;
			default:
				return 'https://developers.ratemyagent.com.au/' . $path;
		}
	}

}
