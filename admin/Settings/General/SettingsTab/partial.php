	<?php echo wp_kses($notification, \Rma\Helpers\TemplateHelpers::allowed_html()) ?>

<form id="rma-api-settings" action="" method="post">
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr($inputs->region) ?>"><?php _e('Region', 'ratemyagent-official') ?></label>
				</th>
				<td>
					<select id="<?php echo esc_attr($inputs->region) ?>" name="<?php echo esc_attr($inputs->region) ?>" class="regular-text">
						<option value="AU" <?php echo esc_attr($options->region) === 'AU' ? 'selected' : null ?>><?php _e('Australia') ?></option>
						<option value="NZ" <?php echo esc_attr($options->region) === 'NZ' ? 'selected' : null ?>><?php _e('New Zealand') ?></option>
						<option value="US" <?php echo esc_attr($options->region) === 'US' ? 'selected' : null ?>><?php _e('United Stated') ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr($inputs->client_id) ?>"><?php _e('Client ID', 'ratemyagent-official') ?></label>
				</th>
				<td>
					<input type="text" id="<?php echo esc_attr($inputs->client_id) ?>" name="<?php echo esc_attr($inputs->client_id) ?>" required value="<?php echo esc_attr($options->client->id) ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr($inputs->client_secret) ?>">
						<?php _e('Client secret', 'ratemyagent-official') ?>
					</label>
				</th>
				<td>
					<input type="password" autocomplete="<?php echo esc_attr($inputs->client_secret) ?>" id="<?php echo esc_attr($inputs->client_secret) ?>" name="<?php echo esc_attr($inputs->client_secret) ?>" required value="<?php echo esc_attr($options->client->secret) ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr($inputs->profile_type) ?>"><?php _e('Profile type', 'ratemyagent-official') ?></label>
				</th>
				<td>
					<select id="<?php echo esc_attr($inputs->profile_type) ?>" name="<?php echo esc_attr($inputs->profile_type) ?>" class="regular-text">
						<?php foreach ($profile_types as $type) : ?>
							<option value="<?php echo esc_attr($type['value']) ?>" <?php echo $options->profile->type === $type['value'] ? 'selected' : null ?>><?php echo $type['label'] ?></option>
						<?php endforeach ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr($inputs->profile_code) ?>">
						<?php _e('Profile code', 'ratemyagent-official') ?>
					</label>
				</th>
				<td>
					<input type="text" id="<?php echo esc_attr($inputs->profile_code) ?>" name="<?php echo esc_attr($inputs->profile_code) ?>" required value="<?php echo esc_attr($options->profile->code) ?>" class="regular-text" />
				</td>
			</tr>

		</tbody>
	</table>

	<p class="submit">
		<input type="hidden" name="<?php echo esc_attr($inputs->update_action) ?>" value="true" />
		<input type="submit" value="<?php _e('Update API settings', 'ratemyagent-official') ?>" id="comp-detail-submit" class="button button-primary" />
	</p>
</form>

<?php if ($options->client->id !== '' && $options->client->secret !== '') : ?>
	<form id="api-details-cache" action="" method="post">
		<p class="submit">
			<input type="hidden" name="<?php echo esc_attr($inputs->test_action) ?>" value="true" />
			<input type="submit" value="<?php _e('Test API settings', 'ratemyagent-official') ?>" id="rma-test-api-submit" class="button button-secondary" />
		</p>
	</form>
<?php endif; ?>

<?php if ($debug) : ?>
	<form id="api-details-reset" action="" method="post">
		<p class="submit">
			<input type="hidden" name="<?php echo esc_attr($inputs->reset_action) ?>" value="true" />
			<input type="submit" value="<?php _e('Reset API settings', 'ratemyagent-official') ?>" class="button button-secondary" />
		</p>
	</form>
<?php endif; ?>
