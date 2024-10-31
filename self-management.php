<?php

/*
Plugin Name: Self-Management
Plugin URI: http://taraspasichnyk.com/plugins/self-management/
Description: Plugin for planning in Wordpress. Creates a shortcode with Eisenhower matrix.
Version: 0.2
Author: Taras Pasichnyk
Author URI: http://taraspasichnyk.com
License: GPLv2
*/

/********
* Features:
* creates a 'Tasks' page with the list of tasks;
* each task includes: title, description, status (active, completed), importance, urgency;
* creates Eisenhower matrix which sorts the tasks. Use shortcode [eisenhower_matrix].
********/

/* Determine global variables and constants */
define( "PLUGIN_PATH", plugin_dir_path( __FILE__ ) );

/* Register activation hook which is executed after plugin installation. */
/* register_activation_hook( __FILE__, 'pas_create_tasks_page' );

function pas_create_tasks_page() {
*/
	/* Create post object. */
	/* $tasks_page_args = array(
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_author'  => $user_ID,
		'post_title'   => 'Tasks'
		//'post_content' => 'Will be soon' // need to be replaced by a variable
	); */
	
	/* Insert the page into the database and return id of the page. */
	// $pas_tasks_page_id = wp_insert_post( $tasks_page_args );
	
	/* Set 'Tasks' page template. */
	//update_post_meta( $pas_tasks_page_id, '_wp_page_template', dirname( __FILE__ ) . '/task-list-template.php' );
    //update_post_meta( $pas_tasks_page_id, '_wp_page_template', 'task-list-template.php' );
//}

/* Including custom template files to the 'Task' page. */ 
/* add_filter( 'template_include', 'include_task_list_template_file', 1, 1 );

function include_task_list_template_file( $template ) {

	$current_post_id = get_the_ID();
	$task_title = get_the_title( $current_post_id );
	if ( $task_title == 'Tasks' )
		return dirname( __FILE__ ) . '/task-list-template.php';
	return $template;
} */
	
/* Require functions and classes for displaying widgets. */
//require( dirname(__FILE__) . '/includes/self-manage-widget.php' );

/* Require functions and classes for creating wp-admin menu of the plugin */
//require( dirname(__FILE__) . '/includes/self-manage-menu.php' );

/* Require functions and classes for creating and displaying new post type */
require( dirname(__FILE__) . '/includes/self-manage-post-type.php' );

/* Require functions and classes for creating and displaying shortcodes */
require( dirname(__FILE__) . '/includes/self-manage-shortcodes.php' );

/* Require functions for creating taxonomies */
require( dirname(__FILE__) . '/includes/self-manage-taxonomy.php' );

?>