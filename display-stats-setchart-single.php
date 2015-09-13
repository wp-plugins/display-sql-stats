<?php
function dss_setchart($dssno, $dsswidth, $dssheight, $pagesize) {
	global $chart_types_array;
	// get SQL statement data to be used
	
	$dss_switch_array=get_option("dss_switch_array");
	$dss_title_array=get_option("dss_title_array");
	$dss_type_array=get_option("dss_type_array");
	$dss_width_default=get_option("dss_width_default", DSS_WIDTH_DEFAULT_NEW);
	$dss_height_default=get_option("dss_height_default", DSS_HEIGHT_DEFAULT_NEW);	
	$dss_switch=$dss_switch_array[$dssno];
	$dss_title=$dss_title_array[$dssno];
	$dss_type=$dss_type_array[$dssno];	
	//print_r ($dss_type_array_to_use);
	$returnvalue="";
	
	if ($dsswidth=="") $dsswidth=$dss_width_default;
	if ($dssheight=="") $dssheight=$dss_height_default;
	
	// pagesize only needed for chartype table
	if (isset($pagesize) && $pagesize>0) $page='enable';
		
		// chart visible?
		if ($dss_switch=="on") {
			$returnvalue.= '	
			var options'.$dssno.' = {\'title\':\''.$dss_title.'\',
				\'is3D\':true,
				\'page\':\''.$page.'\',
				\'pageSize\':\''.$pagesize.'\',
				\'width\':\''.$dsswidth.'\',
				\'height\':\''.$dssheight.'\'';
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