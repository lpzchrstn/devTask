<?php
/**
 * Neve functions.php file
 *
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      17/08/2018
 *
 * @package Neve
 */

define( 'NEVE_VERSION', '2.8.2' );
define( 'NEVE_INC_DIR', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'NEVE_ASSETS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/' );

if ( ! defined( 'NEVE_DEBUG' ) ) {
	define( 'NEVE_DEBUG', false );
}
define( 'NEVE_NEW_DYNAMIC_STYLE', true );
/**
 * Themeisle SDK filter.
 *
 * @param array $products products array.
 *
 * @return array
 */
function neve_filter_sdk( $products ) {
	$products[] = get_template_directory() . '/style.css';

	return $products;
}

add_filter( 'themeisle_sdk_products', 'neve_filter_sdk' );

add_filter( 'themeisle_onboarding_phprequired_text', 'neve_get_php_notice_text' );

/**
 * Get php version notice text.
 *
 * @return string
 */
function neve_get_php_notice_text() {
	$message = sprintf(
	/* translators: %s message to upgrade PHP to the latest version */
		__( "Hey, we've noticed that you're running an outdated version of PHP which is no longer supported. Make sure your site is fast and secure, by %s. Neve's minimal requirement is PHP 5.4.0.", 'neve' ),
		sprintf(
		/* translators: %s message to upgrade PHP to the latest version */
			'<a href="https://wordpress.org/support/upgrade-php/">%s</a>',
			__( 'upgrading PHP to the latest version', 'neve' )
		)
	);

	return wp_kses_post( $message );
}

/**
 * Adds notice for PHP < 5.3.29 hosts.
 */
function neve_php_support() {
	printf( '<div class="error"><p>%1$s</p></div>', neve_get_php_notice_text() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

if ( version_compare( PHP_VERSION, '5.3.29' ) <= 0 ) {
	/**
	 * Add notice for PHP upgrade.
	 */
	add_filter( 'template_include', '__return_null', 99 );
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	add_action( 'admin_notices', 'neve_php_support' );

	return;
}

function divTable_style() {
	if( is_page( 6 ) ) {
		wp_enqueue_style( 'divs', get_template_directory_uri() . '/assets/css/divtable.css' );  
		//wp_enqueue_script( 'apiFetch', get_template_directory_uri() . '/assets/js/apiPostsFetch.js' );  
		wp_enqueue_script( 'apiFetch', get_template_directory_uri() . '/assets/js/apiPostsFetch.js', array('jquery'), '', true );
		wp_enqueue_script( 'main_js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '', true );
		
		wp_localize_script('apiFetch', 'nonceData',array(
			'nonce' => wp_create_nonce('wp_rest')
		));
	} 
}

add_action( 'wp_enqueue_scripts', 'divTable_style' );


// Custom Post Type With Meta Boxes
function register_custom_post_type() {
	register_post_type( 'artwork', ['public' => true, 'label' => 'Artwork'] );
}

add_action( 'init', 'register_custom_post_type' );


function custom_meta() {
	add_meta_box( 'artwork_details','Art Details','custom_meta_callback', 'artwork', 'side' );
}

function custom_meta_callback( $post ) {
	wp_nonce_field( 'save_art_details', 'artwork_details_nonce' );

	$artist = get_post_meta( $post->ID, 'art_artist', true );
	$price = get_post_meta( $post->ID, 'art_price', true );

	echo '<label for="art_artist">Artist: </label>';
	echo '<input type="text" id="art_artist" name="artist_field" value="'.$artist.'"><br><br>';
	echo '<label for="art_price">Price: </label>';
	echo '<input type="text" id="art_price" name="price_field" value="'.$price.'">';
}

function save_art_details( $post_id ) {
	if( ! isset( $_POST['artwork_details_nonce'] ) ){
		return;
	}

	if( ! isset( $_POST['artist_field']) || ! isset( $_POST['price_field'] ) ){
		return;
	}

	$artist = sanitize_text_field( $_POST['artist_field'] );
	$price = sanitize_text_field( $_POST['price_field'] );

	update_post_meta( $post_id, 'art_artist', $artist );
	update_post_meta( $post_id, 'art_price', $price );
}

add_action( 'add_meta_boxes', 'custom_meta' );
add_action( 'save_post', 'save_art_details' );

require_once 'globals/migrations.php';
require_once 'globals/utilities.php';
require_once 'globals/hooks.php';
require_once 'globals/sanitize-functions.php';
require_once get_template_directory() . '/start.php';


require_once get_template_directory() . '/header-footer-grid/loader.php';
