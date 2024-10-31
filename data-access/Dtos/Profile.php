<?php

namespace Rma\DataAccess\Dtos;


class Profile {
	public $image;
	public $name;
	public $rating;
	public $reviewCount;
	public $trixel_url;
	public $type;
	public $url;

	public function __construct( $vars ) {
		$this->image       = $vars['image'];
		$this->name        = $vars['name'];
		$this->rating      = $vars['rating'];
		$this->reviewCount = $vars['reviewCount'];
		$this->trixel_url  = $vars['trixel_url'];
		$this->type        = $vars['type'];
		$this->url         = $vars['url'];
	}

	public static function from_api( $profile_type, $api_data ): Profile {
		$data = self::get_data_by_type( $profile_type, $api_data );

		return new self( $data );
	}

	private static function get_data_by_type( $profile_type, $api_data ) {
		switch ( $profile_type ) {
			case 'agency':
				return self::get_agency_data( $profile_type, $api_data );
			case 'mortgage-broker':
			case 'agent':
			default:
				return self::get_agent_data( $profile_type, $api_data );
		}
	}

	private static function get_agent_data( $profile_type, $api_data ): array {
		return [
			'image'       => $api_data->Branding->Photo,
			'name'        => $api_data->Name,
			'rating'      => $api_data->OverallStars,
			'reviewCount' => $api_data->ReviewCount,
			'trixel_url'  => $api_data->AgentProfileTrixelImgUrl,
			'type'        => $profile_type,
			'url'         => $api_data->RmaAgentProfileUrl,
		];
	}

	private static function get_agency_data( $profile_type, $api_data ): array {
		return [
			'image'       => $api_data->Branding->Logo,
			'name'        => $api_data->Name,
			'rating'      => $api_data->OverallStars,
			'reviewCount' => $api_data->ReviewCount,
			'trixel_url'  => $api_data->AgencyProfileTrixelImgUrl,
			'type'        => $profile_type,
			'url'         => $api_data->RmaAgencyProfileUrl,
		];
	}
}
