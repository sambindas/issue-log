<?php
session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();
if ($_SESSION['logged_user'] == 'client') {
    header('Location: clientindex.php');
}
//if someone filters
if (isset($_GET['from']) and isset($_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
}

//time average

$sum_issue = 0;
$sum_res = 0;

$time_averag = "SELECT issue_date, resolution_date from issue where status = '3'";
if ($from != '' and $to != '') {
    $time_averag .= "and fissue_date between '$from' and '$to'";
}
$time_average = mysqli_query($conn, $time_averag);

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
//this function calculates the average time
$avg_resolve_time = secondsToTime($fd);

$resul = "SELECT count(issue_id) as numberr, facility from issue";
if ($from != '' and $to != '') {
    $resul .= " where fissue_date between '$from' and '$to' group by facility";
} else {
  $resul .= " group by facility";
}
$result = mysqli_query($conn, $resul);

$lin = "SELECT count(issue_id) as numberrrr, month, issue_id from issue";
if ($from != '' and $to != '') {
    $lin .= " where fissue_date between '$from' and '$to' group by month order by issue_id asc";
} else {
  $lin .= " group by month order by issue_id asc";
}

$line = mysqli_query($conn, $lin);

$userqq = "SELECT count(issue.issue_id) as numberrr, issue.support_officer, user.user_name from issue inner join user on issue.support_officer = user.user_id";
if ($from != '' and $to != '') {
    $userqq .= " where fissue_date between '$from' and '$to' group by support_officer";
} else {
  $userqq .= " group by support_officer";
}

$userq = mysqli_query($conn, $userqq);

$resulttt = "SELECT count(issue.issue_id) as numb, issue.facility, facility.name from issue inner join facility on issue.facility = facility.code";
if ($from != '' and $to != '') {
    $resulttt .= " where fissue_date between '$from' and '$to' group by facility order by numb asc";
} else {
  $resulttt .= " group by facility order by numb asc";
}
$resultt = mysqli_query($conn, $resulttt);

while ($numb = mysqli_fetch_array($resultt)) {
  $f = $numb['name'];
  $n = $numb['numb'];
}

$mon = [];
$numberrrr = [];

while ($roo = mysqli_fetch_array($line)) {
  $mon[] = $roo['month'];
  $numberrrr[] = $roo['numberrrr'];
}

$usern = [];
$user = [];
$uname = [];

while ($ro = mysqli_fetch_array($userq)) {
  $usern[] = $ro['numberrr'];
  $user[] = $ro['support_officer'];
  $uname[] = $ro['user_name'];
}

$number = [];
$facility = [];

while ($row = mysqli_fetch_array($result)) {
    $number[] = $row['numberr'];
    $facility[] = $row['facility'];
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Analytics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amcharts css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="jquery.datetimepicker.css">
<script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body id="mybody">
            <?php
            require 'header.php';
            ?>
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4><br><br>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Analytics</span></li>
                                <li><span></span></li>
                                <li><span></span></li>
                                <li>
                                <?php 
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                                ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['name']; ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="changepassword.php">Change Password</a>
                                <a class="dropdown-item" href="settings.php">Settings</a>
                                <a class="dropdown-item" href="help.php">Help</a>
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
              <form action="" method="get" id="filterid">

              <div class="form-group row">
                  <div class="col-sm-2">
                      <label for="ex1">Show Data From</label>
                      <?php
                      if ($from != '') {
                          echo '<input type="text" name="from" class="form-control" id="datetimepicker1" value="'.$from.'" readonly placeholder="From" name="from"><i class="ti-calender"></i>';
                      } else {
                          echo '<input type="text" name="from" class="form-control" id="datetimepicker1" value="'.date('Y-m-01').'" readonly placeholder="From" name="from"><i class="ti-calender"></i>';
                      }
                      ?>
                  </div>
                  <div class="col-sm-2">
                      <label for="ex1">To</label>
                      <?php
                      if ($to != '') {
                          echo '<input type="text" class="form-control" id="datetimepicker2" value="'.$to.'" readonly placeholder="To" name="to"><i class="ti-calender"></i>';
                      } else {
                          echo '<input type="text" class="form-control" id="datetimepicker2" value="'.date('Y-m-d').'" readonly placeholder="To" name="to"><i class="ti-calender"></i>';
                      }
                      ?>
                  </div> &nbsp;
                  <div class="col-sm-2">
                  <label>&nbsp;&nbsp;</label><br>
                      <input type="submit" id="filter" class="btn-flat btn btn-primary btn-xs" value="Filter">
                      <a type="button" href="charts.php" class="btn-flat btn btn-primary btn-xs">Clear Filter</a>
                  </div>
              </div>
              <hr>
            </form><br>
            <?php
              if ($to != '') {
                  echo 'SHOWING DATA FOR: <b>'.$from.' <b/>to <b>'.$to.'</b>';
              } else {
                  echo 'SHOWING ALL DATA';
              }
              ?>
            </div>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="float: left;">
                                <canvas id="bar-chart3" width="1000px" height="400px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="float: right;">
                              <!-- Hoverable Rows Table start -->
                              <div class="col-lg-6 mt-5">
                                <h4 class="header-title">Quick Data</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">Data</th>
                                                    <th scope="col">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Average Resolution Time</th>
                                                    <td><?php echo $avg_resolve_time; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Facility with Most Incidents</th>
                                                    <td><?php echo ''.$f.' ('.$n.')'; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                              <!-- Hoverable Rows Table end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bar chart end -->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script>
    new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($facility); ?>,
      datasets: [
        {
          label: "Total Incidents Submitted per Facility",
          backgroundColor: "#3e95cd",
          data:<?php echo json_encode($number); ?>
        }
      ]
    },
    options: {        scales: {
        yAxes: [{
            display: true,
            ticks: {
                suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                // OR //
                beginAtZero: true   // minimum value will be 0.
            }
        }]
    },

      responsive: false,
      maintainAspectRatio: false,
      legend: { display: true },
      title: {
        display: true,
        text: 'Incident Log Data For All Facilities'
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
          label: "Total Incidents Submitted per User",
          backgroundColor: ["#3e95cd", "#7D998B", "#0bfd84", "#fdb60b", "#dd988c", "#dc8cdd", "#af8cdd", "#535469", "#d28e9c", "#d22411", "#adb6a9"],
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
        text: 'Incident Log Submitted per User'
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
          label: "Total Incidents Submitted per Month",
          backgroundColor: "#7DC8f8",
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
        text: 'Incident Log Data For All Facilities Per Month'
      }
    }
});
  </script>
  <script src="jquery.datetimepicker.full.min.js"></script>
    <script src="jquery.datetimepicker.js"></script>
    <script type="text/javascript">
       $(document).ready(function(){
            jQuery('#datetimepicker2').datetimepicker({
                format: 'Y-m-d',
                timepicker:false,
                maxDate: '0d',
            });

            jQuery('#datetimepicker1').datetimepicker({
             i18n:{
              de:{
               months:[
                'January','February','March','April',
                'May','June','July','August',
                'September','October','November','December',
               ],
               dayOfWeek:[
                "Su.", "Mo", "Tu", "We", 
                "Th", "Fr", "Sa.",
               ]
              }
             },
             format:'Y-m-d',
             timepicker:false,
             maxDate: '0d',
            });
        });
    </script>
</body>

</html>
