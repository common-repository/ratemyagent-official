<?php

namespace Rma\DataAccess;

use Exception;
use Rma\Cache\Cache;
use Rma\DataAccess\Exceptions\MissingProfileCodeException;
use Rma\Helpers\DevApiClient;

class ReviewsApi
{
	private Cache $cache;
	private DevApiClient $devApiClient;

	public function __construct()
	{
		$this->cache        = Cache::get_instance();
		$this->devApiClient = new DevApiClient();
	}

	/**
	 * for types: https://developers.ratemyagent.com.au/index.html
	 * @throws MissingProfileCodeException
	 */
	public function get_reviews($profile_code, $agent_type = 'agent', $is_leasing = false, $take = 9, $skip = 0)
	{
		$review_type = $is_leasing ? 'leasing' : 'sales';
		$baseCacheKey = 'reviews';
		$cacheKey    = $this->cache->generate_key([$baseCacheKey, $profile_code, $agent_type, $review_type]);
		$path        = $this->get_path($profile_code, $agent_type, $review_type);
		$params      = ['take' => $take, 'skip' => $skip];

		if (!$profile_code) {
			throw new MissingProfileCodeException();
		}

		try {
			return $this->cache->retrieve_or_fail($cacheKey);
		} catch (Exception $e) {
		}

		try {
			$result = $this->devApiClient->get($path, $params);

			$this->cache->store($cacheKey, $result);

			return $result;
		} catch (Exception $e) {
			return [];
		}
	}

	private function get_path(string $profile_code, string $agent_type, string $review_type): string
	{
		return $this->get_path_by_type($profile_code, $agent_type, $review_type) . '/reviews';
	}

	private function get_path_by_type(string $profile_code, string $agent_type, string $review_type): string
	{
		if ($agent_type === 'agency') {

			return $agent_type . '/' . $profile_code . '/' . $review_type;
		}

		$baseAgentEndpoint = $agent_type . '/' . $profile_code;

		if ($agent_type === 'mortgage-broker') {
			return $baseAgentEndpoint;
		}

		return $baseAgentEndpoint . '/sales';
	}
}
