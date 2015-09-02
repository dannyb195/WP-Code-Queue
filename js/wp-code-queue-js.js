( function( $ ) {

	var $wpCodeContent = $( '.wp-code-queue-wrapper .wp-code-queue-content' ),
		$wpCodeinputTarget = $( '.wp-code-queue-wrapper input.wp-code-queue' ),
		$wpCodeButton = $( '.wp-code-queue-wrapper button.wp-code-queue' );

	function wpCodeQueueAjax( refresh ) {
		var link = $wpCodeinputTarget.val();
		$.ajax( {
			url: ajaxurl.ajaxurl,
			type: 'GET',
			data: {
				'action': 'wp_code_queue',
				'link': link,
				// 'refresh': refresh,
			},
			success: function( data ) {
				// console.log( data );
				$wpCodeContent.html( data );

			},
			error: function( data ) {
			},
		} );
	}

	// refreshing the div contents
	setInterval( function() {
		$.ajax( {
			url: ajaxurl.ajaxurl,
			type: 'GET',
			data: {
				'action': 'wp_code_queue_query',
				'refresh': 'refresh',
			},
			success: function( data ) {
				// console.log( data );
				$wpCodeContent.html( data );

			},
			error: function( data ) {

			},
		} );
	}, 1000 );

	// triggering our ajax on click
	$wpCodeButton.on( 'click', function() {
		wpCodeQueueAjax();
	} );

} ) ( jQuery );