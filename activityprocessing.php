<?php
session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();
if ($_SESSION['logged_user'] == 'client') {
    header('Location: clientindex.php');
}

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", strtotime($date)));
    //Apply above formula.
    return intval(date("W", strtotime($date))) - intval(date("W", $firstOfMonth)) + 1;
}

if (isset($_POST['submit_activity'])) {
	$facility = $_POST['facility'];
    $activity = $_POST['activity'];
    $activity_date = $_POST['activity_date'];
    $visit_type = $_POST['visit_type'];
    $status = $_POST['status'];
    $comments = $_POST['comments'];
    $pstatus = $_POST['pstatus'];
    $date = date('d-m-Y H:i:s');
    $url = "activity.php";
    $week = weekOfMonth($activity_date);
    $day = date('l', strtotime($activity_date));
    $month = date('F', strtotime($activity_date));
    $year = date('Y', strtotime($activity_date));
    $user_id = $_SESSION['id'];
<<<<<<< HEAD
=======
    print_r(date('Y/m/d'));
    print_r($activity_date);
    die();
>>>>>>> 73a4bdf69e114010c4c50e3741d290b8533fd234

        $insert = mysqli_query($conn, "INSERT INTO activity (facility, activity, user_id, status, pstatus, activity_date, week, month, year, date_submitted, day, visit_type, comments)
         VALUES ('$facility', '$activity', '$user_id', '$status', '$pstatus', '$activity_date', '$week', '$month', '$year', '$date', '$day', '$visit_type', '$comments')");
        
        if ($insert) {
            $_SESSION['msg'] = '<span class="alert alert-success">Activity Submitted Successfully.</span>';
            header("Location: activity.php ");
        } else {
            $_SESSION['msg'] = '<span class="alert alert-danger">Activity Not Submitted. An Error Occured.</span>';
            header("Location: activity.php ");
        exit();
        }

    }
 
if (isset($_POST['submit_activity2'])) {
    $facility = $_POST['facility'];
    $activity = $_POST['activity'];
    $activity_date = $_POST['activity_date'];
    $visit_type = $_POST['visit_type'];
    $status = $_POST['status'];
    $comments = $_POST['comments'];
    $pstatus = $_POST['pstatus'];
    $date = date('d-m-Y H:i:s');
    $url = "activity.php";
    $week = weekOfMonth($activity_date);
    $day = date('l', strtotime($activity_date));
    $month = date('F', strtotime($activity_date));
    $year = date('Y', strtotime($activity_date));
    $user_id = $_SESSION['id'];

        $insert = mysqli_query($conn, "INSERT INTO activity (facility, activity, user_id, status, pstatus, activity_date, week, month, year, date_submitted, day, visit_type, comments)
         VALUES ('$facility', '$activity', '$user_id', '$status', '$pstatus', '$activity_date', '$week', '$month', '$year', '$date', '$day', '$visit_type', '$comments')");

        if ($insert) {
            $_SESSION['msg'] = '<span class="alert alert-success">Activity Submitted Successfully.</span>';
            header("Location: newactivity.php ");
        } else {
            $_SESSION['msg'] = '<span class="alert alert-danger">Activity Not Submitted. An Error Occured.</span>';
            header("Location: newactivity.php ");
        exit();
        }

    }

    if (isset($_POST['submit_summary'])) {
    $planned = $_POST['planned'];
    $unplanned = $_POST['unplanned'];
    $issues = $_POST['issues'];
    $unresolved = $_POST['unresolved'];
    $week = $_POST['week'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $user_id = $_SESSION['id'];

        $insert = mysqli_query($conn, "UPDATE activity set unplanned = '$unplanned', unresolved = '$unresolved', issues = '$issues', planned = '$planned'
                                        where year = '$year' and month = '$month' and week = '$week' and user_id = '$user_id'");
        
        
        if ($insert) {
            $_SESSION['msg'] = '<span class="alert alert-success">Activity Summary Submitted Successfully.</span>';
            header("Location: activity.php ");
        } else {
            $_SESSION['msg'] = '<span class="alert alert-danger">Activity Summary Not Submitted. An Error Occured.</span>';
            header("Location: addsummary.php ");
        exit();
        }

    }
?>