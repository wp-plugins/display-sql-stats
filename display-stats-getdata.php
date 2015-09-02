<?php
global $wpdb;
// get SQL statement to be used
$dss_sql_string_array=get_option("dss_sql_string_array");
//print "->>";print_r($dss_sql_string_array);
$i=0;
foreach ($dss_sql_string_array as $single_statement) {
	print "\n".'var data'.$i.' = google.visualization.arrayToDataTable(['."\n";
	$i++;

	$result = $wpdb->get_results($single_statement, ARRAY_A);

	// Create the data table
	
	if (!$result) {
		print '"'.__('No result', 'dss').'"';
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
	
	print "\n".']);';
}
?>