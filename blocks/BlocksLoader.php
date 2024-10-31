<?php

namespace Rma\Blocks;

use Rma\Blocks\ListingCarousel\ListingCarouselBlock;
use Rma\Blocks\ReviewCarousel\ReviewCarouselBlock;

class BlocksLoader
{
    public function __construct()
    {
        new ReviewCarouselBlock();
        new ListingCarouselBlock();
    }
}
