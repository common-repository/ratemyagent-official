<?php

namespace Rma\Helpers;

use Rma\DataAccess\Authorization;
use Rma\Helpers\Exceptions\ForbiddenException;
use Rma\Helpers\Exceptions\NoResultsException;
use Rma\Options\RmaOptions;

class DevApiClient {
	private Authorization $auth;
	private $region;

	public function __construct() {
		$this->auth   = new Authorization();
		$this->region = RmaOptions::get_options()->region;
	}

	/**
	 * @throws NoResultsException
	 * @throws ForbiddenException
	 */
	public function get( $path, $params = [], $args = [] ) {
		$args['headers'] = $this->auth->get_headers();
		$url             = UrlHelpers::get_dev_api_domain( $path );
		$response        = wp_remote_request( $url . '?' . http_build_query( $params ), $args );
		$body            = json_decode( $response['body'] );

		if ( is_null( $body ) ) {
			throw new NoResultsException( $url );
		}

		if(is_array($body)){
			return $body;
		}

		if ( property_exists( $body, "Status" ) && $body->Status === 403 ) {
			throw new ForbiddenException( $url );
		}

		if ( property_exists( $body, "Results" ) ) {
			return $body->Results;
		}

		return $body;
	}
}
