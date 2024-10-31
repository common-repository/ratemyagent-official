<?php

namespace Rma\DataAccess;

use Exception;
use Rma\Cache\Cache;
use Rma\DataAccess\Exceptions\MissingProfileCodeException;
use Rma\Helpers\DevApiClient;

class AgencyRosterApi {

	/**
	 * for types: https://developers.ratemyagent.com.au/index.html
	 * @throws MissingProfileCodeException
	 */
	public static function get_roster( $profile_code ) {
		$cache        = Cache::get_instance();
		$devApiClient = new DevApiClient();
		$baseCacheKey = 'roster';
		$cacheKey     = $cache->generate_key( [ $baseCacheKey, $profile_code ] );
		$path         = 'agency/' . $profile_code. '/agents';
		$params       = [];

		if ( ! $profile_code ) {
			throw new MissingProfileCodeException();
		}

		try {
			return $cache->retrieve_or_fail( $cacheKey );
		} catch ( Exception $e ) {
		}

		try {
			$result = $devApiClient->get( $path, $params );

			$cache->store( $cacheKey, $result );

			return $result;
		} catch ( Exception $e ) {
			return [];
		}
	}
}
