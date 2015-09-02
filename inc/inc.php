<?php

/**
 * undocumented class
 *
 * @package default
 * @author
 **/
class WP_Code_Queue {

	public function __construct() {
		add_action( 'wp_ajax_wp_code_queue', array( $this, 'wp_code_queue' ) );
		add_action( 'wp_ajax_nopriv_wp_code_queue', array( $this, 'wp_code_queue' ) );

		add_action( 'wp_ajax_wp_code_queue_query', array( $this, 'wp_code_queue_query' ) );
		add_action( 'wp_ajax_nopriv_wp_code_queue_query', array( $this, 'wp_code_queue_query' ) );
	}

	public static function wp_code_queue_query() {

		$refresh = isset( $_GET['refresh'] ) ? sanitize_text_field( $_GET['refresh'] ) : false;
		$queue = new WP_Query( array(
			'post_type' => 'wp-code-queue-post',
			'post_per_page' => 50,
		) ); ?>
		<ul>
			<?php while ( $queue->have_posts() ) {
				$queue->the_post();
				echo '<li><a href="' . esc_url( get_the_title() ) . '" target="_blank">' . get_the_title() . '</a></li>';
			} ?>
		</ul>

		<?php if ( 'refresh' == $refresh ) {
			die();
		}
	}

	public function wp_code_queue() {

		$link = sanitize_text_field( $_GET['link'] );

		// This is not the link we are looking for
		if ( 0 === preg_match( '#https?://github.com#', $link ) ) {
			return false;
		}

		// check if post exists
		$queue_check = get_page_by_title( $link, 'OBJECT', 'wp-code-queue-post' );


		if ( ! isset( $queue_check->ID ) && empty( $queue_check->ID ) ) {
			wp_insert_post( array(
				'post_type' => 'wp-code-queue-post',
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