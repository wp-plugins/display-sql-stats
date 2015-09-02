<?php
global $wpdb;
// get SQL statement to be used
$dss_sql_string_array=get_option("dss_sql_string_array");
$dss_switch_array=get_option("dss_switch_array");
$dss_title_array=get_option("dss_title_array");

//print "->>";print_r($dss_sql_string_array);

foreach ($dss_sql_string_array as $i=>$single_statement) {
	
	// chart visible?
	if ($dss_switch_array[$i]=="on") {
		$result = $wpdb->get_results($single_statement, ARRAY_A);
		// Create the data table
		if (!$result) {
			print "\ndocument.all.chart_div".$i.".innerHTML = '<br>".__('No results on: ', 'dss').$dss_title_array[$i]."';";
		} else {
			print "\n".'var data'.$i.' = new google.visualization.DataTable();'."\n";
			$comma_separated=array();
			foreach ($result as $row) {
				//print_r($row);print "<br />\n";
				array_walk($row, 'dss_quote_the_strings');
				array_push($comma_separated, "[".implode(", ", $row)."]" );
			}
			
			$comma_separated=implode(",\n", $comma_separated);
				//print_r($row);
				//print "<br >\n";
			$colname_array = array_keys($row);
				// detect and set column types
				foreach ($colname_array as $key=>$colnames) {
					
					// check for @ inside name
					$coltype=substr(strrchr($colnames, "@"),1);
					$colname=rtrim($colnames, "@".$coltype );
					
					//print $colnames."->".$colname."<-";
					//print "->".$coltype."<-\n";
					
					if ($coltype=="") {
						$coltype=dss_get_type($result[1][$colnames], "number");
					}
					
					
					print "data".$i.".addColumn('".strtolower($coltype)."','".$colname."');\n";
				}
			print "data".$i.".addRows([\n";
			
			//print_r($colnames);
			//print "['Datum', 'Wert'],";
			//print "['".implode("', '", $colnames)."'],\n" ;
			print_r($comma_separated);
			print "\n".']);';
		}
	
	}
	
	
}
?>