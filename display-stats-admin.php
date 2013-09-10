<?php 
dss_set_lang_file();
if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
}

global $chart_types_array;

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
	$dss_type_array=get_option("dss_type_array");
	$dss_sql_string_array=get_option("dss_sql_string_array");
	$dss_number_of_sql_statements=get_option("dss_number_of_sql_statements", DSS_NUMBER_OF_SQL_STATEMENTS_DEFAULT);

	print'
		<input type="hidden" name="page_options" value="dss_sql_string_array, dss_type_array, dss_debug, dss_title_array" />
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
			<table border="0"><tr>
			<td><textarea type="text" name="dss_sql_string_array['.$i.']" cols="100" rows="5">'.$dss_sql_string_array[$i].'</textarea></td>
			<td width="10"></td>
			<td valign="top">
 
  <select name="dss_type_array['.$i.']">'."\n";
 
			foreach ($chart_types_array as $chart_type_key=>$chart_type_value) {
				print '<option value="'.$chart_type_key.'"';
				if ($dss_type_array[$i]==$chart_type_key) print " selected";
				print '>'.$chart_type_value.'</option>'."\n";
			}
 
      
  print '</select>
  
			</td>
			</tr>
			</table>
			
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