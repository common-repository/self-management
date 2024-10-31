<?php

/* Set up to-do-list shortcode. */
add_action( 'init', 'pas_to_do_list_register_shortcodes' );

function pas_to_do_list_register_shortcodes() {
	
	/* Register the [to_do_list] shortcode. */
	add_shortcode( 'to_do_list', 'pas_to_do_list_shortcode' );
}

function pas_to_do_list_shortcode() {

	/* Query tasks from the database. */
	$loop = new WP_Query(
		array(
			'post_type' => 'to_do_list',
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => -1,
		)
	);
	
	/* Check if any tasks were returned . */
	if ( $loop->have_posts() ) {
		
		/* Open an unordered list. */
		$output = '<ul class="to-do-list">';
		
		/* Loop through the tasks. */
		while ( $loop->have_posts() ) {
			
			$loop->the_post();
			
			/* Display the task title. */
			$output .= the_title(
				'<li><a href="' . get_permalink() . '">',
				'</a></li>',
				false
			);

			/* Show the task project. */
			$output .= get_the_term_list( get_the_ID(), 'task_project',
				'Project: ', ', ', ' ' );
				
			/* Insert a line break. */
			$output .= '<br /><br />';
		}
		
		/* Close the unordered list. */
		$output .= '</ul>';
	}
	
	/* If no tasks were found. */
	else {
		$output = '<p>No tasks have been created.';
	}
	
	/* Return the to-do-list. */
	return $output;
}

/* Set up Eisenhower matrix shortcode. */
add_action( 'init', 'pas_matrix_register_shortcodes' );

function pas_matrix_register_shortcodes() {
	
	/* Register the [eisenhower_matrix] shortcode. */
	add_shortcode( 'eisenhower_matrix', 'pas_matrix_shortcode' );
}

function pas_matrix_shortcode() {

	/* Query tasks from the database. */
	$loop = new WP_Query(
		array(
			'post_type' => 'to_do_list',
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => -1,
		)
	);
	
	/* Check if any tasks were returned . */
	if ( $loop->have_posts() ) {
		
		/* Create an empty table. */
		$output = '<table>';
		$important_urgent_task_list = '';
		$important_not_urgent_task_list = '';
		$not_important_urgent_task_list = '';
		$not_important_not_urgent_task_list = '';
		
		/* Loop through the tasks. */
		while ( $loop->have_posts() ) {
			
			$loop->the_post();
				
			/* Get ID of the current post. */
			$current_post_id = get_the_ID();
			
			//retrieve the metadata values if they exist
			$pas_metabox_status = get_post_meta( $current_post_id, '_pas_metabox_status', true );
			$pas_metabox_importance = get_post_meta( $current_post_id, '_pas_metabox_importance', true );
			$pas_metabox_urgency = get_post_meta( $current_post_id, '_pas_metabox_urgency', true );
			
			/* Check if the task is both important and urgent and append it to the first quadrant. */
			if ( $pas_metabox_importance == 'important' && $pas_metabox_urgency == 'urgent' ) {
				// show the task title
				$important_urgent_task_list .= the_title(
					'<li><a href="' . get_permalink() . '">',
					'</a></li>',
					false
				);
				// show the task project (special taxonomy)
				$important_urgent_task_list .= get_the_term_list( get_the_ID(), 'task_project',
					'Project: ', ', ', ' ' );
			}
			
			/* Check if the task is both important and not urgent and append it to the second quadrant. */
			else if ( $pas_metabox_importance == 'important' && $pas_metabox_urgency == 'not_urgent' ) {
				// show the task title
				$important_not_urgent_task_list .= the_title(
					'<li><a href="' . get_permalink() . '">',
					'</a></li>',
					false
				);
				// show the task project (special taxonomy)
				$important_not_urgent_task_list .= get_the_term_list( get_the_ID(), 'task_project',
					'Project: ', ', ', ' ' );
			}
			
			/* Check if the task is both not important and urgent and append it to the third quadrant. */
			else if ( $pas_metabox_importance == 'not_important' && $pas_metabox_urgency == 'urgent' ) {
				// show the task title
				$not_important_urgent_task_list .= the_title(
					'<li><a href="' . get_permalink() . '">',
					'</a></li>',
					false
				);
				// show the task project (special taxonomy)
				$not_important_urgent_task_list .= get_the_term_list( get_the_ID(), 'task_project',
					'Project: ', ', ', ' ' );
			}
			
			/* Check if the task is both not important and not urgent and append it to the fourth quadrant. */
			else if ( $pas_metabox_importance == 'not_important' && $pas_metabox_urgency == 'not_urgent' ) {
				// show the task title
				$not_important_not_urgent_task_list .= the_title(
					'<li><a href="' . get_permalink() . '">',
					'</a></li>',
					false
				);
				// show the task project (special taxonomy)
				$not_important_not_urgent_task_list .= get_the_term_list( get_the_ID(), 'task_project',
					'Project: ', ', ', ' ' );
			}
			
		} // end while loop.
		
		/* Append quadrants to the table. */
		$css_path = WP_PLUGIN_URL . "/self-management/css/style.css";
		$js_path = WP_PLUGIN_URL . "/self-management/js/self-manage-functions.js";
		$js_path_jquery = WP_PLUGIN_URL . "/self-management/js/jquery.js";
		
		$output .= <<<HERE
			<tr><td>
			<script type="text/javascript" src="$js_path"></script>
			<script type="text/javascript" src="$js_path_jquery"></script>
			<link rel="stylesheet" type="text/css" href="$css_path">
			<div id="kv1" >1</div>
			<div id="kv2" >2</div>
			<div id="kv3" >3</div>
			<button  onclick="addEffect1()">Эффект Show()</button>
			<button  onclick="addEffect2()">Эффект SlideDown()</button>
			<button  onclick="addEffect3()">Эффект Animate()</button>
			</td></tr>
HERE;
		$output .= '<tr><td></td><td>Urgent</td><td>Not Urgent</td></tr>';
		$output .= '<tr><td>Important</td><td>';
		$output .= $important_urgent_task_list;
		$output .= '</td><td>';
		$output .= $important_not_urgent_task_list;
		$output .= '</td></tr><tr><td>Not Important</td><td>';
		$output .= $not_important_urgent_task_list;
		$output .= '</td><td>';
		$output .= $not_important_not_urgent_task_list;
		$output .= '</td></tr></table>';
		
	} // end if statement.
	
	/* If no tasks were found. */
	else {
		$output = '<p>No tasks have been created.';
	}
	
	/* Return the to-do-list. */
	return $output;
}

?>