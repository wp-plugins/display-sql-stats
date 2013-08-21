<?php 
dss_set_lang_file();
if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
}

$dss_sql_string_array=get_option("dss_sql_string_array");

if (get_option("dss_debug")) {
	foreach ($dss_sql_string_array as $single_statement) {
		print $single_statement."<br /><p>\n";
		include('display-stats-getdata.php');
	}
}

$i=0;
foreach ($dss_sql_string_array as $single_statement) {
	print '<div id="chart_div'.$i.'"></div>'."\n";
	$i++;
}
?>
