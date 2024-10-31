<?php

namespace Rma\InternalApi;

use Rma\DataAccess\AgencyRosterApi;
use Rma\Helpers\ProfileTypes;
use Rma\Options\RmaOptions;

class ListingCarouselApi
{
	public function __construct()
	{
		add_action('rest_api_init', [self::class, 'listing_carousel_endpoint'], 10, 1);
	}

	public static function listing_carousel_endpoint(): void
	{
		register_rest_route('rma-wordpress-tools/v1', '/listing-carousel', [
			'methods'             => 'GET',
			'permission_callback' => '__return_true', // *always set a permission callback
			'callback'            => function ($request) {
				return self::get_data();
			},
		]);
	}

	private static function get_data(): array
	{
		$options     = RmaOptions::get_options();
		$region      = $options->region;
		$isAgency    = $options->profile->isAgency();
		$code = $options->profile->code;

		try {
			$roster = $isAgency ? AgencyRosterApi::get_roster($code) : [];
		} catch (\Exception $exception) {
			$roster = [];
		}

		return [
			'agentRoster' => $roster,
			'profileCode'   => $code,
			'profileType'   => $options->profile->type,
			'profileTypes'  => $isAgency ? ProfileTypes::get_profile_types() : [],
			'templateTypes' => self::get_template_types(),
		];
	}

	private static function get_template_types(): array
	{
		return [
			['label' => __('Full'), 'value' => 'full'],
		];
	}
}
