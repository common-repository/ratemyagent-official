<?php

namespace Rma\DataAccess;

use Exception;
use Rma\Cache\Cache;
use Rma\DataAccess\Exceptions\InvalidAuthRequestException;
use Rma\DataAccess\Exceptions\MissingCredentialsException;
use Rma\Options\RmaOptions;

class AuthResponse {
	public string $access_token;
	public int $expires_in;
	public string $token_type;
	public string $scope;
}

class Authorization {
	private Cache $cache;

	private string $cacheKey = 'auth:token';

	public function __construct() {
		$this->cache = Cache::get_instance();
	}

	public function get_headers(): array {
		$options = RmaOptions::get_options();
		$token   = $this->get_token_from_cache_or_api( $options->client->id, $options->client->secret );

		return [ 'Authorization' => 'Bearer ' . $token ];
	}

	/**
	 * @throws MissingCredentialsException
	 */
	public function test_token( string $client_id, string $client_secret ): \stdClass {
		return $this->request_token_from_api( $client_id, $client_secret );
	}

	private function get_token_from_cache_or_api( $client_id, $client_secret ): string {
		try {
			return $this->cache->retrieve_or_fail( $this->cacheKey );
		} catch ( Exception $e ) {
			$request = $this->request_token_from_api( $client_id, $client_secret );
			$this->cache->store( $this->cacheKey, $request->access_token, $request->expires_in );

			return $request->access_token;
		}
	}

	/**
	 * @throws MissingCredentialsException
	 * @throws Exception
	 */
	private function request_token_from_api( $client_id, $client_secret ): \stdClass {
		if ( ! $client_id || ! $client_secret ) {
			throw new MissingCredentialsException();
		}


		return $this->refresh_token( $client_id, $client_secret );
	}

	/**
	 *
	 * @param string $client_id
	 * @param string $client_secret
	 *
	 * @return mixed [
	 *  access_token: string;
	 *  expires_in:   number;
	 *  token_type:   string;
	 *  scope:        string;
	 * ]
	 * @throws InvalidAuthRequestException
	 * @throws Exception
	 */
	private function refresh_token( string $client_id, string $client_secret ): \stdClass {
		$body = [
			"client_id"     => $client_id,
			"client_secret" => $client_secret,
			"audience"      => "developer.api",
			"grant_type"    => "client_credentials"
		];

		$args = [
			'method'  => 'POST',
			'headers' => [ 'Content-type: application/x-www-form-urlencoded' ],
			'body'    => $body,
		];

		$response = wp_remote_post( 'https://identity.ratemyagent.com/connect/token', $args );

		// If the status code is not 200, throw an error with the raw response body
		if ( isset( $response['response'] ) && $response['response']['code'] !== 200 ) {
			throw new InvalidAuthRequestException( $response['response']['message'] );
		}

		$token_response = json_decode( $response['body'] );

		if ( isset( $token_response->error ) ) {
			throw new Exception( $token_response->error );
		}

		return $token_response;
	}
}
