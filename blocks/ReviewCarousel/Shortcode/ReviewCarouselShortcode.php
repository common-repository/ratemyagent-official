<?php

namespace Rma\Blocks\ReviewCarousel\Shortcode;

use Rma\DataAccess\Dtos\Profile;
use Rma\DataAccess\Exceptions\MissingCredentialsException;
use Rma\DataAccess\Exceptions\MissingProfileCodeException;
use Rma\DataAccess\ProfileApi;
use Rma\DataAccess\ReviewsApi;
use Rma\Helpers\TemplateHelpers;
use Rma\Helpers\UrlHelpers;
use Rma\Options\RmaOptions;

class ReviewCarouselShortcode
{
	private ReviewsApi $reviews_api;
	private ProfileApi $profile_api;

	public function __construct()
	{
		$this->reviews_api = new ReviewsApi();
		$this->profile_api = new ProfileApi();
	}

	public static function filter_to_rating_limit($review)
	{
		if (!$review->StarRating) {
			return true;
		}
		return $review->StarRating >= RmaOptions::get_options()->rating_limit;
	}

	public function render($attributes): string
	{
		$attrs = $this->get_attributes($attributes);
		$partial = $this->get_partial_file($attrs['template_type']);
		$is_agency = $attrs['profile_type'] === 'agency';
		try {
			$base = $this->reviews_api->get_reviews($attrs['profile_code'], $attrs['profile_type'], $attrs['is_leasing']);
			$reviews = array_filter($base, [self::class, 'filter_to_rating_limit']);
		} catch (MissingCredentialsException|MissingProfileCodeException $e) {
			return '<p>' . $e . '</p>';
		}

		try {
			$profile = $this->profile_api->get_profile($attrs['profile_code'], $attrs['profile_type']);
		} catch (MissingCredentialsException|MissingProfileCodeException $e) {
			return '<p>' . $e . '</p>';
		}

		if (!$profile) {
			if (is_user_logged_in()) {
				return '<p>' . __('There was an error getting you data. This will not been displayed to the public.', 'ratemyagent') . "</p>";
			}
			return '';
		}

		$data = [
			'carousel_id' => TemplateHelpers::generate_id(6, 'rma-review-'),
			'classname' => isset($attributes['classname']) ? $attributes['classname'] : '',
			'heading' => str_replace("{reviewCount}", $profile->ReviewCount, $attrs['heading']),
			'is_agency' => $is_agency,
			'profile_url' => $is_agency ? $profile->RmaAgencyProfileUrl : $profile->RmaAgentProfileUrl,
			'reviews' => $reviews,
			'rma_url' => UrlHelpers::get_rma_url(),
			'show_img' => in_array($attrs['template_type'], ['full', 'no-avatar']),
			'hide_agent_details' => in_array($attrs['template_type'], ['no-avatar', 'review-only']),
		];


		return TemplateHelpers::render_partial($partial, $data);
	}

	private function get_attributes(array $attributes): array
	{
		$defaults = [
			'profile_code' => null,
			'profile_type' => 'agent',
			'is_leasing' => false,
			'template_type' => 'full',
			'heading' => null,
		];

		return shortcode_atts($defaults, $attributes);
	}

	private function get_partial_file(string $template_type): string
	{
		$folder_path = dirname(__FILE__) . '/partials';
		$partial_name = $this->get_partial_name($template_type);

		return $folder_path . '/' . $partial_name . '.partial.php';
	}

	private function get_partial_name(string $template_type): string
	{
		switch ($template_type) {
			case 'full-review':
				return 'full-review-template';
			default:
				return 'multi-card-template';
		}
	}
}
