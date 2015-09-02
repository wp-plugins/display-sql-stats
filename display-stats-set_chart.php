<?php




$dss_title_array=get_option("dss_title_array");

$i=0;
foreach ($dss_title_array as $single_title) {

	print '
	
	var options'.$i.' = {\'title\':\''.$single_title.'\',
		\'is3D\':true,
		\'width\':400,
		\'height\':300};

	
	var chart'.$i.' = new google.visualization.LineChart(document.getElementById(\'chart_div'.$i.'\'));
	
	chart'.$i.'.draw(data'.$i.', options'.$i.');
	';
	$i++;
}
?>



