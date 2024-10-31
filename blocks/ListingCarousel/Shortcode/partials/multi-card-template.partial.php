<div>
	<?php if (isset($listings) && count($listings)) : ?>
		<?php echo \Rma\Helpers\TemplateHelpers::trixelImg() ?>
		<div class="rma-listing-carousel <?php echo esc_attr($carousel_id) ?>-container <?php echo esc_attr($classname) ?>">
			<div class="swiper rma-multi-slide-carousel" id="<?php echo esc_attr($carousel_id) ?>">
				<div class="swiper-wrapper">
					<?php foreach ($listings as $listing) : ?>
						<div class="swiper-slide">
							<article class="rma-slide-card">
								<img src="<?php echo esc_url($listing->PropertyCoverImage !== '' ? $listing->PropertyCoverImage : 'https://static.ratemyagent.com.au/assets/images/placeholder/no-property-placeholder.png') ?>" class="rma-review-slide-hero" alt="" />

								<div class="rma-card-content">
									<strong class="rma-card-title rma-listing-price">
										<?php echo esc_textarea($listing->Price ?: __("Price undisclosed", 'ratemyagent')) ?>
									</strong>
									<div class="rma-card-body">
										<span class="rma-address-street"> <?php echo esc_textarea($listing->StreetAddress) ?> </span>
										<span class="rma-address-suburb"> <?php echo esc_textarea($listing->Suburb) ?><?php echo esc_textarea($listing->State) ?><?php echo esc_textarea($listing->Postcode) ?> </span>
									</div>

									<div class="rma-card-footer">
										<div class="rma-card-listing-details">
											<?php if ($listing->Carparks) : ?>
												<div class="rma-card-listing-detail">
													<svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M6.00006 3.99988V5.99988H18.0001V3.99988H20.0001V9.99988H22.0001V19.4999H20.0001V16.9999H4.00006V19.4999H2.00006V9.99988H4.00006V3.99988H6.00006ZM6.00006 7.99988V9.99988H11.0001V7.99988H6.00006ZM13.0001 7.99988V9.99988H18.0001V7.99988H13.0001ZM4.00006 11.9999V14.9999H20.0001V11.9999H4.00006Z"></path>
													</svg>
													<span><?php echo esc_textarea($listing->Bedrooms) ?></span>
												</div>
											<?php endif; ?>
											<?php if ($listing->Carparks) : ?>
												<div class="rma-card-listing-detail">
													<svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M15.2012 2.86486C15.5824 1.36904 16.9112 0.300049 18.5455 0.300049C20.4887 0.300049 22 1.8114 22 3.75459V11.9364C22 14.4366 20.3528 16.4764 18 16.9321V19.3H16V17.0273H8V19.3H6V16.9321C3.64724 16.4764 2 14.4366 2 11.9364V9.30005H20V3.75459C20 2.91597 19.3841 2.30005 18.5455 2.30005C18.0039 2.30005 17.5552 2.55691 17.3053 2.96473C18.6288 3.4443 19.5455 4.69575 19.5455 6.20914V7.20914H12.6364V6.20914C12.6364 4.57488 13.7054 3.24607 15.2012 2.86486ZM20 11.3H4V11.9364C4 13.675 5.26138 15.3 7 15.3H17C18.7386 15.3 20 13.675 20 11.9364V11.3ZM15.0091 5.20914H17.1727C16.912 4.92522 16.5323 4.75459 16.0909 4.75459C15.6495 4.75459 15.2698 4.92522 15.0091 5.20914Z"></path>
													</svg>
													<span><?php echo esc_textarea($listing->Bathrooms) ?></span>
												</div>

											<?php endif; ?>
											<?php if ($listing->Carparks) : ?>
												<div class="rma-card-listing-detail">
													<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20">
														<path d="M0 0h24v24H0z" fill="none" />
														<path fill="currentColor" d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
													</svg>
													<span><?php echo esc_textarea($listing->Carparks) ?></span>
												</div>
											<?php endif; ?>
										</div>

										<?php if ($listing->PropertyType) : ?>
											<div class="rma-card-property-type">
												<?php echo esc_textarea($listing->PropertyType); ?>
											</div>
										<?php endif; ?>
									</div>
									<?php echo \Rma\Helpers\TemplateHelpers::trixelImg($listing->ListingTrixelImgUrl, 'ListingCarousel') ?>
								</div>

								<a href="<?php echo esc_url($listing->ListingUrl) ?>" class="rma-read-more-link" target="_blank">
									<?php _e('Read more', 'ratemyagent'); ?>
								</a>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-pagination"></div>
			<div class="rma-corporate-details">
				<div style="display:block" class="rma-link-back">
					<a href="<?php echo esc_url($profile_url) ?>" target="_blank">
						<?php if ($is_agency) : ?>
							<span class="rma-powered-by"> <?php _e('Read our reviews on ', 'ratemyagent') ?></span>
						<?php else : ?>
							<span class="rma-powered-by"> <?php _e('Read my reviews on ', 'ratemyagent') ?></span>
						<?php endif; ?>

						<img style="display:block;" alt="RateMyAgent" width="120" height="35" loading="lazy" src="https://static.ratemyagent.com.au/assets/images/logos/logo-dark.svg">
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
</div>
<?php echo \Rma\Helpers\TemplateHelpers::pluginVersion() ?>
