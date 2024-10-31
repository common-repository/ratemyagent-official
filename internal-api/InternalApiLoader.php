<?php

namespace Rma\InternalApi;


class InternalApiLoader {
	public function __construct() {
		new ReviewCarouselApi();
		new ListingCarouselApi();
	}
}
