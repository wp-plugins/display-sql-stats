<?php
global $wpdb;
// get SQL statement to be used
$dss_sql=get_option("dss_sql_string", DSS_SQL_DEFAULT);


$result = $wpdb->get_results($dss_sql, ARRAY_A);
if (!$result) {
	print __('No result', 'dss');
} else {
	$comma_separated=array();
	foreach ($result as $row) {
		//print_r($row);print "<br />\n";
		array_walk($row, 'dss_quote_the_strings');
		array_push($comma_separated, "[".implode(", ", $row)."]" );
	}

	$comma_separated=implode(",\n", $comma_separated);
		//print_r($row);
		//print "<br >\n";
	$colnames = array_keys($row);
	//print_r($colnames);
	//print "['Datum', 'Wert'],";
	print "['".implode("', '", $colnames)."']," ;
	print_r($comma_separated);
}
?>