<?php

/* Set up 'to-do-list' post type */
add_action( 'init', 'pas_to_do_list_register_post_type' );

/* Register 'to-do-list' post type */
function pas_to_do_list_register_post_type() {
	
	/* Set up the arguments for the 'to_do_list' post type */
	$to_do_list_args = array(
		'public' => true,
		'query_var' => 'pas_to_do_list',
		'rewrite' => array(
			'slug' => 'self-manage/to-do-list',
			'with_front' => false,
		),
		'labels' => array(
			'name' => 'Task',
			'add_new' => 'Add New Task',
			'add_new_item' => 'Add New Task',
			'edit_item' => 'Edit Task',
			'new_item' => 'New Task',
			'view_item' => 'View Task',
			'search_items' => 'Search Tasks',
			'not_found' => 'No Tasks Found',
			'not_found_in_trash' => 'No Tasks Found In Trash'
		),
		'supports' => array(
			'title',
			'editor',
			'author',
			'comments',
			'custom-fields'
		)
	);
	
	/* Register the 'to_do_list' post type */
	register_post_type( 'to_do_list', $to_do_list_args );
	
	/* Register js-files in WordPress */
	// wp_enqueue_script( $handle, $src, $dependencies, $ver, $in_footer );
}

/* Register meta boxes for the "to_do_list" post type. */
add_action( 'add_meta_boxes', 'pas_metabox_create' );

function pas_metabox_create() {
	
	//create a custom meta box
	add_meta_box( 'pas_meta', 'Task Meta Box', 'pas_metabox_function', 'to_do_list', 'normal', 'high' );
}

/* Function for displaying metabox info on to-do-list posts admin page. */
function pas_metabox_function( $post ) {

	//retrieve the metadata values if they exist
	$pas_metabox_status = get_post_meta( $post->ID, 'pas_metabox_status', true );
	$pas_metabox_importance = get_post_meta( $post->ID, '_pas_metabox_importance', true );
	$pas_metabox_urgency = get_post_meta( $post->ID, '_pas_metabox_urgency', true );
	$checked_active = '';
	$checked_completed = '';
	$checked_not_important = '';
	$checked_important = '';
	
	//set 'active' default status when init or set other if needed
	switch ( $pas_metabox_status ) {
		case '':
			$pas_metabox_status = 'active';
			add_post_meta( $post->ID, 'pas_metabox_status', 'active', true );
			$checked_active = 'checked';
			break;
		case 'active':
			$checked_active = 'checked';
			break;
		case 'completed':
			$checked_completed= 'checked';
			break;
	}
	
	//set 'not important' default importance when init or set other if needed
	switch ( $pas_metabox_importance ) {
		case '':
			$pas_metabox_importance = 'not_important';
			add_post_meta( $post->ID, '_pas_metabox_importance', 'not_important', true );
			$checked_not_important = 'checked';
			break;
		case 'not_important':
			$checked_not_important = 'checked';
			break;
		case 'important':
			$checked_important = 'checked';
			break;
	}

	//set 'not urgent' default urgency when init or set other if needed
	switch ( $pas_metabox_urgency ) {
		case '':
			$pas_metabox_urgency = 'not_urgent';
			add_post_meta( $post->ID, '_pas_metabox_urgency', 'not_urgent', true );
			$checked_not_urgent = 'checked';
			break;
		case 'not_urgent':
			$checked_not_urgent = 'checked';
			break;
		case 'urgent':
			$checked_urgent = 'checked';
			break;
	}
	
	/* Print metabox form and text */
	
	//status form and text
	echo "Current status is '$pas_metabox_status' <br>";
	echo 'Please determine new status of the task:';
	echo <<<HERE
		<p>Status: <br>
		<input type='radio' name='pas_metabox_status' value='active' $checked_active>Active<br>
		<input type='radio' name='pas_metabox_status' value='completed' $checked_completed>Completed</p>
HERE;

	//importance form and text
	echo "Current importance is '$pas_metabox_importance' <br>";
	echo 'Please determine new importance of the task:';
	echo <<<HERE
		<p>Importance: <br>
		<input type='radio' name='pas_metabox_importance' value='not_important' $checked_not_important>Not important<br>
		<input type='radio' name='pas_metabox_importance' value='important' $checked_important>Important</p>
HERE;

	//urgency form and text
	echo "Current urgency is '$pas_metabox_urgency' <br>";
	echo 'Please determine new urgency of the task:';
	echo <<<HERE
		<p>Urgency: <br>
		<input type='radio' name='pas_metabox_urgency' value='not_urgent' $checked_not_urgent>Not urgent<br>
		<input type='radio' name='pas_metabox_urgency' value='urgent' $checked_urgent>Urgent</p>
HERE;
}

/* Hook to save the meta box data. */
add_action( 'save_post', 'pas_metabox_save_meta' );

function pas_metabox_save_meta( $post_id ) {

	//verify the 'status' metadata is set
	if ( isset( $_POST['pas_metabox_status'] ) ) {
		
		//save the 'status' metadata
		update_post_meta( $post_id, 'pas_metabox_status', strip_tags( $_POST['pas_metabox_status'] ) );
	}
	
	//verify the 'importance' metadata is set
	if ( isset( $_POST['pas_metabox_importance'] ) ) {
	
		//save the 'importance' metadata
		update_post_meta( $post_id, '_pas_metabox_importance', strip_tags( $_POST['pas_metabox_importance'] ) );
	}
		
	//verify the 'urgency' metadata is set
	if ( isset( $_POST['pas_metabox_urgency'] ) ) {
	
		//save the 'urgency' metadata
		update_post_meta( $post_id, '_pas_metabox_urgency', strip_tags( $_POST['pas_metabox_urgency'] ) );
	}
}

/* Show custom post type (to-do-list) on 'Tasks' page. */
add_filter( 'pre_get_posts', 'pas_self_manage_get_task_posts' );

function pas_self_manage_get_task_posts( $query ) {
	
	if ( is_page() && $query->is_main_query() ) //*** need to be modified to a variable
		$query->set( 'posts_per_page', 10 );

	return $query;
}

/* Set up 'change-task-status' filter. */
add_filter( 'the_content', 'pas_change_task_status_form' );

/* Set up 'change-task-importance' filter. */
add_filter( 'the_content', 'pas_change_task_importance_form' );

/* Set up 'change-task-urgency' filter. */
add_filter( 'the_content', 'pas_change_task_urgency_form' );

/* Show form for changing task status. */
function pas_change_task_status_form($content) {

	/* Get ID of the current post. */
	$current_post_id = get_the_ID();
	
	/* Get the permalink of the post by its ID. */
	$current_post_permalink = post_permalink($current_post_id);
	
	/* Update to-do-list metadata if 'complete task' button was clicked. */
	
	//verify the metadata is set
	if ( isset( $_POST['pas_metabox_status'] ) ) {
		
		//save the metadata
		update_post_meta( $current_post_id, 'pas_metabox_status', strip_tags( $_POST['pas_metabox_status'] ) );
	}
	
	//retrieve the metadata values if they exist
	$pas_metabox_status = get_post_meta( $current_post_id, 'pas_metabox_status', true );
	
	/* Construct a handler for the form - status of the task 'active'. */
	$active_task_form = <<<HERE
		<form action='$current_post_permalink' method='post'>
		<p><input type='hidden' name='pas_metabox_status' value='completed'></p>
		<p><input type='submit' value='Active. Set completed'></p>
		</form>
HERE;

	/* Construct a handler for the form - status of the task 'completed'. */
	$completed_task_form = <<<HERE
		<form action='$current_post_permalink' method='post'>
		<p><input type='hidden' name='pas_metabox_status' value='active'></p>
		<p><input type='submit' value='Completed. Set active'></p>
		</form>
HERE;

	/* Choose the button for status form */
	switch ( $pas_metabox_status ) {
	case 'active':
		$task_form = $active_task_form;
		break;
	case 'completed':
		$task_form = $completed_task_form;
		break;
	}	
	
	/* Attach a form handler to the content */
	$content .= $task_form;
	
	return $content;
	
}	

/* Show form for changing task importance. */
function pas_change_task_importance_form($content) {

	/* Get ID of the current post. */
	$current_post_id = get_the_ID();
	
	/* Get the permalink of the post by its ID. */
	$current_post_permalink = post_permalink($current_post_id);
	
	/* Update to-do-list metadata if 'importance' button was clicked. */
	
	//verify the metadata is set
	if ( isset( $_POST['pas_metabox_importance'] ) ) {
		
		//save the metadata
		update_post_meta( $current_post_id, '_pas_metabox_importance', strip_tags( $_POST['pas_metabox_importance'] ) );
	}
	
	//retrieve the metadata values if they exist
	$pas_metabox_importance = get_post_meta( $current_post_id, '_pas_metabox_importance', true );
	
	/* Construct a handler for the form - importance of the task 'not important'. */
	$not_important_task_form = <<<HERE
		<form action='$current_post_permalink' method='post'>
		<p><input type='hidden' name='pas_metabox_importance' value='important'></p>
		<p><input type='submit' value='Not important. Set important'></p>
		</form>
HERE;

	/* Construct a handler for the form - importance of the task 'important'. */
	$important_task_form = <<<HERE
		<form action='$current_post_permalink' method='post'>
		<p><input type='hidden' name='pas_metabox_importance' value='not_important'></p>
		<p><input type='submit' value='Important. Set not important'></p>
		</form>
HERE;

	/* Choose the button for importance form */
	switch ( $pas_metabox_importance ) {
	case 'not_important':
		$task_form = $not_important_task_form;
		break;
	case 'important':
		$task_form = $important_task_form;
		break;
	}	
	
	/* Attach a form handler to the content */
	$content .= $task_form;
	
	return $content;
	
}	

/* Show form for changing task urgency. */
function pas_change_task_urgency_form($content) {

	/* Get ID of the current post. */
	$current_post_id = get_the_ID();
	
	/* Get the permalink of the post by its ID. */
	$current_post_permalink = post_permalink($current_post_id);
	
	/* Update to-do-list metadata if 'urgency' button was clicked. */
	
	//verify the metadata is set
	if ( isset( $_POST['pas_metabox_urgency'] ) ) {
		
		//save the metadata
		update_post_meta( $current_post_id, '_pas_metabox_urgency', strip_tags( $_POST['pas_metabox_urgency'] ) );
	}
	
	//retrieve the metadata values if they exist
	$pas_metabox_urgency = get_post_meta( $current_post_id, '_pas_metabox_urgency', true );
	
	/* Construct a handler for the form - urgency of the task 'not urgent'. */
	$not_urgent_task_form = <<<HERE
		<form action='$current_post_permalink' method='post'>
		<p><input type='hidden' name='pas_metabox_urgency' value='urgent'></p>
		<p><input type='submit' value='Not urgent. Set urgent'></p>
		</form>
HERE;

	/* Construct a handler for the form - urgency of the task 'urgent'. */
	$urgent_task_form = <<<HERE
		<form action='$current_post_permalink' method='post'>
		<p><input type='hidden' name='pas_metabox_urgency' value='not_urgent'></p>
		<p><input type='submit' value='Urgent. Set not urgent'></p>
		</form>
HERE;

	/* Choose the button for urgency form */
	switch ( $pas_metabox_urgency ) {
	case 'not_urgent':
		$task_form = $not_urgent_task_form;
		break;
	case 'urgent':
		$task_form = $urgent_task_form;
		break;
	}	
	
	/* Attach a form handler to the content */
	$content .= $task_form;
	
	return $content;
	
}

?>