<div class="wrap">
	<header class="rma-page-header">
		<h1>
			<span class="rma-page-header-logo"><?php _e( 'RateMyAgent', 'ratemyagent-official' ) ?></span>
			<span class="rma-page-header-text"><?php _e( 'WordPress tools', 'ratemyagent-official' ) ?> </span>
		</h1>
	</header>
	<?php echo wp_kses( $notification, \Rma\Helpers\TemplateHelpers::allowed_html() ) ?>
	<nav class="nav-tab-wrapper">
		<a href="?page=rma-settings-theme" class="nav-tab nav-tab-active">
			<?php _e( 'Theme' ) ?>
		</a>
	</nav>
	<form id="rma-theme-settings" action="" method="post">
		<table class="form-table" role="presentation">
			<tbody>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( $inputs->star ) ?>"><?php _e( 'Star colour', 'ratemyagent-official' ) ?></label>
				</th>
				<td>
					<input type="color" id="<?php echo esc_attr( $inputs->star ) ?>"
						   name="<?php echo esc_attr( $inputs->star ) ?>"
						   value="<?php echo esc_attr( $theme->star ) ?>"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( $inputs->text_primary ) ?>"><?php _e( 'Primary text colour', 'ratemyagent-official' ) ?></label>
				</th>
				<td>
					<input type="color" id="<?php echo esc_attr( $inputs->text_primary ) ?>"
						   name="<?php echo esc_attr( $inputs->text_primary ) ?>"
						   value="<?php echo esc_attr( $theme->text_primary ) ?>"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( $inputs->text_secondary ) ?>"><?php _e( 'Secondary text color', 'ratemyagent-official' ) ?></label>
				</th>
				<td>
					<input type="color" id="<?php echo esc_attr( $inputs->text_secondary ) ?>"
						   name="<?php echo esc_attr( $inputs->text_secondary ) ?>"
						   value="<?php echo esc_attr( $theme->text_secondary ) ?>"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( $inputs->bg ) ?>"><?php _e( 'Background colour', 'ratemyagent-official' ) ?></label>
				</th>
				<td>
					<input type="color" id="<?php echo esc_attr( $inputs->bg ) ?>"
						   name="<?php echo esc_attr( $inputs->bg ) ?>"
						   value="<?php echo esc_attr( $theme->bg ) ?>"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( $inputs->pagination ) ?>">
						<?php _e( 'Pagination dots', 'ratemyagent-official' ) ?>
					</label>
				</th>
				<td>
					<input type="color" id="<?php echo esc_attr( $inputs->pagination ) ?>"
						   name="<?php echo esc_attr( $inputs->pagination ) ?>"
						   value="<?php echo esc_attr( $theme->pagination ) ?>"/>
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="hidden" name="<?php echo esc_attr( $inputs->update_action ) ?>" value="true"/>
			<input type="submit" value="<?php _e( 'Update theme settings', 'ratemyagent-official' ) ?>"
				   id="<?php echo esc_attr( $inputs->update_action ) ?>"
				   class="button button-primary"/>
		</p>
	</form>
</div>
