<?php 
dss_set_lang_file();
if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
}



/**
 * Display the plugin settings options page
 */


	print '<div class="wrap">';
	print '<h2><a href="'.DSS_AUTHOR_URI.'" target="_blank">'.DSS_PLUGIN_NAME.' '.DSS_CURRENT_VERSION.' ('.DSS_CURRENT_BUILD.')</a></h2>'."\n";
    //settings_errors();
 
 	print '<form method="post" action="options.php" id="dss_form">';
	//wp_nonce_field('update-options', '_wpnonce');
	settings_fields( 'dss_option-group');
 
	$dss_title_array=get_option("dss_title_array");
	$dss_sql_string_array=get_option("dss_sql_string_array");
	$dss_number_of_sql_statements=get_option("dss_number_of_sql_statements", DSS_NUMBER_OF_SQL_STATEMENTS_DEFAULT);
	
	print'
		<input type="hidden" name="page_options" value="dss_sql_string_array, dss_options_array, dss_debug, dss_title_array" />
		<table class="form-table">
		<tr valign="top">
		<th scope="row">'.__('Enter your SQL statement(s) and give it/them a title.', 'dss').'</th>
		</tr>
		<tr>
		<td>
	';
	
	for ($i=0;$i<$dss_number_of_sql_statements;$i++) {
		print __('Title: ', 'dss').'<input type="text" name="dss_title_array['.$i.']" value="'.$dss_title_array[$i].'" size="50">
			<br />
			<textarea type="text" name="dss_sql_string_array['.$i.']" cols="100" rows="3">'.$dss_sql_string_array[$i].'</textarea>
			<br />
			<br />
		';
	}
	
	print'<input type="checkbox" name="dss_debug" value="1" '.dss_checked("dss_debug", "1").'/> '.__('Show debug information in dashboard', 'dss').'		
		<br />
		'.__('Number of SQL Statements: ', 'dss').'<input type="text" name="dss_number_of_sql_statements" value="'.$dss_number_of_sql_statements.'" size="4">
		<p></p>
		'.__('Notepad', 'dss').'
		<br />
		<textarea type="text" name="dss_notepad" cols="100" rows="10">'.get_option("dss_notepad", DSS_NOTEPAD_DEFAULT).'</textarea>
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