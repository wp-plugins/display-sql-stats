<?php

function dss_setchart($dssno) {
	global $chart_types_array;
	// get SQL statement data to be used
	
	$dss_switch_array=get_option("dss_switch_array");
	$dss_title_array=get_option("dss_title_array");
	$dss_type_array=get_option("dss_type_array");
	
	$dss_switch=$dss_switch_array[$dssno];
	$dss_title=$dss_title_array[$dssno];
	$dss_type=$dss_type_array[$dssno];	
	//print_r ($dss_type_array_to_use);
	$returnvalue="";
	
		
		// chart visible?
		if ($dss_switch=="on") {
			$returnvalue.= '	
			var options'.$dssno.' = {\'title\':\''.$dss_title.'\',
				\'is3D\':true,
				\'width\':500,
				\'height\':500';
				// only set min/max values with barcharts
				if ($chart_types_array[$dss_type]=="BarChart") $returnvalue.= ',
				\'hAxis\': { maxValue: \''.$maxval[$i].'\', minValue: \''.$minval[$i].'\', format: \'0\'}
				';
				
				$returnvalue.= '};

			
			var chart'.$dssno.' = new google.visualization.'.$chart_types_array[$dss_type].'(document.getElementById(\'chart_div'.$dssno.'\'));
			chart'.$dssno.'.draw(data'.$dssno.', options'.$dssno.');
			
			';
		}
	
	return $returnvalue;
}
?>



