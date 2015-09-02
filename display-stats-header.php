<!-- inserted by Wordpress plugin Display SQL Stats start-->
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {

	// Create the data table.
	var data = google.visualization.arrayToDataTable([
<?php
	//get data as matrix
	include('display-stats-getdata.php');
?>	
]);

	// Set chart options
	var options = {'title':'<?php print get_option("dss_title1", DSS_TITLE_DEFAULT); ?>',
		'is3D':true,
		'width':400,
		'height':300};

	// Instantiate and draw our chart, passing in some options.
	//var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	//var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	
	chart.draw(data, options);
  }
</script>
<!-- inserted by Wordpress plugin Display SQL Stats end-->