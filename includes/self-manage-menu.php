<?php

add_action( 'admin_menu', 'pas_create_menu' );

/* Creates menu for the plugin in the admin area on the dashboard */
function pas_create_menu() {

	// create custom top-level menu
	add_menu_page( 'Self Management Settings Page', 'Self Manage', 'manage_options',
		PLUGIN_PATH, 'pas_settings_page', plugins_url( 'self-management/images/pas-task.png', PLUGIN_PATH ) );

	// create submenu items
	add_submenu_page( PLUGIN_PATH, 'Uninstall Self-Manage Plugin', 'Uninstall', 'manage_options',
		PLUGIN_PATH . '_uninstall', 'pas_submenu_uninstall_page' );
		
}

?>