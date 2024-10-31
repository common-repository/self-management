<?php

/* Add widget after activation of the plugin */
add_action( 'widgets_init', 'pas_register_widget' );

/* Register widget */
function pas_register_widget() {
	register_widget( 'pas_to_do_list_widget' );
}

/* Register pas_to_do_list_widget class */
class pas_to_do_list_widget extends WP_Widget {
	/* Initialize a widget */
	function pas_to_do_list_widget() {
		$widget_ops = array(
			'classname' => 'pas_to_do_list_class',
			'description' => 'Display a to-do-list of the current user.'
		);
	$this->WP_Widget( 'pas_to_do_list_widget', 'My current to-do list', $widget_ops );
	}
	
	/* Build the widget settings form */
	function form( $data ) {
		$defaults = array( 
			'title' => 'My To-Do List',
			'task'  => '',
			'done'  => ''
		);
		$data = wp_parse_args( (array) $data, $defaults );
		$title = $data['title'];
		$task = $data['task'];
		$done = $data['done'];
		?>
		<p>Title: <input class="widefat" 
			name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" 
			value="<?php echo esc_attr( $title ); ?>" /></p>
		<p>Task: <textarea class="widefat"
			name="<?php echo $this->get_field_name( 'task' ); ?>" />
			<?php echo esc_attr( $task ); ?></textarea></p>
		<?php
	}
	
	/* Save the widget settings */
	function update( $new_data, $old_data ) {
		$data = $old_data;
		$data['title'] = strip_tags( $new_data['title'] );
		$data['task'] = strip_tags( $new_data['task'] );
		$data['done'] = strip_tags( $new_data['done'] );
		
		return $data;
	}
	
	/* Display the widget */
	function widget( $args, $data ) {
		extract( $args );
		
		echo $before_widget;
		$title = apply_filters( 'widget_title', $data['title'] );
		$task = empty( $data['task'] ) ? '&nbsp;' : $data['task'];
		
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '<p>Task: ' . $task . '</p>';
		echo $after_widget;
	}
}

?>