<?php
session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();

$result = mysqli_query($conn, "SELECT count(issue_id) as numberr, facility from issue group by facility");

$number = [];
$facility = [];

while ($row = mysqli_fetch_array($result)) {
    $numberr[] = $row['numberr'];
    $facility[] = $row['facility'];
}
 echo json_encode($numberr);

?>
<!DOCTYPE html>
<html>
<head>
	<title>CHarts</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mt-5">
                <div class="card">
                    <div class="card-body">  
                        <div id="chartDiv"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    var chartData = {
      type: 'bar',  // Specify your chart type here.
      title: {
        text: 'Issues Chart' // Adds a title to your chart
      },
      legend: {values: <?php  echo json_encode($facility); ?> }, // Creates an interactive legend
      series: [  // Insert your series data here.
          { values: <?php  echo json_encode($numberr); ?>}
      ]
    };
    zingchart.render({ // Render Method[3]
      id: 'chartDiv',
      data: chartData,
      height: 400,
      width: 600
    });
  </script>
   
   </body>
</html>