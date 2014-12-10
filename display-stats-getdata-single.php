<?php
function dss_getdata($dssno) {
	global $wpdb;
	global $current_user; # we need use logins ($current_user->user_login) for special sql
	get_currentuserinfo();
		
	// get SQL statement data to be used
	$dss_sql_string_array=get_option("dss_sql_string_array");
	$dss_switch_array=get_option("dss_switch_array");
	$dss_title_array=get_option("dss_title_array");
	
	$dss_sql_string=$dss_sql_string_array[$dssno];
	$dss_switch=$dss_switch_array[$dssno];
	$dss_title=$dss_title_array[$dssno];
	
	$minval=array();
	$maxval=array();

	$returnvalue="";
	
	// replace #user_login# with current user login
	$dss_sql_string=str_replace ("#user_login#", $current_user->user_login, $dss_sql_string);
	#$returnvalue.=print_r($dss_sql_string, true);
		
	$returnvalue.="// SQL: ".$dssno."\n";
	//print $dss_sql_string;
	
	// chart visible?
	if ($dss_switch=="on") {
		//print "ON";
		$result = $wpdb->get_results($dss_sql_string, ARRAY_A);
		// Create the data table
		if (!$result) {
			$returnvalue.="\ndocument.all.chart_div".$dssno.".innerHTML = '<br>".__('No results on:', 'dss')."&nbsp;".$dss_title."';";
		} else {
			$returnvalue.="\n\n".'var data'.$dssno.' = new google.visualization.DataTable();'."\n";
			$comma_separated=array();
			dss_log('$i:'.$i);
			dss_log('$result:'.$result);
			$minval[$i] = min( array_map("dss_realmin", $result) );
			$maxval[$i] = max( array_map("dss_realmax", $result) );

			foreach ($result as $row) {

				array_walk($row, 'dss_quote_the_strings');
				array_push($comma_separated, "[".implode(", ", $row)."]" );
			}
			
			$comma_separated=implode(",\n", $comma_separated);
			$colname_array = array_keys($row);
				// detect and set column types
				foreach ($colname_array as $key=>$colnames) {
					
					// check for @ inside name
					$coltype=substr(strrchr($colnames, "@"),1);
					$colname=rtrim($colnames, "@".$coltype );
					
					if ($coltype=="") {
						$coltype=dss_get_type($result[0][$colnames], "number");
					}
					
					
					$returnvalue.= "data".$dssno.".addColumn('".strtolower($coltype)."','".$colname."');\n";
				}
			$returnvalue.= "data".$dssno.".addRows([\n";
			
			$returnvalue.=print_r($comma_separated, true);
			$returnvalue.= "\n".']);';
		}
	
	}
	
	return $returnvalue;
}
?>