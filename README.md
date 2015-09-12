


#Description

This plugin in intended for use with an existing WordPress install behind a passowrd protected or 'is logged in' page

Internal code reviews are becoming more and more popluar in dev shops of all sizes. This plugin provides a way for managing developers to give their team
a place to paste a link from Github, which is added to a queue, displayed and updated across everyone's instance watching the page ( updated every 5 seconds ).

##Installation

- Download, upload, and active
- create a new page template
	- paste this code into the new template where you'd like the queue to be displayed
	- ```<?php if ( class_exists( 'WP_Code_Queue' ) ) : ?>
			<div class="wp-code-queue-wrapper">
				<input type="text" class="wp-code-queue" placeholder="<?php esc_html_e( 'Paste Github URL here', 'wp-code-queue' ); ?>" />
				<button class="wp-code-queue"><?php esc_html_e( 'Enter', 'wp-code-queue' ); ?></button>
				<div class="wp-code-queue-content">
					<?php WP_Code_Queue::wp_code_queue_query(); ?>
				</div>
			</div>
		<?php endif; ?>```


##Usage / Workflow

1. Developer A ( reviewee ) pastes a link from Github ( link are checked for the string of `http://github.com/` ) in the provided input field and hits enter
2. Developer B ( reviewer ) types 'reviewing <complete link of what they are reviewing>'. This will result in the link being taken out of the code queue and Developer B will then continue to do a code review via github