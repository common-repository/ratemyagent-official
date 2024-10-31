<div class="rma-reviews-carousel <?php echo esc_attr($carousel_id) ?>-container <?php echo esc_attr($classname) ?>">
	<?php if (isset($reviews) && count($reviews)) : ?>
<?php echo \Rma\Helpers\TemplateHelpers::trixelImg() ?>
	<div class="rma-reviews-carousel <?php echo esc_attr($carousel_id) ?>-container">
		<?php if ($heading) : ?>
			<strong class="rma-reviews-heading"> <?php echo esc_textarea($heading) ?></strong>
		<?php endif; ?>
		<div>
			<div class="swiper rma-full-review-carousel" id="<?php echo esc_attr($carousel_id) ?>">
				<div class="swiper-wrapper">
					<?php foreach ($reviews as $review) : ?>
						<div class="swiper-slide ">
							<article class="rma-slide">
								<div class="rating">
									<?php for ($x = 0; $x < $review->StarRating; $x++) : ?>
										<span class="rma-review-star">&#9733;</span>
									<?php endfor; ?>
								</div>
								<strong class="rma-card-title">
									<?php echo esc_textarea($review->Title) ?>
								</strong>
								<div class="rma-card-body">
									<div class="rma-review-description">
										<?php echo esc_textarea($review->Description) ?>
									</div>
								</div>
								<p class="rma-card-details">
									<?php _e('Reviewed by', 'ratemyagent'); ?>
									<strong><?php echo esc_textarea($review->ReviewerName) ?>
										(<?php echo esc_textarea($review->ReviewerType) ?>)</strong>
									<?php
									$date = new DateTime($review->ReviewedOn);
									echo $date->format('j M Y');
									?>
								</p>

								<?php echo \Rma\Helpers\TemplateHelpers::trixelImg($review->ReviewTrixelImgUrl, 'ReviewCarousel') ?>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-pagination"></div>
			<div class="rma-corporate-details">
				<div style="display:block;">
					<div style="display:flex" class="rma-link-back">
						<a href="<?php echo esc_url($profile_url) ?>" target="_blank">
							<?php if ($is_agency) : ?>
								<span
									class="rma-powered-by"> <?php _e('Read more of our reviews on ', 'ratemyagent') ?></span>
							<?php else : ?>
								<span
									class="rma-powered-by"> <?php _e('Read more of our reviews on ', 'ratemyagent') ?></span>
							<?php endif; ?>
							<img style="display:block;" alt="RateMyAgent" width="120" height="35" loading="lazy"
								 src="https://static.ratemyagent.com.au/assets/images/logos/logo-dark.svg">
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php elseif (is_user_logged_in()) : ?>
			<div>
				<p><?php _e('There were no results returned. This message is not shown to public users.', 'ratemyagent') ?></p>
				<p><?php _e('If you are expecting results, please check your profile code and clear the cache', 'ratemyagent') ?></p>
			</div>
		<?php endif ?>
	</div>
<?php echo \Rma\Helpers\TemplateHelpers::pluginVersion() ?>
