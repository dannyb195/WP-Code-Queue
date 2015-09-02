<?php

/**
 * undocumented class
 *
 * @package default
 * @author
 **/
class WP_Code_Queue_Post_Type {

	private $name = 'wp-code-queue-post';

	public function __construct() {
		add_action( 'init', array( $this, 'reg_post_type' ) );
	}

	public function reg_post_type() {

		register_post_type( $this->name, array(
			'labels'              => array(
				'name'               => __( 'WP Code Queue Posts', 'wp-code-queue' ),
				'singular_name'      => __( 'WP Code Queue Post', 'wp-code-queue' ),
				'add_new'            => __( 'Add New WP Code Queue Post', 'wp-code-queue' ),
				'add_new_item'       => __( 'Add New WP Code Queue Post', 'wp-code-queue' ),
				'edit_item'          => __( 'Edit WP Code Queue Post', 'wp-code-queue' ),
				'new_item'           => __( 'New WP Code Queue Post', 'wp-code-queue' ),
				'view_item'          => __( 'View WP Code Queue Post', 'wp-code-queue' ),
				'search_items'       => __( 'Search WP Code Queue Posts', 'wp-code-queue' ),
				'not_found'          => __( 'No WP Code Queue Posts found', 'wp-code-queue' ),
				'not_found_in_trash' => __( 'No WP Code Queue Posts found in Trash', 'wp-code-queue' ),
				'parent_item_colon'  => __( 'Parent WP Code Queue Post:', 'wp-code-queue' ),
				'menu_name'          => __( 'WP Code Queue Posts', 'wp-code-queue' ),
			),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'can_export'          => true,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor', 'author', 'revisions', ),
		) );
	}

} // END class

new WP_Code_Queue_Post_Type();