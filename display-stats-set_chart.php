<?php

$dss_title_array=get_option("dss_title_array");
$dss_type_array=get_option("dss_type_array");
global $chart_types_array;

$i=0;
foreach ($dss_title_array as $single_title_key=>$single_title_value) {

	print '
	
	var options'.$i.' = {\'title\':\''.$single_title_value.'\',
		\'is3D\':true,
		\'width\':500,
		\'height\':500};

	
	var chart'.$i.' = new google.visualization.'.$chart_types_array[$dss_type_array[$i]].'(document.getElementById(\'chart_div'.$i.'\'));
	
	chart'.$i.'.draw(data'.$i.', options'.$i.');
	';
	$i++;
}
?>



