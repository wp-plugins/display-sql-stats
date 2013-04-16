<?php 
dss_set_lang_file();
if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
}
	




/**
 * Display the plugin settings options page
 */


	echo '<div class="wrap">';
	echo '<h2><a href="'.DSS_AUTHOR_URI.'" target="_blank">' . __( 'Display SQL Stats', 'dss' ) .'</a></h2>'."\n";
    //settings_errors();
 
 	print '<form method="post" action="options.php" id="dss_form">';
	wp_nonce_field('update-options', '_wpnonce');
	settings_fields( 'dss_option-group');
 
  
	print'
		<input type="hidden" name="page_options" value="dss_sql_string, dss_options_array, dss_debug, dss_title" />
		<table class="form-table">
		<tr valign="top">
		<th scope="row">'.__('Enter your SQL statement and give it a title.', 'dss').'</th>
		</tr>
		<tr>
		<td>
		'.__('Title: ', 'dss').'<input type="text" name="dss_title" value="'.get_option("dss_title", DSS_TITLE_DEFAULT).'" size="50">
		<br />
		<textarea type="text" name="dss_sql_string" cols="100" rows="3">'.get_option("dss_sql_string", DSS_SQL_DEFAULT).'</textarea>
		<br />
		<input type="checkbox" name="dss_debug" value="1" '.dss_checked("dss_debug", "1").'/> '.__('Show debug information in dashboard', 'dss').'		
		</td>
		</tr>
		</table>
		<input type="hidden" name="action" value="update" />

	';
 
 
	print '<p class="submit"><input type="submit" name="submit" value="'.__('Save Changes', 'dss').'" /></p>';

	print '</form>';
	print '</div>';

	print '<br /><br /><br />';
	require_once('whatsup.php');


	
	

?>