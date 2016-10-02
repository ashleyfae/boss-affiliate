<?php
/**
 * Plugin Settings
 *
 * @package   boss-affiliate
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

/**
 * Get Settings
 *
 * Returns array of all settings.
 *
 * @since 1.0.0
 * @return array
 */
function boss_affiliate_get_settings() {
	$settings = get_option( 'boss_affiliate', array() );

	if ( ! is_array( $settings ) ) {
		$settings = array();
	}

	return $settings;
}

/**
 * Get Setting
 *
 * Returns the value of a single setting.
 *
 * @param string $key ID of the setting to retrieve.
 *
 * @since 1.0.0
 * @return mixed
 */
function boss_affiliate_get_setting( $key ) {
	$settings = boss_affiliate_get_settings();

	return array_key_exists( $key, $settings ) ? $settings[ $key ] : false;
}

/**
 * Register Settings
 *
 * @since 1.0.0
 * @return void
 */
function boss_affiliate_settings_init() {

	// Add section.
	add_settings_section(
		'boss_affiliate_section',
		__return_null(),
		'__return_false',
		'affiliate-disclosure'
	);

	// Add fields.
	add_settings_field(
		'boss_affiliate[disclosure]',
		__( 'Disclosure Message', 'boss-affiliate' ),
		'boss_affiliate_disclosure_callback',
		'affiliate-disclosure',
		'boss_affiliate_section'
	);

	// Create settings in the options table.
	register_setting( 'boss_affiliate', 'boss_affiliate', 'boss_affiliate_sanitize_settings' );

}

add_action( 'admin_init', 'boss_affiliate_settings_init' );

/**
 * Sanitize Settings
 *
 * @param array $input Newly submitted settings.
 *
 * @since 1.0.0
 * @return array Sanitized settings.
 */
function boss_affiliate_sanitize_settings( $input = array() ) {

	$existing_settings = get_option( 'boss_affiliate', array() );

	if ( ! is_array( $existing_settings ) ) {
		$existing_settings = array();
	}

	if ( empty( $_POST['_wp_http_referer'] ) ) {
		return $input;
	}

	$sanitized_settings = array();

	foreach ( $input as $key => $value ) {

		switch ( $key ) {

			case 'disclosure' :
				$sanitized_settings[ $key ] = wp_kses_post( $value );
				break;

		}

	}

	// Merge new settings with existing.
	$new_settings = array_merge( $existing_settings, $sanitized_settings );

	return $new_settings;

}

/**
 * Callback: Disclosure Message
 *
 * @param array $args
 *
 * @since 1.0.0
 * @return void
 */
function boss_affiliate_disclosure_callback( $args ) {
	$disclosure = boss_affiliate_get_setting( 'disclosure' );
	?>
	<p>
		<label for="boss_affiliate_disclosure"><?php _e( 'Enter the disclosure message you want to add to your posts.', 'boss-affiliate' ); ?></label>
	</p>
	<textarea id="boss_affiliate_disclosure" name="boss_affiliate[disclosure]" class="large-text" rows="8"><?php echo esc_textarea( $disclosure ); ?></textarea>
	<?php
}