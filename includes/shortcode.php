<?php
/**
 * Disclosure Shortcode
 *
 * @package   boss-affiliate
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Disclosure Shortcode
 *
 * @param array  $atts    Shortcode attributes. This shortcode doesn't have any though!
 * @param string $content Shortcode content used to override the disclosure message.
 *
 * @since 1.0.0
 * @return string
 */
function boss_affiliate_disclosure_shortcode( $atts, $content = '' ) {

	$disclosure = $content;

	// Only use the disclosure from settings if we have no content. This lets people customize
	// the disclosure if they really want.
	if ( ! $content ) {
		$disclosure = boss_affiliate_get_setting( 'disclosure' );
	}

	$html = '<div class="boss-affiliate-disclosure">' . apply_filters( 'boss_affiliate_disclosure', $disclosure ) . '</div>';

	return apply_filters( 'boss_affiliate_shortcode_disclosure', $html, $disclosure, $atts, $content );

}

add_shortcode( 'disclosure', 'boss_affiliate_disclosure_shortcode' );

/**
 * Automatically add paragraph tags to disclosure.
 *
 * @since 1.0.0
 */
add_filter( 'boss_affiliate_disclosure', 'wpautop', 10 );

/**
 * Auto Add Disclosure
 *
 * The disclosure is automatically added if all the following apply:
 *      + We're not in a post excerpt. We add this to full posts only.
 *      + The 'tag' setting is filled out.
 *      + The current post has the specified tag applied.
 *
 * @param string $content Post content.
 *
 * @since 1.0.0
 * @return string
 */
function boss_affiliate_auto_add_disclosure( $content ) {

	// Bail if we're in an excerpt.
	if ( in_array( 'get_the_excerpt', $GLOBALS['wp_current_filter'] ) ) {
		return $content;
	}

	$tag = boss_affiliate_get_setting( 'tag' );

	// Bail if no tag is specified - this means manual addition.
	if ( ! $tag ) {
		return $content;
	}

	// Bail if current post doesn't have this tag.
	if ( ! has_tag( $tag ) ) {
		return $content;
	}

	// Otherwise, we can add the disclosure. Woot.
	$new_content = do_shortcode( '[disclosure]' ) . $content;

	return $new_content;

}

add_filter( 'the_content', 'boss_affiliate_auto_add_disclosure', 200 );