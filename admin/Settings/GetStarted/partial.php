<div class="wrap">
	<div class="rma-getting-started">
		<div class="rma-get-started-hero">
			<?php echo wp_kses( \Rma\Helpers\TemplateHelpers::card_header(), \Rma\Helpers\TemplateHelpers::allowed_html() ) ?>
			<h1> <?php _e( 'Set up now to start displaying your reviews', 'ratemyagent-official' ) ?></h1>

			<p> <?php _e( 'Set up your plugin in minutes to start displaying your reviews', 'ratemyagent-official' ) ?></p>

			<div class="rma-get-started-hero-actions">
				<a href="?page=rma-settings-wizard"
				   class="button button-primary"><?php _e( 'Get Started', 'ratemyagent-official' ) ?></a>
				<a href="https://wordpress-widget.ratemyagent.com" target="_blank"
				   class="button button-secondary"><?php _e( 'Learn more', 'ratemyagent-official' ) ?></a>
			</div>
		</div>

		<div class="rma-get-started-benefits">
			<h2> <?php _e( 'The best review plugin for Real Estate professionals', 'ratemyagent-official' ) ?></h2>

			<div class="rma-get-started-benefit-list">
				<?php foreach ( $benefits as $benefit ): ?>
					<div class="rma-get-started-benefit">
						<img src="<?php echo esc_url( $benefit->icon ) ?>" alt="" height="60" width="60"/>
						<strong> <?php echo esc_html( $benefit->title ) ?></strong>
						<p> <?php _e( $benefit->body, 'ratemyagent-official' ) ?></p>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</div>
