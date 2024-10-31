<?php

namespace Rma\DataAccess;

use Exception;
use Rma\Cache\Cache;
use Rma\DataAccess\Dtos\Profile;
use Rma\DataAccess\Exceptions\MissingProfileCodeException;
use Rma\Helpers\DevApiClient;

class ProfileApi {
	private string $base_cache_key = 'profile';
	private Cache $cache;
	private DevApiClient $dev_api_client;

	public function __construct() {
		$this->cache          = Cache::get_instance();
		$this->dev_api_client = new DevApiClient();
	}

	//for types: https://developers.ratemyagent.com.au/index.html
	public function get_profile( string $profile_code, string $agent_type = 'agent' ) {
		$cacheKey = $this->cache->generate_key( [ $this->base_cache_key, $agent_type, $profile_code ] );
		$endpoint = $this->get_endpoint( $profile_code, $agent_type );

		if ( ! $profile_code ) {
			throw new MissingProfileCodeException();
		}

		try {
			return $this->cache->retrieve_or_fail( $cacheKey );
		} catch ( Exception $e ) {
		}

		try {
			$result = $this->dev_api_client->get( $endpoint );
			$this->cache->store( $cacheKey, $result );

			return $result;
		} catch ( Exception $e ) {
			return null;
		}
	}

	private function get_endpoint( string $profile_code, string $agent_type ): string {
		return $agent_type . '/' . $profile_code . '/profile';
	}
}
