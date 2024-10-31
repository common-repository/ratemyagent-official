<?php echo wp_kses($notification, \Rma\Helpers\TemplateHelpers::allowed_html()) ?>


<h2> <?php _e('Advanced', 'ratemyagent-official') ?> </h2>

<form action="" method="post">
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr($inputs->rating_limit) ?>"><?php _e('Rating limit', 'ratemyagent-official') ?></label>
				</th>
				<td>
					<select id="<?php echo esc_attr($inputs->rating_limit) ?>" name="<?php echo esc_attr($inputs->rating_limit) ?>" class="regular-text">
						<?php foreach ([1, 2, 3, 4, 5] as $rating) : ?>
							<option value="<?php echo $rating ?>" <?php echo $ratingLimit === $rating ? 'selected' : null ?>><?php echo $rating ?></option>
						<?php endforeach ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="hidden" name="<?php echo esc_attr($inputs->update_advanced_config) ?>" value="true" />

		<button type="submit" id="<?php echo esc_attr($inputs->update_advanced_config) ?>" class="button button-primary">
			<?php _e('Update advanced options', 'ratemyagent-official') ?>
		</button>
	</p>
</form>


<?php if ($hasPermission) : ?>

	<h3> <?php _e('Cache', 'ratemyagent-official') ?> </h3>
	<form action="" method="post">
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row">
						<label for="<?php echo esc_attr($inputs->duration) ?>"><?php _e('Data sync', 'ratemyagent-official') ?></label>
					</th>
					<td>
						<select id="<?php echo esc_attr($inputs->duration) ?>" name="<?php echo esc_attr($inputs->duration) ?>" class="regular-text">
							<option value="3600" <?php echo esc_attr($duration === '3600' ? 'selected' : null) ?>><?php _e('Hourly') ?></option>
							<option value="86400" <?php echo esc_attr($duration === '86400' ? 'selected' : null) ?>><?php _e('Daily') ?></option>
							<option value="604800" <?php echo esc_attr($duration === '604800' ? 'selected' : null) ?>><?php _e('Weekly') ?></option>
							<option value="2419200" <?php echo esc_attr($duration === '2419200' ? 'selected' : null) ?>><?php _e('Monthly') ?></option>
						</select>
						<p><?php _e('How often the data synchronises with the database. Daily recommended.', 'ratemyagent-official') ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="hidden" name="<?php echo esc_attr($inputs->update_action) ?>" value="true" />

			<button type="submit" id="<?php echo esc_attr($inputs->update_action) ?>" class="button button-primary">
				<?php _e('Update cache settings', 'ratemyagent-official') ?>
			</button>
		</p>
	</form>

	<form action="" method="post">
		<input type="hidden" name="<?php echo esc_attr($inputs->clear_action) ?>" value="true" />
		<button type="submit" id="<?php echo esc_attr($inputs->clear_action) ?>" class="button button-secondary">
			<?php _e('Clear cache', 'ratemyagent-official') ?>
		</button>
	</form>
<?php else : ?>
	<?php _e('We could not access the cache folder', 'ratemyagent-official') ?> : <?php echo esc_attr($cacheFolder) ?>
<?php endif; ?>
</div>