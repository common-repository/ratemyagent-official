<div class="wrap">
	<header class="rma-page-header">
		<h1>
			<span class="rma-page-header-logo"><?php _e( 'RateMyAgent', 'ratemyagent-official' ) ?></span>
			<span class="rma-page-header-text"><?php _e( 'WordPress tools', 'ratemyagent-official' ) ?> </span>
		</h1>
	</header>
	<nav class="nav-tab-wrapper">
		<a href="?page=<?php echo esc_attr( $page ) ?>"
		   class="nav-tab <?php if ( $tab === null ) : ?>nav-tab-active<?php endif; ?>"><?php _e( 'Settings' ) ?></a>
		<a href="?page=<?php echo esc_attr( $page ) ?>&tab=advanced"
		   class="nav-tab <?php if ( $tab === 'advanced' ) : ?>nav-tab-active<?php endif; ?>"><?php _e( 'Advanced Settings' ) ?></a>
	</nav>
	<div class="tab-content">
		<h1> <?php esc_attr( $page ) ?></h1>
		<?php echo wp_kses( $content, \Rma\Helpers\TemplateHelpers::allowed_html() ) ?>
	</div>
</div>
