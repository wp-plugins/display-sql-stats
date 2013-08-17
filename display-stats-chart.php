<?php 
dss_set_lang_file();
if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
}

if (get_option("dss_debug")) {
	print get_option("dss_sql_string1", DSS_SQL_DEFAULT)."<br /><p>\n";
	include('display-stats-getdata.php');
}
?>
<div id="chart_div"></div>