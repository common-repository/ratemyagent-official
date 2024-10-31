<?php

namespace Rma\InternalApi;

use Rma\DataAccess\AgencyRosterApi;
use Rma\Helpers\ProfileTypes;
use Rma\Options\RmaOptions;

class ReviewCarouselApi
{
	public function __construct()
	{
		add_action('rest_api_init', [self::class, 'review_carousel_endpoint'], 10, 1);
	}

	public static function review_carousel_endpoint(): void
	{
		register_rest_route('rma-wordpress-tools/v1', '/review-carousel', [
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
		$profileType = $options->profile->type;
		$isAgency    = $options->profile->isAgency();

		$code = $options->profile->code;

		try {
			$roster = $isAgency ? AgencyRosterApi::get_roster($code) : [];
		} catch (\Exception $exception) {
			$roster = [];
		}

		return [
			'agentRoster'   => $roster,
			'profileCode'   => $code,
			'profileType'   => $profileType,
			'profileTypes'  => $isAgency ? ProfileTypes::get_profile_types() : [],
			'reviewTypes' => self::get_review_types($region),
			'templateTypes' => self::get_template_types(),
		];
	}

	private static function get_template_types(): array
	{
		return [
			['label' => __('Full'), 'value' => 'full'],
			['label' => __('No avatar card'), 'value' => 'no-avatar'],
			['label' => __('No property image card'), 'value' => 'no-property'],
			['label' => __('Review only card'), 'value' => 'review-only'],
			['label' => __('Single review'), 'value' => 'full-review'],
		];
	}

	private static function get_review_types($region): array
	{
		$types = [
			['label' => __('Sales'), 'value' => false],
			['label' => __('Leasing'), 'value' => true],
		];

		return $region === 'US' ? [] : $types;
	}
}
