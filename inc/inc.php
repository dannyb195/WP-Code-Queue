<?php

/**
 * undocumented class
 *
 * @package default
 * @author
 **/
class WP_Code_Queue {

	public static $post_type = 'wp-code-queue-post';

	public function __construct() {
		add_action( 'wp_ajax_wp_code_queue', array( $this, 'wp_code_queue' ) );
		add_action( 'wp_ajax_nopriv_wp_code_queue', array( $this, 'wp_code_queue' ) );

		add_action( 'wp_ajax_wp_code_queue_query', array( $this, 'wp_code_queue_query' ) );
		add_action( 'wp_ajax_nopriv_wp_code_queue_query', array( $this, 'wp_code_queue_query' ) );
	}

	/**
	 * Default query that runs on load
	 * @return [type] [description]
	 */
	public static function wp_code_queue_query() {

		// Checking if we are auto refreshing
		$refresh = isset( $_GET['refresh'] ) ? sanitize_text_field( $_GET['refresh'] ) : false;

		// The Query
		$queue = new WP_Query( array(
			'post_type' => self::$post_type,
			'post_per_page' => 50,
		) ); ?>
		<ul>
			<?php while ( $queue->have_posts() ) {
				$queue->the_post();
				echo '<li><a href="' . esc_url( get_the_title() ) . '" data-id="' . intval( get_the_ID() ) . '" target="_blank">' . get_the_title() . '</a></li>';
			} ?>
		</ul>

		<?php
		// If we are refreshing we musr die(); here
		if ( 'refresh' == $refresh ) {
			die();
		}
	}

	/**
	 * Query that runs on ajax, i.e. we are sending a new link in or taking one out
	 * @return [type] [description]
	 */
	public function wp_code_queue() {

		$link = sanitize_text_field( $_GET['link'] );
		if ( 0 !== preg_match( '#^reviewing#', $link ) ) {
			// Not happy with get_page_by_title here, though considering this MVP for now
			$link = preg_replace( '#^reviewing\s#', '', $link );
			$post_object = get_page_by_title( $link, 'OBJECT', self::$post_type );

			if ( $post_object instanceof WP_POST ) {
				wp_delete_post( $post_object->ID, true );
				echo esc_html__( 'Thanks, I\'ve removed' . $link  . 'from the queue' ); // printf this
			} else {
				echo esc_html__( 'That post no longer exists', 'wp-code-queue' );
			}

			// sleep( 5 ); // Needs some feedback on if this pauses the server php or just the users function
			return;
		}
		// This is not the link we are looking for
		if ( 0 === preg_match( '#^https?://github.com#', $link ) ) {
			return false;
		}

		// check if post exists
		$queue_check = get_page_by_title( $link, 'OBJECT', 'wp-code-queue-post' );

		if ( ! isset( $queue_check->ID ) && empty( $queue_check->ID ) ) {
			wp_insert_post( array(
				'post_type' => self::$post_type,
				'post_title' => $link,
				'post_conetnt' => $link,
				'post_status' => 'publish',
			) );
		}

		self::wp_code_queue_query();

		die();
	}
} // END class

new WP_Code_Queue();