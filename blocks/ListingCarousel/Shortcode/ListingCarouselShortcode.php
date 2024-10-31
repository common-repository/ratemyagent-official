<?php

namespace Rma\Blocks\ListingCarousel\Shortcode;

use Rma\DataAccess\CampaignsApi;
use Rma\DataAccess\Exceptions\MissingCredentialsException;
use Rma\DataAccess\Exceptions\MissingProfileCodeException;
use Rma\Helpers\TemplateHelpers;
use Rma\Helpers\UrlHelpers;

class ListingCarouselShortcode
{
	private CampaignsApi $campaigns;

	public function __construct()
	{
		$this->campaigns = new CampaignsApi();
	}

	public function render($attributes): string
	{
		$attrs   = $this->get_attributes($attributes);
		$partial = $this->get_partial_file($attrs['template_type']);
		$is_agency = $attrs['profile_type'] === 'agency';

		try {
			$listings = $this->campaigns->get_active_campaigns($attrs['profile_code'], $attrs['profile_type']);
		} catch (MissingCredentialsException | MissingProfileCodeException $e) {
			return '<p>' . $e . '</p>';
		}

		$data = [
			'carousel_id' => TemplateHelpers::generate_id(6, 'rma-campaign-'),
			'classname'   => isset($attributes['classname']) ? $attributes['classname']  : '',
			'is_agency'	  => $is_agency,
			'listings'    => $listings,
			'rma_url'     => UrlHelpers::get_rma_url(),
		];

		return TemplateHelpers::render_partial($partial, $data);
	}

	private function get_attributes(array $attributes): array
	{
		$defaults = ['profile_code' => null, 'profile_type' => 'agent', 'template_type' => 'full'];

		return shortcode_atts($defaults, $attributes);
	}


	private function get_partial_file($template_type): string
	{
		$folder_path  = dirname(__FILE__) . '/partials';
		$partial_name = $this->get_partial_name($template_type);

		return $folder_path . '/' . $partial_name . '.partial.php';
	}

	private function get_partial_name($template_type): string
	{
		switch ($template_type) {
			default:
				return 'multi-card-template';
		}
	}
}
