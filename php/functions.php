<?php

add_action( 'admin_menu', function() {

	add_menu_page(
		'Foo Banner',
		'Foo Banner',
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
		<h1>Foo Banner</h1>
		<form method="post">
			<?php wp_nonce_field( 'otgs-foo-banner' ); ?>
			<p>
				<label for="active">
					Active
					<input type="checkbox" name="active" value="1" <?php checked( (bool) $options['active'] ) ?>/>
					<?php if ( null !== $options['active_since'] ) : ?>
						<i>Active since <?php echo esc_html( human_time_diff( $options['active_since'] ) ) ?> ago.</i>
					<?php endif; ?>
				</label>
			</p>
			<p>
				<label for="content">
					Banner's content
					<input type="text" name="content" value="<?php echo esc_attr( $options['content'] ) ?>" />
				</label>
			</p>
			<p>
				<button id="otgs-fb-save" name="otgs-fb-save" class="button button-primary">Save</button>
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
	wp_enqueue_script( 'otgs-fb-confirm', OTGS_FB_PLUGIN_URL . '/js/confirm.js' );
} );