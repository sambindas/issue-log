<?php

session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$noww = date('M Y');

$issue_id = $_GET['issue_id'];

$editq = mysqli_query($conn, "SELECT * from issue where issue_id = '$issue_id'");

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
            ?><br>
                    <div class="container">
                        <p><span class="alert alert-warning"><b>Note:</b> Image must not be more than 1mb&nbsp;&nbsp;<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Only <b>Jpg,</b> <b>Jpeg,</b><b>Png</b> and <b>Gif</b> are allowed</span></p>
                                <?php 
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                                ?><br><br>
                        <form method='post' enctype='multipart/form-data' action='processing.php'>
                            <div class='file_upload' id='f1'><input name='media' type='file' required /></div><br>
                            <textarea type="text" name="caption" placeholder="Insert Caption" required></textarea>
                            <!-- <div id='file_tools'>
                                <img src='assets/images/file_add.png' height="10" width="20" id='add_file' title='Add new input'/>
                                <img src='assets/images/file_del.png' height="10" width="20" id='del_file' title='Delete'/>
                            </div><br> -->
                            <br><br>
                            <input type="hidden" name="issue_id" value="<?php echo $issue_id; ?>">
                            <input type="hidden" name="url" value="<?php echo $url; ?>">
                            <input type='submit' class="btn btn-primary" name='submit_media' value='Upload'/>
                            <input type='submit' class="btn btn-success" name='submit_media2' value='Upload And Add New'/>
                        </form>
                    </div>
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
    <script type='text/javascript'>
    $(document).ready(function(){
        var counter = 2;
        $('#del_file').hide();
        $('img#add_file').click(function(){
            $('#file_tools').before('<div class="file_upload" id="f'+counter+'"><input name="media[]" type="file">'+counter+' <br> <input type="text" id="del_inp" name="caption[]" placeholder="input caption"></div>');
            $('#del_file').fadeIn(0);
        counter++;
        });
        $('img#del_file').click(function(){
            if(counter==3){
                $('#del_file').hide();
            }   
            counter--;
            $('#f'+counter).remove();
        });
    });
    </script>

</html>