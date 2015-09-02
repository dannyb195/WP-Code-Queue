<?php
/**
 * @package WP_Code_Queue
 * @version 0.1
 */
/*
Plugin Name: WP Code Queue
Plugin URI:
Description: Code Queue for dev shops
Author: Dan Beil
Version: 0.1
Author URI:
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( __( "Cheatin' Huh?", 'wp-code-queue' ) );
}

define( 'WP_CODE_QUEUE_PATH', plugin_dir_path( __FILE__ ) );

// echo WP_CODE_QUEUE_PATH;

require_once( WP_CODE_QUEUE_PATH . 'inc/inc.php' );
require_once( WP_CODE_QUEUE_PATH . 'inc/post-types/class-wp-code-queue-post-type.php' );

function wp_code_queue_scripts() {
	wp_enqueue_script( 'wp-code-queue-js', plugins_url( 'js/wp-code-queue-js.js', __FILE__ ), array( 'jquery' ), '0.1', true );
	wp_localize_script( 'wp-code-queue-js', 'ajaxurl', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wp_code_queue_scripts' );

