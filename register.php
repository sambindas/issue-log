<?

session_start();

require 'functions.php';

if (isset($_SESSION['email'])) {
header("Location: index.php");
    }

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sign up - Issue Log</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="javascript:;">
                    <div class="login-form-head">
                        <h4>Sign up</h4>
                        <p>Hello there, Sign up to use Issue Log</p><br>
                        <p id="formErr"></p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputName1">Full Name</label>
                            <input type="text" id="fullname" required>
                            <i class="ti-user"></i><br>
                            <div id="errfn"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="email" required>
                            <i class="ti-email"></i><br>
                            <div id="errem"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Phone Number</label>
                            <input type="text" id="phone" required>
                            <i class="ti-mobile"></i><br>
                            <div id="errpn"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" required>
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword2">Confirm Password</label>
                            <input type="password" id="password2" required>
                            <i class="ti-lock"></i><br>
                            <div id="perr"></div>
                        </div>
                        <div class="submit-btn-area">
                            <input class="btn btn-primary" id="form_submit" type="submit" value="Submit Information">

                            <div class="loaderxy">

                            </div>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="login.php">Sign in</a></p>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="successmodal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p class="alert alert-success">Sign Up Successful. Click to proceed</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="index.php" class="btn btn-primary">Proceed</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal End -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script type="text/javascript">
            $(document).ready(function(){
                
                $('#form_submit').click(function(){


                    var name = $('#fullname').val();
                    var email = $('#email').val();
                    var phone = $('#phone').val();
                    var password = $('#password').val();
                    var password2 = $('#password2').val();

                    console.log(password);

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


                        $('.loaderxy').html('<img src="assets/images/eclipse.gif" height="50px" width="50px">');


                        var datastring = 'name='+name+'&email='+email+'&phone='+phone+'&password='+password;

                        $.ajax({
                            url: 'ajax/register.php',
                            method: 'post',
                            data: datastring,
                            success: function(msg) {
                                if (msg == 1) {
                                    $('#successmodal').modal({backdrop: 'static', keyboard: false});
                                }else {
                                    $('#loaderxy').html('<span class="alert alert-danger">Something Went wrong. Please try again</span>');
                                }
                            }
                        });
                    }
                    });
                });
        
    </script>
</body>

</html>