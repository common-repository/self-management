=== Plugin Name ===
Contributors: Pasich
Donate link: http://taraspasichnyk.com/
Tags: management, planning, Eisenhower matrix 
Requires at least: 3.0.1
Tested up to: 3.4.2
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin for planning and self-management in Wordpress. Creates a shortcode with Eisenhower matrix.

== Description ==

Plugin for planning and self-management in Wordpress. Creates a shortcode with Eisenhower matrix.

Features:
* creates 'Tasks' menu in the admin area with the list of tasks;
* each task includes: title, description, comments, status (active, completed), importance (not important, important), urgency (not urgent, urgent);
* tasks are grouped in special categories named 'projects';
* you can change task status, importance and urgency both in WordPress admin page and on your website;
* creates Eisenhower matrix which sorts the tasks by importance and urgency. You can paste the matrix in any post/page using special shortcode [eisenhower_matrix].
* creates [to_do_list] shortcode which displays the list of current tasks.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `self-management` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Are you going to develop this plugin further? =

Yes, 0.1 is just an initial version of the 'self-management' plugin, and we are going to develop it further. So, please, don't chore it hardly.

== Screenshots ==

1. This is an opened 'task' page with corresponding information of the task status (active, completed), importance (not important, important) and urgency (not urgent, urgent). You can change these features of the task by clicking icons.
2. Here you can see a demonstration of the included [eisenhower_matrix] shortcode into a post. The shortcode creates a table with a list of yout tasks in the Eisenhower matrix manner.

== Changelog ==

= 0.2 =
* 'Tasks' page has been removed. Use shortcodes: [eisenhower_matrix] and [to_do_list] of the purpose of displaying tasks.
Further development:
* Add checkboxes to the Eisenhower matrix which delete accomplished tasks. *************************************
* Add js-windows in Eisenhower matrix for viewing major information about the task. ********************************

= 0.1 =
* Initial release.

== Upgrade Notice ==

= 0.1 =
* Initial release.