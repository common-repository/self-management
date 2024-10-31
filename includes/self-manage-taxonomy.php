<?php

/* Set up the taxonomies. */
add_action( 'init', 'pas_self_manage_register_taxonomies' );

/* Register taxonomies. */
function pas_self_manage_register_taxonomies() {
	
	/* Set up the 'project' taxonomy arguments. */
	$project_args = array(
		'hierarchical' => true,
		'query_var' => 'task_project',
		'show_tagcloud' => true,
		'rewrite' => array(
			'slug' => 'self-manage/projects',
			'with_front' => false
		),
		'labels' => array(
			'name' => 'Projects',
			'singular_name' => 'Project',
			'edit_item' => 'Edit Project',
			'update_item' => 'Update Project',
			'add_new_item' => 'Add New Project',
			'new_item_name' => 'New Project Name',
			'all_items' => 'All Projects',
			'search_items' => 'Search Projects',
			'popular_items' => 'Popular Projects',
			'separate_items_with_commas' => 'Separate projects with commas',
			'add_or_remove_items' => 'Add or remove projects',
			'choose_from_most_used' => 'Choose from the most popular categories',
		)
	);
	
	/* Register the project taxonomy. */
	register_taxonomy( 'task_project', array( 'to_do_list' ), $project_args );
}

?>