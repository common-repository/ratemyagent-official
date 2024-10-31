<?php if (isset($reviews) && count($reviews)) : ?>
	<div class="rma-reviews-carousel <?php echo esc_attr($carousel_id) ?>-container <?php echo esc_attr($classname) ?>">
		<?php echo \Rma\Helpers\TemplateHelpers::trixelImg() ?>
		<?php if ($heading) : ?>
			<strong class="rma-reviews-heading"> <?php echo esc_textarea($heading) ?></strong>
		<?php endif; ?>
		<div class="swiper rma-multi-slide-carousel" id="<?php echo esc_attr($carousel_id) ?>">
			<div class="swiper-wrapper">
				<?php foreach ($reviews as $review) : ?>

					<div class="swiper-slide ">
						<article
							class="rma-slide-card <?php echo esc_attr($show_img ? '' : 'rma-slide-card-no-image') ?>">

							<?php if ($show_img) : ?>
								<img src="<?php echo esc_url($review->PropertyCoverImage) ?>" class="rma-card-hero"
									 alt=""/>
							<?php endif; ?>

							<div class="rma-card-content">
								<?php if (property_exists($review, 'Agent') && !$hide_agent_details) : ?>
									<a href="<?php echo esc_url($review->Agent->RmaAgentProfileUrl) ?>" target="_blank"
									   class="rma-card-profile">

										<?php if ($review->Agent->Branding->Photo) : ?>
											<img class="rma-card-profile-image"
												 src="<?php echo esc_url($review->Agent->Branding->Photo) ?>" alt=""/>
										<?php endif; ?>

										<div class="rma-card-profile-details">
											<p class="rma-card-profile-name"><?php echo esc_textarea($review->Agent->Name) ?></p>
											<p class="rma-card-profile-review-count"><?php echo esc_textarea($review->Agent->ReviewCount) ?>&nbsp;	<?php _e('reviews', 'ratemyagent') ?></p>
										</div>
									</a>
								<?php endif; ?>

								<div class="rating">
									<?php for ($x = 0; $x < $review->StarRating; $x++) : ?>
										<span class="rma-review-star">&#9733;</span>
									<?php endfor; ?>
								</div>
								<strong class="rma-card-title"><?php echo esc_textarea($review->Title) ?></strong>
								<div class="rma-card-body">
									<div class="rma-card-description">
										<?php echo esc_textarea($review->Description) ?>
									</div>
									<a href="<?php echo esc_url($review->ReviewUrl) ?>" class="rma-read-more-link"
									   target="_blank">
										<?php _e('Read more', 'ratemyagent'); ?>
									</a>
								</div>
								<p class="rma-card-details">
									<?php _e('Reviewed by', 'ratemyagent'); ?>
									<strong>
										<?php echo esc_textarea($review->ReviewerName) ?>
										(<?php echo esc_textarea($review->ReviewerType) ?>)
									</strong>
									<?php
									$date = new DateTime($review->ReviewedOn);
									echo $date->format('j M Y');
									?>
								</p>

								<?php echo \Rma\Helpers\TemplateHelpers::trixelImg($review->ReviewTrixelImgUrl, 'ReviewCarousel') ?>
							</div>
						</article>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-pagination"></div>
		<div class="rma-corporate-details">
			<div style="display:flex" class="rma-link-back">
				<a href="<?php echo esc_url($profile_url) ?>" target="_blank">
					<?php if ($is_agency) : ?>
						<span class="rma-powered-by"> <?php _e('Read more of our reviews on ', 'ratemyagent') ?></span>
					<?php else : ?>
						<span class="rma-powered-by"> <?php _e('Read more of my reviews on ', 'ratemyagent') ?></span>
					<?php endif; ?>
					<img style="display:block;" alt="RateMyAgent" width="120" height="35" loading="lazy"
						 src="https://static.ratemyagent.com.au/assets/images/logos/logo-dark.svg">
				</a>
			</div>
		</div>
	</div>

<?php elseif (is_user_logged_in()) : ?>
	<div>
		<p><?php _e('There were no results returned. This message is not shown to public users.', 'ratemyagent') ?></p>
		<p><?php _e('If you are expecting results, please check your profile code and clear the cache', 'ratemyagent') ?></p>
	</div>
<?php endif ?>
<?php echo \Rma\Helpers\TemplateHelpers::pluginVersion() ?>

