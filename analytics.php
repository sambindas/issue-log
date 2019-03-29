<?php
session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();

$sum_issue = 0;
$sum_res = 0;

$time_average = mysqli_query($conn, "SELECT issue_date, resolution_date from issue where status = '3'");
while ($time_avg = mysqli_fetch_array($time_average)) {
  $issue_d = $time_avg['issue_date'];
  $res  = $time_avg['resolution_date'];

  $sum_f = strtotime($issue_d);
  $sum_r = strtotime($res);

  $sum_issue += $sum_f;
  $sum_res += $sum_r;
}

$final = $sum_res  - $sum_issue;
$fnumber =  mysqli_num_rows($time_average);
$fd = $final / $fnumber;
$avg_resolve_time = secondsToTime($fd);

$result = mysqli_query($conn, "SELECT count(issue_id) as numberr, facility from issue group by facility");
$line = mysqli_query($conn, "SELECT count(issue_id) as numberrrr, month, issue_date from issue group by month");
$userq = mysqli_query($conn, "SELECT count(issue.issue_id) as numberrr, issue.support_officer, user.user_name from issue inner join user on issue.support_officer = user.user_id group by support_officer");

$mon = [];
$numberrrr = [];



$usern = [];
$user = [];
$uname = [];

$number = [];
$facility = [];

while ($roo = mysqli_fetch_array($line)) {
  $mon[] = $roo['month'];
  $numberrrr[] = $roo['numberrrr'];
}

while ($ro = mysqli_fetch_array($userq)) {
  $usern[] = $ro['numberrr'];
  $user[] = $ro['support_officer'];
  $uname[] = $ro['user_name'];
}

echo json_encode($usern);

while ($row = mysqli_fetch_array($result)) {
    $number[] = $row['numberr'];
    $facility[] = $row['facility'];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>CHarts</title>
</head>
<body id="mybody">
  <?php
            require 'sidebar.php';
            require 'header.php';
            ?>
    <div class="container">
      <div class="main-content-inner">
                <!-- bar chart start -->
                <div class="row">
                    <div class="col-lg-6 mt-5">
                        <div class="card">
                            <div class="card-body" style="float: left;">
                                <canvas id="bar-chart" width="600px" height="400px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-5">
                        <div class="card">
                            <div class="card-body" style="float: right;">
                                <canvas id="bar-chart2" width="600px" height="400px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-5">
                        <div class="card">
                            <div class="card-body" style="float: left;">
                                <canvas id="bar-chart3" width="600px" height="400px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-5">
                        <div class="card">
                            <div class="card-body" style="float: left;">
                                <canvas id="bar-chart3" width="600px" height="400px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bar chart end -->
            </div>
        </div>
    </div>
    <script>
    new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($facility); ?>,
      datasets: [
        {
          label: "Total Issues Submitted",
          backgroundColor: "#3e95cd",
          data:<?php echo json_encode($number); ?>
        }
      ]
    },
    options: {
      responsive: false,
      maintainAspectRatio: false,
      legend: { display: true },
      title: {
        display: true,
        text: 'Issues Log Data For All Facilities'
      }
    }
});
  </script>
  <script>
    new Chart(document.getElementById("bar-chart2"), {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($uname); ?>,
      datasets: [
        {
          label: "Total Issues Submitted",
          backgroundColor: ["#3e95cd", "grey", "green"],
          data:<?php echo json_encode($usern); ?>
        }
      ]
    },
    options: {
      responsive: false,
      maintainAspectRatio: false,
      legend: { display: true },
      title: {
        display: true,
        text: 'Issues Log Data For All Facilities'
      }
    }
});
  </script>
   <script>
    new Chart(document.getElementById("bar-chart3"), {
    type: 'line',
    data: {
      labels: <?php echo json_encode($mon); ?>,
      datasets: [
        {
          label: "Total Issues Submitted",
          backgroundColor: "#3e95cd",
          data:<?php echo json_encode($numberrrr); ?>
        }
      ]
    },
    options: {
      responsive: false,
      maintainAspectRatio: false,
      legend: { display: true },
      title: {
        display: true,
        text: 'Issues Log Data For All Facilities'
      }
    }
});
  </script>
   
   </body>
</html>