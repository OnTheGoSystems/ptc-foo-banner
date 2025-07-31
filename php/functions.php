<?php

add_action( 'admin_menu', function() {

	add_menu_page(
		__( 'Foo Banner', 'otgs-fb' ),
		__( 'Foo Banner', 'otgs-fb' ),
		'manage_options',
		'otgs-foo-banner',
		'otgs_fb_render_admin_page'
	);
} );

function otgs_fb_render_admin_page() {
	if ( isset( $_POST['otgs-fb-save'] ) && check_admin_referer( 'otgs-foo-banner' ) ) {
		$active = (int) ( $_POST['active'] ?? 0 );

		update_option(
			'otgs_fb_options',
			[
				'active'       => $active,
				'content'      => sanitize_text_field( $_POST['content'] ?? '' ),
				'active_since' => $active ? time() : null,
			]
		);
	}

	$options = otgs_fb_get_options();

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Foo Banner', 'otgs-fb' ) ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'otgs-foo-banner' ); ?>
			<p>
				<label for="active">
					<?php esc_html_e( 'Active', 'otgs-fb' ) ?>
					<input type="checkbox" name="active" value="1" <?php checked( (bool) $options['active'] ) ?>/>
					<?php if ( null !== $options['active_since'] ) : ?>
						<i><?php
							/* translators: %s is a time interval (e.g."7 mins") */
							printf( esc_html__( 'Active since %s ago.', 'otgs-fb' ), human_time_diff( $options['active_since'] ) )
						?></i>
					<?php endif; ?>
				</label>
			</p>
			<p>
				<label for="content">
				<?php esc_html_e( "Banner's content", 'otgs-fb' ) ?>
					<input type="text" name="content" value="<?php echo esc_attr( $options['content'] ) ?>" />
				</label>
			</p>
			<p>
				<button id="otgs-fb-save" name="otgs-fb-save" class="button button-primary"><?php esc_html_e( 'Save', 'otgs-fb' ) ?></button>
			</p>
		</form>
	</div>
	<?php
}

function otgs_fb_render_banner() {
	$options = get_option( 'otgs_fb_options' );

	if ( ! $options['active'] ) {
		return;
	}

	?>
	<div class="otgs-fb-wrap">
		<p style="text-align:center;background-color:#f00;color:#fff;margin-top:0;padding:5px">
			<?php echo esc_html( $options['content'] ) ?>
		</p>
	</div>
	<?php
}

add_action( 'wp_body_open', 'otgs_fb_render_banner' );

/**
 * @return array{active:int,content:string,active_since:int|null}
 */
function otgs_fb_get_options() {
	return array_merge(
		[
			'active'       => 0,
			'content'      => '',
			'active_since' => null,
		],
		get_option( 'otgs_fb_options', [] )
	);
}

add_action( 'admin_enqueue_scripts', function() {
	wp_enqueue_script( 'otgs-fb-confirm', OTGS_FB_PLUGIN_URL . '/js/confirm.js', [ 'wp-i18n' ] );
} );