<?php
/*
Plugin Name: Display SQL Stats
Plugin URI: http://wordpress.org/extend/plugins/display-stats/
Description: Displaying SQL result data as graphical chart on the dashboard with use of Google Chart Tools.
Version: 0.4
Author: Juergen Schulze
Author URI: http://1manfactory.com/ds
License: GNU GP
*/

/*  Copyright 2013 Juergen Schulze, 1manfactory.com (email : 1manfactory@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


// Version/Build of the plugin and some default values
define( 'DSS_PLUGIN_NAME', 'Display SQL Stats' );
define( 'DSS_CURRENT_VERSION', '0.4' );
define( 'DSS_CURRENT_BUILD', '4' );
define( 'DSS_AUTHOR_URI', 'http://1manfactory.com/dss' );
define( 'DSS_SQL_DEFAULT', 'SELECT DATE_FORMAT (comment_date, "%Y-%m-%d") AS Date, COUNT(*) AS Count, 3 AS Target FROM wp_comments  GROUP BY Date ORDER BY Date ASC' );
define( 'DSS_NUMBER_OF_SQL_STATEMENTS_DEFAULT', '1' );
define( 'DSS_TITLE_DEFAULT', 'Comments' );
define( 'DSS_NOTEPAD_DEFAULT', __("Store whatever information you like here.\nOr try this statement:\nSELECT DATE_FORMAT (comment_date, \"%Y-%m-%d\") AS Date, COUNT(*) AS Count, 3 AS Target FROM wp_comments  GROUP BY Date ORDER BY Date ASC", 'dss') );


dss_set_lang_file();
add_action('admin_menu', 'dss_admin_actions');
add_action('admin_init', 'dss_init');
add_action('admin_head', 'dss_insert_header');


# init what we need
function dss_init() {
	register_setting( 'dss_option-group', 'dss_number_of_sql_statements');
	register_setting( 'dss_option-group', 'dss_sql_string_array', 'dss_check_sql' );
	register_setting( 'dss_option-group', 'dss_title_array');
	register_setting( 'dss_option-group', 'dss_options_array');
	register_setting( 'dss_option-group', 'dss_notepad');
	register_setting( 'dss_option-group', 'dss_debug');
}
	

/**
* Plugin deactivation
*/
register_deactivation_hook( __FILE__, 'dss_plugin_deactivation' );
function dss_plugin_deactivation() {
	// nothing right now. we will keep options in store
}

// uninstall
register_uninstall_hook (__FILE__, 'dss_uninstall');
function dss_uninstall() {
	# delete all data stored by DS
	delete_option('dss_number_of_sql_statements');
	delete_option('dss_sql_string_array');
	delete_option('dss_title_array');
	delete_option('dss_options_array');
	delete_option('dss_notepad');
	delete_option('dss_debug');
}


function dss_admin_actions() { 
	if (current_user_can('manage_options'))  {
		add_options_page(DSS_PLUGIN_NAME, DSS_PLUGIN_NAME, 'manage_options', "display-stats", "dss_show_admin");
	}
} 

function dss_show_admin(){
	include('display-stats-admin.php');
}


// sanitize function
function dss_check_sql($input) {
	global $wpdb;
	foreach ($input as $single_statement) {
		$result=$wpdb->query($single_statement);
		# check SQL
		if ($result===false) {
			$error=$wpdb->last_error;
			add_settings_error('dss_option-group', 'settings_updated', __('SQL Error: ', 'dss').$error."<br >\n".$single_statement, $type = 'error');
		}
	}
	return $input;
}

function dss_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('dss', $moFile);
	}
}

/**
 * Inhalt des Dashboard-Widget
 */
function dss_dashboard_insert() {
	include('display-stats-chart.php');
}

/**
 * Dashboard Widget hinzufügen
 */
function dss_dashboard_setup() {
	wp_add_dashboard_widget( 'dss_dashboard_insert', DSS_PLUGIN_NAME, 'dss_dashboard_insert' );
}

/**
 * Nutzen des Hook für Widget
 */
add_action('wp_dashboard_setup', 'dss_dashboard_setup');


function dss_checked($checkOption, $checkValue) {
	return get_option($checkOption)==$checkValue ? " checked" : "";
}

function dss_insert_header() {
	include('display-stats-header.php');
}

function dss_quote_the_strings(&$item, $key ) {
	if (!is_numeric($item)) {
		// quote value if not numeric
		$item="'".$item."'";
	}
}

?>