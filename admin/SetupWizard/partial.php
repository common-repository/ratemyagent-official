<?php echo wp_kses($notification, \Rma\Helpers\TemplateHelpers::allowed_html()) ?>

<div class="wrap rma-setup-wizard">
	<?php if ($step > $total) : ?>
		<div class="rma-setup-wizard-complete">
			<?php echo wp_kses(\Rma\Helpers\TemplateHelpers::card_header(), \Rma\Helpers\TemplateHelpers::allowed_html()) ?>
			<div class="rma-setup-wizard-complete-content">
				<h1><?php _e("Congrats! You're all connected and ready to go!", 'ratemyagent-official') ?></h1>
				<p> <?php _e('Get introduced to our plugin by watching our getting started video. It will guide you through the steps needed to add and customise your RateMyAgent reviews for your website. ', 'ratemyagent-official') ?></p>

				<div class="rma-setup-wizard-complete-actions">
					<a href="<?php echo admin_url() ?>edit.php?post_type=page" class="button button-primary"> <?php _e('Add reviews to a page', 'ratemyagent-official') ?></a>
					<a href="?page=rma-settings-theme" class="button button-secondary"> <?php _e('Update your theme', 'ratemyagent-official') ?></a>
				</div>
			</div>
		</div>
	<?php else : ?>
		<form id="rma-setup-wizard-form" action="" method="post">
			<?php echo \Rma\Helpers\TemplateHelpers::card_header() ?>
			<div class="rma-setup-wizard-content">
				<div class="rma-setup-wizard-status">
					<?php printf(__('Step %s of %s', 'ratemyagent-official'), $step, $total); ?>
				</div>
				<div class="rma-setup-wizard-form">
					<?php switch ($step):
						case 1: ?>
							<div class="rma-setup-wizard-step rma-setup-wizard-step-1">
								<strong class="rma-setup-wizard-step-heading"><?php _e('Your Region', 'ratemyagent-official') ?></strong>
								<p class="rma-setup-wizard-step-body"> <?php _e("Select what region you're in") ?></p>

								<select id="<?php echo esc_attr($inputs->region) ?>" name="<?php echo esc_attr($inputs->region) ?>" class="regular-text">
									<option value="AU" <?php echo esc_attr($options->region === 'AU' ? 'selected' : null) ?>><?php _e('Australia') ?></option>
									<option value="NZ" <?php echo esc_attr($options->region === 'NZ' ? 'selected' : null) ?>><?php _e('New Zealand') ?></option>
									<option value="US" <?php echo esc_attr($options->region === 'US' ? 'selected' : null) ?>><?php _e('United Stated') ?></option>
								</select>

								<div class="rma-setup-wizard-actions">
									<input type="hidden" name="<?php echo esc_attr($inputs->set_region_action) ?>" value="true" />

									<button type="submit" id="<?php echo esc_attr($inputs->set_region_action) ?>" class="button button-primary">
										<?php _e('Next', 'ratemyagent-official') ?>
									</button>
								</div>
							</div>
							<?php break; ?>
						<?php
						case 2: ?>
							<div class="rma-setup-wizard-step rma-setup-wizard-step-2">
								<strong class="rma-setup-wizard-step-heading"><?php _e('Add your API Details', 'ratemyagent-official') ?></strong>
								<div class="rma-setup-wizard-step-body">
									<p>
										<?php _e("Add your RateMyAgent details to connect your account. You can", 'ratemyagent-official') ?>
										<a href="<?php echo esc_url(\Rma\Helpers\UrlHelpers::get_rma_config_url()) ?>" target="_blank"> <?php _e("generate your keys here", 'ratemyagent-official') ?></a>
									</p>
								</div>

								<div class="rma-setup-wizard-form-group">
									<label for="<?php echo esc_attr($inputs->client_id) ?>"><?php _e('Client ID', 'ratemyagent-official') ?></label>
									<input type="text" id="<?php echo esc_attr($inputs->client_id) ?>" name="<?php echo esc_attr($inputs->client_id) ?>" placeholder="eg. rma.profile-code.au" value="<?php echo esc_attr($options->client->id) ?>" class="regular-text" required />
								</div>

								<div class="rma-setup-wizard-form-group">
									<label for="<?php echo esc_attr($inputs->client_secret) ?>"><?php _e('Client secret', 'ratemyagent-official') ?></label>
									<input type="text" id="<?php echo esc_attr($inputs->client_secret) ?>" name="<?php echo esc_attr($inputs->client_secret) ?>" placeholder="eg. xxxxxxxxxx" value="<?php echo esc_attr($options->client->secret) ?>" class="regular-text" required />
								</div>

								<div class="rma-setup-wizard-actions">
									<input type="hidden" name="<?php echo esc_attr($inputs->set_client_action) ?>" value="true" />
									<button type="submit" id="<?php echo esc_attr($inputs->set_client_action) ?>" class="button button-primary">
										<?php _e('Confirm', 'ratemyagent-official') ?>
									</button>
								</div>
							</div>
							<?php break; ?>
						<?php
						case 3: ?>
							<div class="rma-setup-wizard-step rma-setup-wizard-step-3">
								<strong class="rma-setup-wizard-step-heading"><?php _e('Your profile details', 'ratemyagent-official') ?></strong>
								<p>
									<?php _e("Select your account type and add your agent code. You can ", 'ratemyagent-official') ?>
									<a href="<?php echo esc_url(\Rma\Helpers\UrlHelpers::get_rma_config_url()) ?>" target="_blank"> <?php _e("get your profile code here.", 'ratemyagent-official') ?></a>
								</p>
								<div class="rma-setup-wizard-form-group">
									<label for="<?php echo esc_attr($inputs->profile_type) ?>">
										<?php _e('Profile type', 'ratemyagent-official') ?>
									</label>
									<select id="<?php echo esc_attr($inputs->profile_type) ?>" name="<?php echo esc_attr($inputs->profile_type) ?>" class="regular-text">
										<?php foreach ($profile_types as $type) : ?>
											<option value="<?php echo esc_attr($type['value']) ?>" <?php echo esc_attr($options->profile->type === $type['value'] ? 'selected' : null) ?>>
												<?php echo esc_attr($type['label']) ?>
											</option>
										<?php endforeach ?>
									</select>
								</div>

								<div class="rma-setup-wizard-form-group">
									<label for="<?php echo esc_attr($inputs->profile_code) ?>">
										<?php _e('Profile code (Note: all lowercase)', 'ratemyagent-official') ?>
									</label>
									<input type="text" id="<?php echo esc_attr($inputs->profile_code) ?>" name="<?php echo esc_attr($inputs->profile_code) ?>" placeholder="eg. hs621" required value="<?php echo esc_attr($options->profile->code) ?>" class="regular-text" />
								</div>

								<div class="rma-setup-wizard-actions">
									<input type="hidden" name="<?php echo esc_attr($inputs->set_profile_action) ?>" value="true" />
									<input type="submit" value="<?php _e('Confirm', 'ratemyagent-official') ?>" id="<?php echo esc_attr($inputs->set_profile_action) ?>" class="button button-primary" />
								</div>

							</div>
							<?php break; ?>
					<?php endswitch; ?>
				</div>
			</div>
		</form>
	<?php endif; ?>
</div>