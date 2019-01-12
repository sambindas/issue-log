<?php

session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$noww = date('M Y');

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>eClinic Issues Log</title>
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
            require 'sidebar.php';
            require 'header.php';
            ?>
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.html">Home</a></li>
                                <li><span>Issues Log</span></li>
                                <li><span></span></li>
                                <li><span></span></li>
                                <li><button id="newissue" class="btn btn-primary btn-flat" data-toggle="modal" data-target=".newissue">New Issue</button></li>
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
                                <a class="dropdown-item" href="#">Message</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- Primary table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Issues Log for <?php echo date('M Y'); ?></h4>
                                <button class="btn btn-primary btn-flat" id="filters">Filter</button><br><Br>
                                <form id="filterid" style="display: none;">
                                    <input type="text" id="datetimepicker1" placeholder="From" name="date1">
                                </form><br>
                                <div class="data-tables datatable-primary">
                                    <div id="my_table">
                                        <table id="dataTable2" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Facility</th>
                                                    <th>Type</th>
                                                    <th>Issue</th>
                                                    <th>Priority</th>
                                                    <th>Submitted By</th>
                                                    <th>Date Reported</th>
                                                    <th>Actions</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $il = mysqli_query($conn, "SELECT * from issue where month = '$noww'");
                                                $sn = 1;
                                                while ($li_row = mysqli_fetch_array($il)) {   
                                                $status = $li_row['status'];   
                                                $issue_id = $li_row['issue_id'];    
                                                $issue = $li_row['issue'];

                                                $date_one = $li_row['issue_date'];
                                                $date_two = $li_row['resolution_date']; 

                                                $date_onets = strtotime($date_one);
                                                $date_twots = strtotime($date_two);

                                                $final_date = $date_twots - $date_onets;
                              
                                                ?>
                                                <tr <?php
                                                    if ($status == 0) {
                                                        } elseif ($status == 1) {
                                                            echo 'style="background: #f49b42"';
                                                        }elseif ($status == 2) {
                                                            echo 'style="background: #7d998b"';
                                                        }elseif ($status == 3) {
                                                            echo 'style="background: #42f45f"';
                                                        }elseif ($status == 4) {
                                                            echo 'style="background: #f4e624"';
                                                        }elseif ($status == 5) {
                                                            echo 'style="background: #5394ed"';
                                                        }elseif ($status == 6) {
                                                            echo 'style="background: #42ebf4"';
                                                        }
                                                ?>>
                                                    <td><?php echo $sn++; ?></td>
                                                    <td><?php echo $li_row['facility'] ; ?></td>
                                                    <td><?php echo $li_row['issue_type'] ; ?></td>
                                                    <td style="text-align: justify;"><?php echo "$issue" ?></td>
                                                    <td><?php echo $li_row['priority'] ; ?></td>
                                                    <td><?php echo $li_row['support_officer'] ; ?></td>
                                                    <td><?php echo $li_row['issue_date'] ; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($status == 0) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a data-toggle="modal" data-target="#done'.$li_row['issue_id'].'" class="dropdown-item" href="#">Done</a>
                                                                            <a data-toggle="modal" data-target="#nai'.$li_row['issue_id'].'" class="dropdown-item" href="#">Not an Issue</a>
                                                                            <a data-toggle="modal" data-target="#noc'.$li_row['issue_id'].'" class="dropdown-item" href="#">Not Clear</a>
                                                                            <a data-toggle="modal" data-target="#req'.$li_row['issue_id'].'" class="dropdown-item" href="#">Requires Approval</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="image.php?issue_id='.$li_row['issue_id'].'">Upload Media</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="edit.php?issue_id='.$li_row['issue_id'].'">Edit Issue</a>                                                                        </div>
                                                                    </div>';
                                                        } elseif ($status == 1) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a data-toggle="modal" data-target="#con'.$li_row['issue_id'].'" class="dropdown-item" href="#">Confirmed</a>
                                                                            <a data-toggle="modal" data-target="#icm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Incomplete</a>
                                                                            <a data-toggle="modal" data-target="#reo'.$li_row['issue_id'].'" class="dropdown-item" href="#">Reopen</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="edit.php?issue_id='.$li_row['issue_id'].'">Edit Issue</a>
                                                                        </div>
                                                                    </div>';
                                                        } elseif ($status == 2) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a data-toggle="modal" data-target="#reo'.$li_row['issue_id'].'" class="dropdown-item" href="#">Reopen</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="edit.php?issue_id='.$li_row['issue_id'].'">Edit Issue</a>
                                                                        </div>
                                                                    </div>';
                                                        } elseif ($status == 3) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a data-toggle="modal" data-target="#sum'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Summary</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        </div>
                                                                    </div>';                                                            
                                                        } elseif ($status == 4) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a data-toggle="modal" data-target="#done'.$li_row['issue_id'].'" class="dropdown-item" href="#">Done</a>
                                                                            <a data-toggle="modal" data-target="#reo'.$li_row['issue_id'].'" class="dropdown-item" href="#">Reopen</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="edit.php?issue_id='.$li_row['issue_id'].'">Edit Issue</a>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                         elseif ($status == 5) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a data-toggle="modal" data-target="#done'.$li_row['issue_id'].'" class="dropdown-item" href="#">Done</a>
                                                                            <a data-toggle="modal" data-target="#reo'.$li_row['issue_id'].'" class="dropdown-item" href="#">Reopen</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="edit.php?issue_id='.$li_row['issue_id'].'">Edit Issue</a>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                         elseif ($status == 6) {
                                                            echo '  <div class="dropdown">
                                                                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a data-toggle="modal" data-target="#app'.$li_row['issue_id'].'" class="dropdown-item" href="#">Approved</a>
                                                                        <div class="dropdown-divider"></div>
                                                                            <a data-toggle="modal" data-target="#comm'.$li_row['issue_id'].'" class="dropdown-item" href="#">Add Comments</a>
                                                                            <a data-toggle="modal" data-target="#comments'.$li_row['issue_id'].'" class="dropdown-item" href="#">View Comments</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                        ?> 
                                                    </td>
                                                    <td></td>
                                                </tr>

                                            <!-- media start -->
                                            <div class="modal fade bd-example-modal-lg" id="media<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Upload Media</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Upload Media for this issue</p>
                                                            <form method='post' enctype='multipart/form-data' action='processing.php'>
                                                                <div class='file_upload' id='f1'><input name='media[]' type='file'/>1</div>
                                                                <div id='file_tools'>
                                                                    <img src='images/file_add.png' id='add_file' title='Add new input'/>
                                                                    <img src='images/file_del.png' id='del_file' title='Delete'/>
                                                                </div>
                                                                <input type='submit' name='submit_media' value='Upload'/>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                             <!-- requires approval start -->
                                            <div class="modal fade" id="req<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Requires Approval</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Additional Comments If Available</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="ncomments"></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_req">Mark</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                             <!-- incomplete start -->
                                            <div class="modal fade" id="icm<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Mark as Incomplete</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Additional Comments If Available</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="dcomments"></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_icm">Mark as Incomplete</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- view summary start -->
                                            <div class="modal fade bd-example-modal-lg" id="sum<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Summary of this Issue</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><b>Facility:</b> <?php echo $li_row['facility']; ?></p>
                                                            <p><b>Type:</b> <?php echo $li_row['issue_type']; ?></p>
                                                            <p><b>Level:</b> <?php echo $li_row['issue_level']; ?></p>
                                                            <p><b>priotity:</b> <?php echo $li_row['priority']; ?></p>
                                                            <p><b>Issue:</b> <?php echo $li_row['issue']; ?></p>
                                                            <p><b>Issue reported on:</b> <?php echo $li_row['issue_reported_on'] .' by '. $li_row['issue_client_reporter']; ?></p>
                                                            <p><b>Submitted by:</b> <?php echo $li_row['support_officer'] .' on '. $li_row['issue_date']; ?></p>
                                                            <p><b>Resolved by:</b> <?php echo $li_row['resolved_by'] .' on '. $li_row['resolution_date']; ?></p>
                                                            <p><b>Info Relayed to:</b> <?php echo $li_row['info_relayed_to'] .' by '. $li_row['info_medium']; ?></p>
                                                            <p><b>Issue was resolved in:</b> <?php echo secondsToTime($final_date); ?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- not clear start -->
                                            <div class="modal fade" id="noc<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Mark as Not Clear</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Additional Comments If Available</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="dcomments"></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_noc">Mark as Not Clear</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- not an issue modal start -->
                                            <div class="modal fade" id="nai<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add Additional Comments</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Additional Comments If Available</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="ncomments"></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_nai">Mark as Not an Issue</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- comments modal start -->
                                            <div class="modal fade" id="comm<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add Comments</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Comments to this Issue</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="comments" required></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_comm">Submit</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- comments modal start -->

                                            <div class="modal fade bd-example-modal-sm" id="comments<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">View Issue Comments</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                                $commentsq = mysqli_query($conn, "SELECT * from comments where issue_id = '$issue_id'");
                                                                if (mysqli_num_rows($commentsq) >= 1) {
                                                                while ($cq = mysqli_fetch_array($commentsq)) {
                                                                    $sstatus = $cq['status'];
                                                                    if ($sstatus == 0) {
                                                                        echo '<b>'.$cq['user'].' - (Reopened):</b> '.$cq['comment'].' <i> @ '.$cq['date_added'].'</i><br>'; 
                                                                    } elseif ($sstatus == 1) {
                                                                        echo '<b>'.$cq['user'].' - (Done):</b> '.$cq['comment'].' <i> @ '.$cq['date_added'].'</i><br>'; 
                                                                    } elseif ($sstatus == 2) {
                                                                        echo '<b>'.$cq['user'].' - (Not An Issue):</b> '.$cq['comment'].' <i> @ '.$cq['date_added'].'</i><br>'; 
                                                                    } elseif ($sstatus == 4) {
                                                                        echo '<b>'.$cq['user'].' - (Incomplete):</b> '.$cq['comment']. ' <i> @ '.$cq['date_added'].'</i><br>'; 
                                                                    } elseif ($sstatus == 5) {
                                                                        echo '<b>'.$cq['user'].' - (Not Clear):</b> '.$cq['comment'].' <i> @ '.$cq['date_added'].'</i><br>'; 
                                                                    } else {
                                                                        echo '<b>'.$cq['user'].' - :</b> '.$cq['comment'].' <i> @ '.$cq['date_added'].'</i><br>'; 
                                                                    }
                                                                }
                                                            }else {
                                                                echo "<p>No Comments For This Issue</p>";
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- done modal start -->
                                            <div class="modal fade" id="done<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add Additional Comments</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Additional Comments If Available</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="dcomments"></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_done">Mark as Done</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- done modal start -->
                                            <div class="modal fade" id="app<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Approve Issue</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Approve this issue?</p>
                                                            <form method="post" action="processing.php">
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_app">Approve</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- reopen modal start -->
                                            <div class="modal fade" id="reo<?php echo $li_row['issue_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add Additional Comments</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Add Additional Comments If Available</p>
                                                            <form method="post" action="processing.php">
                                                                <textarea type="text" name="rcomments"></textarea>
                                                                <input type="hidden" name="issue_id" value="<?php echo $li_row['issue_id']; ?>"><br>
                                                                <input type="hidden" name="url" value="<?php echo $url; ?>"><br>
                                                                <br><button type="submit" class="btn btn-primary" name="submit_reo">Mark as Reopened</button>
                                                            </form><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Small modal modal end -->

                                            <!-- Large modal start -->
                                            <div id="con<?php echo $li_row['issue_id']; ?>" class="modal fade bd-example-modal-lg">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Issue <?php echo $sn-1; ?> Has Been Solved</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container">
                                                                <div class="">
                                                                    <form method="post" action="processing.php" id="issue_form" enctype="multipart/form-data">
                                                                        <div class="login-form-body">
                                                                            <div class="row"> 
                                                                                <div class="col-sm-4">           
                                                                                    <div class="form-gp">
                                                                                        <h4 class="header-title mb-0">Resolved By</h4>
                                                                                        <p><?php echo $li_row['resolved_by'] .'<br>'. $li_row['resolution_date'] ; ?></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">           
                                                                                    <div class="form-gp">
                                                                                        <h4 class="header-title mb-0">Info Relayed To</h4>
                                                                                        <input type="text" name="irt" id="irt">
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="issue_id" value="<?php echo $issue_id; ?>">
                                                                                <input type="hidden" name="url" value="<?php echo $url; ?>">
                                                                                <div class="col-sm-4">           
                                                                                    <div class="form-gp">
                                                                                        <h4 class="header-title mb-0">Info Medium</h4>
                                                                                        <input type="text" name="im" id="im">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="Submit" name="confirmed" value="Confirmed" style="float: right;" class="btn btn-primary">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Large modal modal end -->
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Primary table end -->

                    <!-- Large modal start -->
                    <!-- Large modal -->
                    <div class="newissue modal fade bd-example-modal-lg">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Submit an Issue</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="">
                                            <form method="post" action="processing.php" name="issue_form" id="issue_form" enctype="multipart/form-data">
                                                <div class="login-form-body">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Facility</h4>
                                                                <select name="facility" class="custome-select border-0 pr-3" required>
                                                                    <option selected="">Select One</option>
                                                                    <?php
                                                                    $fc = mysqli_query($conn, "SELECT * from facility");
                                                                    while ($fc_row = mysqli_fetch_array($fc)) {
                                                                        echo '<option value="'.$fc_row['name'].'">'.$fc_row['name'].'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Type</h4>
                                                                <select name = "type" class="custome-select border-0 pr-3" required>
                                                                    <option selected="">Select One</option>
                                                                    <option value="Issue">Issue</option>
                                                                    <option value="Request">Request</option>
                                                                    <option value="Other">Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-gp">
                                                                <h4  class="header-title mb-0">Issue Level</h4>
                                                                <select name="il" id="il" class="custome-select border-0 pr-3" required>
                                                                    <option selected="">Select One</option>
                                                                    <option value="1">Level One (1 hr - 24 hrs)</option>
                                                                    <option value="2">Level Two (24 hrs - 1 wk)</option>
                                                                    <option value="3">Level Three (1 wk - 1mth)</option>
                                                                    <option value="4">Level Four (TBD)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="header-title mb-0">Issue</h4>
                                                    <textarea required cols="73" rows="6" type="text" id="issue" name="issue" placeholder="issue"></textarea>
                                                    <script>
                                                        CKEDITOR.replace( 'issue' );
                                                    </script><br>
                                                    <div class="row"> 
                                                        <div class="col-sm-3">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Issue Client Reporter</h4>
                                                                <input type="text" name="icr" id="icr" required>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="url" value="<?php echo $url; ?>">
                                                        <div class="col-sm-3">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Affected Department(s)</h4>
                                                                <input type="text" name="ad" id="ad" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Priority</h4>
                                                                <select name="priority" class="custome-select border-0 pr-3" required>
                                                                    <option selected="">Select One</option>
                                                                    <option value="High">High</option>
                                                                    <option value="Medium">Medium</option>
                                                                    <option value="Low">Low</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Issue Reported On</h4>
                                                                <input type="text" id="datetimepicker" name="iro">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="Submit" name="submit_issue" value="Submit Issue" style="float: right;" class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Large modal modal end -->
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2018. All right reserved.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            jQuery('#datetimepicker').datetimepicker();
            $('#filters').click(function(){
                    $('#filterid').toggle();
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
             timepicker:false,
             format:'d/m/Y'
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div><input type="file" name="media[]"><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
            var x = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){ 
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="jquery.datetimepicker.full.min.js"></script>
    <script src="jquery.datetimepicker.js"></script>

</html>