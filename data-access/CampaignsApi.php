<?php

namespace Rma\DataAccess;

use Exception;
use Rma\Cache\Cache;
use Rma\DataAccess\Exceptions\MissingProfileCodeException;
use Rma\Helpers\DevApiClient;

class CampaignsApi {
	private Cache $cache;
	private DevApiClient $devApiClient;

	public function __construct() {
		$this->cache        = Cache::get_instance();
		$this->devApiClient = new DevApiClient();
	}

	/**
	 * for types: https://developers.ratemyagent.com.au/index.html
	 * @throws MissingProfileCodeException
	 */
	public function get_active_campaigns( $profile_code, $agent_type = 'agent', $take = 9, $skip = 0 ): array {
		$cacheKey = $this->cache->generate_key( [ 'listing', $profile_code, $agent_type ] );
		$path     = $this->get_path( $profile_code, $agent_type );
		$params   = [ 'take' => $take, 'skip' => $skip ];

		if ( ! $profile_code ) {
			throw new MissingProfileCodeException();
		}

		try {
			return $this->cache->retrieve_or_fail( $cacheKey );
		} catch ( Exception $e ) {
		}

		try {

			$result = $this->devApiClient->get( $path, $params );

			if (is_object($result) && property_exists( $result, "Status") && $result->Status !== 200 ) {
				return [];
			}

			$this->cache->store( $cacheKey, $result );

			return $result;
		} catch ( Exception $e ) {
			return [];
		}
	}

	private function get_path( $profile_code, $agent_type ): string {
		return $agent_type . '/' . $profile_code . '/sales/listings';
	}
}
