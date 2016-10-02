<?php
/**
 * Register Admin Page
 *
 * @package   boss-affiliate
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

/**
 * Register Admin Menu
 *
 * Adds a new submenu under "Settings".
 *
 * @since 1.0.0
 * @return void
 */
function boss_affiliate_admin_menu() {
	add_options_page( __( 'Affiliate Disclosure', 'boss-affiliate' ), __( 'Affiliate Disclosure', 'boss-affiliate' ), 'manage_options', 'affiliate-disclosure', 'boss_affiliate_render_admin_page' );
}

add_action( 'admin_menu', 'boss_affiliate_admin_menu' );

/**
 * Render Admin Page
 *
 * @since 1.0.0
 * @return void
 */
function boss_affiliate_render_admin_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Affiliate Disclosure Settings', 'boss-affiliate' ); ?></h1>
		<form action="options.php" method="POST">
			<?php
			settings_fields( 'boss_affiliate' );
			do_settings_sections( 'affiliate-disclosure' );

			submit_button();
			?>
		</form>
	</div>
	<?php
}