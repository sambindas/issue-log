<?php

session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();


if (isset($_POST['submit_issue'])) {
    $facility = $_POST['facility'];
    $type = $_POST['type'];
    $il = $_POST['il'];
    $issue = $_POST['issue'];
    $icr = $_POST['icr'];
    $ad = $_POST['ad'];
    $so = $_SESSION['name'];
    $priority = $_POST['priority'];
    $date = date('d-m-Y');

        $insert = mysqli_query($conn, "INSERT INTO issue (facility, issue_type, issue_level, issue, issue_date, issue_client_reporter, affected_dept, support_officer, priority, status)
         VALUES ('$facility', '$type', '$il', '$issue', '$date', '$icr', '$ad', '$so', '$priority', 0)");

        $_SESSION['msg'] = '<span class="alert alert-success">Issue Submitted Successfully.</span>';

    }

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
                                <a class="dropdown-item" href="#">Log Out</a>
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
                                <h4 class="header-title">Issues Log</h4>
                                <div class="data-tables datatable-primary">
                                    <div id="my_table">
                                        <table id="dataTable2" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>Facility</th>
                                                    <th>Type</th>
                                                    <th>Issue</th>
                                                    <th>Priority</th>
                                                    <th>Date Submitted</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $il = mysqli_query($conn, "SELECT * from issue");
                                                while ($li_row = mysqli_fetch_array($il)) {   
                                                $status = $li_row['status'];                                         
                                                ?>
                                                <tr <?php
                                                    if ($status == 0) {
                                                        } elseif ($status == 1) {
                                                            echo 'style="background: #f49b42"';
                                                        }elseif ($status == 2) {
                                                            echo 'style="background: #d3dae5"';
                                                        }
                                                ?>>
                                                    <td><?php echo $li_row['facility'] ; ?></td>
                                                    <td><?php echo $li_row['issue_type'] ; ?></td>
                                                    <td><?php echo $li_row['issue'] ; ?></td>
                                                    <td><?php echo $li_row['priority'] ; ?></td>
                                                    <td><?php echo $li_row['issue_date'] ; ?></td>
                                                    <td>
                                                        <?php 
                                                        if ($status == 0) {
                                                            echo '<button id="'.$li_row["issue_id"].'" class=" btn-xs btn btn-success donebtn">Done</button><br>';
                                                            echo '<button id="'.$li_row["issue_id"].'" class="btn btn-xs btn-secondary naibtn">Not an Issue</button>';
                                                        } elseif ($status == 1) {
                                                            echo '<button id="'.$li_row["issue_id"].'" data-toggle="modal" data-target="#'.$li_row['issue_id'].'" class=" btn-xs btn btn-primary confirmedbtn">Confirmed</button><br>';
                                                            echo '<button id="'.$li_row["issue_id"].'" class=" btn-xs btn btn-secondary reobtn">Reopen</button><br>';
                                                        } elseif ($status == 2) {
                                                            echo '<button id="'.$li_row["issue_id"].'" class=" btn-xs btn btn-secondary reobtn">Reopen</button><br>';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            <!-- Large modal start -->
                                            <!-- Large modal -->
                                            <div id="<?php echo $li_row['issue_id']; ?>" class="modal fade bd-example-modal-lg">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Issue <?php echo $li_row['issue_id'] ; ?> Has Been Solved</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container">
                                                                <div class="">
                                                                    <form method="post" action="" name="issue_form" id="issue_form" enctype="multipart/form-data">
                                                                        <div class="login-form-body">
                                                                            <div class="row"> 
                                                                                <div class="col-sm-4">           
                                                                                    <div class="form-gp">
                                                                                        <h4 class="header-title mb-0">Resolution Comments</h4>
                                                                                        <p><?php echo $li_row['comments'] ; ?></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">           
                                                                                    <div class="form-gp">
                                                                                        <h4 class="header-title mb-0">Info Relayed To</h4>
                                                                                        <input type="text" name="irt" id="irt">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">           
                                                                                    <div class="form-gp">
                                                                                        <h4 class="header-title mb-0">Info Medium</h4>
                                                                                        <input type="text" name="im" id="im">
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
                                            <form method="post" action="" name="issue_form" id="issue_form" enctype="multipart/form-data">
                                                <div class="login-form-body">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Facility</h4>
                                                                <select name="facility" class="custome-select border-0 pr-3">
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
                                                                <select name = "type" class="custome-select border-0 pr-3">
                                                                    <option selected="">Select One</option>
                                                                    <option value="Issue">Issue</option>
                                                                    <option value="Request">Request</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-gp">
                                                                <h4  class="header-title mb-0">Issue Level</h4>
                                                                <select name="il" id="il" class="custome-select border-0 pr-3">
                                                                    <option selected="">Select One</option>
                                                                    <option value="1">Level One</option>
                                                                    <option value="2">Level Two</option>
                                                                    <option value="3">Level Three</option>
                                                                    <option value="4">Level Four</option>
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
                                                        <div class="col-sm-4">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Issue Client Reporter</h4>
                                                                <input type="text" name="icr" id="icr">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Affected Department(s)</h4>
                                                                <input type="text" name="ad" id="ad">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">           
                                                            <div class="form-gp">
                                                                <h4 class="header-title mb-0">Priority</h4>
                                                                <select name="priority" class="custome-select border-0 pr-3">
                                                                    <option selected="">Select One</option>
                                                                    <option value="High">High</option>
                                                                    <option value="Medium">Medium</option>
                                                                    <option value="Low">Low</option>
                                                                </select>
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
    <!-- offset area start -->
    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
            <li><a data-toggle="tab" href="#settings">Settings</a></li>
        </ul>
        <div class="offset-content tab-content">
            <div id="activity" class="tab-pane fade in show active">
                <div class="recent-activity">
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Added</h4>
                            <span class="time"><i class="ti-time"></i>7 Minutes Ago</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>You missed you Password!</h4>
                            <span class="time"><i class="ti-time"></i>09:20 Am</span>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Member waiting for you Attention</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <h4>You Added Kaji Patha few minutes ago</h4>
                            <span class="time"><i class="ti-time"></i>01 minutes ago</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Ratul Hamba sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Hello sir , where are you, i am egerly waiting for you.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                </div>
            </div>
            <div id="settings" class="tab-pane fade">
                <div class="offset-settings">
                    <h4>General Settings</h4>
                    <div class="settings-list">
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Notifications</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch1" />
                                    <label for="switch1">Toggle</label>
                                </div>
                            </div>
                            <p>Keep it 'On' When you want to get all the notification.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show recent activity</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch2" />
                                    <label for="switch2">Toggle</label>
                                </div>
                            </div>
                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show your emails</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch3" />
                                    <label for="switch3">Toggle</label>
                                </div>
                            </div>
                            <p>Show email so that easily find you.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show Task statistics</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch4" />
                                    <label for="switch4">Toggle</label>
                                </div>
                            </div>
                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Notifications</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch5" />
                                    <label for="switch5">Toggle</label>
                                </div>
                            </div>
                            <p>Use checkboxes when looking for yes or no answers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offset area end -->
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
            $('.donebtn').click(function(){
                $(this).attr('disabled', 'true');
                var issue_id = $(this).attr('id');
                var datastring = 'issue_id='+issue_id;

                $.ajax({
                    url: 'ajax/done.php',
                    method: 'post',
                    data: datastring,
                    success: function(msg){
                        $('.donebtn').removeAttr('disabled');
                        alert('Issue Marked As Done');
                    }
                });
            });

            $('.naibtn').click(function(){
                $(this).attr('disabled', 'true');
                var issue_id = $(this).attr('id');
                var datastring = 'issue_id='+issue_id;

                $.ajax({
                    url: 'ajax/nan.php',
                    method: 'post',
                    data: datastring,
                    success: function(msg){
                        $('.naibtn').removeAttr('disabled');
                        alert('Issue Marked As Not an Issue');
                    }
                });
            });

            $('.reobtn').click(function(){
                $(this).attr('disabled', 'true');
                var issue_id = $(this).attr('id');
                var datastring = 'issue_id='+issue_id;

                $.ajax({
                    url: 'ajax/reo.php',
                    method: 'post',
                    data: datastring,
                    success: function(msg){
                        $('.reobtn').removeAttr('disabled');
                        alert('Issue Reopened');
                    }
                });
            });
        });
    </script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>