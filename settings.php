<?php

session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$email = $_SESSION['email'];

$user = mysqli_query($conn, "SELECT * from user where email = '$email'");

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Profile</title>
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
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-2 mt-5">
                    </div>
                    <div class="col-8 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Manage Your Profile</h4>

                                    <div class="login-area">
                                        <div class="container">
                                                <form action="javascript:;">
                                                    <div class="login-form-body">
                                                        <?php
                                                        while ($user_row = mysqli_fetch_array($user)) {
                                                            $id = $user_row['user_id'];
                                                            $name = $user_row['user_name'];
                                                            $email = $user_row['email'];
                                                            $phone = $user_row['phone'];
                                                            $role = $user_row['user_role'];
                                                        }
                                                        ?>
                                                        <div class="form-gp">
                                                            <input type="text" id="fullname" value="<?php echo $name; ?>" required>
                                                            <i class="ti-user"></i><br>
                                                            <div id="errfn"></div>
                                                        </div>
                                                        <div class="form-gp">
                                                            <input type="email" id="email" value="<?php echo $email; ?>" required>
                                                            <i class="ti-email"></i><br>
                                                            <div id="errem"></div>
                                                        </div>
                                                        <div class="form-gp">
                                                            <input type="text" id="phone" value="<?php echo $phone; ?>" required>
                                                            <i class="ti-mobile"></i><br>
                                                            <div id="errpn"></div>
                                                        </div>
                                                        <div class="form-gp">
                                                            <label for="exampleInputEmail1">Role</label><br>
                                                            <select class="custome-select border-0 pr-3" name="role" id="user_role" required>
                                                                <option value=""> Select One</option>
                                                                <option <?php if ($role == 'Developer') { echo 'selected'; } ?> value="Developer">Developer</option>
                                                                <option <?php if ($role == 'Support Officer') { echo 'selected'; } ?> value="Support Officer">Support Officer</option>
                                                            </select>
                                                            <i class="ti-user"></i><br>
                                                            <div id="errpn"></div>
                                                        </div>
                                                        <div class="submit-btn-area">
                                                            <input class="btn btn-primary" id="form_submit" type="submit" value="Update Information">
                                                        </div>
                                                    </div>
                                                </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 mt-5">
                    </div>
                    <!-- Primary table end -->

                    <!-- Large modal start -->
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
    <script type="text/javascript">
            $(document).ready(function(){
                
                $('#form_submit').click(function(){
                    console.log(876);

                    var name = $('#fullname').val();
                    var email = $('#email').val();
                    var phone = $('#phone').val();
                    var password = $('#password').val();
                    var password2 = $('#password2').val();
                    var role = $('#user_role').val();

                    if (name == '' || email == '' || phone == '' || password == '' || password2 == '') {
                        $('#formErr').html('<span class="alert alert-danger">Please Fill In All Fields</span>');
                        return false;
                    }
                    else if (name != '' || email != '' || phone != '' || password != '' || password2 != '') {
                        $('#formErr').html('');

                        var datastring = 'email='+email;

                        $.ajax({
                            url: 'ajax/email.php',
                            method: 'post',
                            data: datastring,
                            success: function(msg) {
                                if (msg == 1) {
                                    $('#errem').html('<div class="alert alert-danger"><p>Another User Exists With That Email</p></div>');

                                    return false;

                                } else {
                                    $('#errem').html('');
                                    registerFinal();
                                }
                            }
                        });


                        if (password != password2) {
                            $('#form_submit').attr('disabled', 'true');
                            $('#perr').html('<div class="alert alert-danger"><p>Passwords Do Not Match</p></div>');
                            $('#form_submit').removeAttr('disabled');
                            return false;
                        } else {
                            $('#perr').html('');
                        }


                        var datastring = 'name='+name+'&email='+email+'&phone='+phone+'&password='+password+'&role='+role;

                        function registerFinal() {

                        $.ajax({
                            url: 'ajax/register.php',
                            method: 'post',
                            data: datastring,
                            success: function(msg) {
                                if (msg == 1) {
                                    window.location.replace('user.php');
                                }else {
                                    $('#loaderxy').html('<span class="alert alert-danger">Something Went wrong. Please try again</span>');
                                }
                            }
                        });
                    }
                    }
                    });
                });
        
    </script>

</html>