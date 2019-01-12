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
    $iro = $_POST['iro'];
    $irod = date('d-m-Y @ H:i:s', strtotime($iro));
    $ad = $_POST['ad'];
    $so = $_SESSION['name'];
    $priority = $_POST['priority'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];
    $month = date('M Y');

        $insert = mysqli_query($conn, "INSERT INTO issue (facility, issue_type, issue_level, issue, issue_date, issue_client_reporter, affected_dept, support_officer, priority, status, month, issue_reported_on)
         VALUES ('$facility', '$type', '$il', '$issue', '$date', '$icr', '$ad', '$so', '$priority', 0, '$month', '$irod')");

        $_SESSION['msg'] = '<span class="alert alert-success">Issue Submitted Successfully.</span>';
        header("Location: $url ");

    }

if (isset($_POST['edit_issue'])) {
    $facility = $_POST['facility'];
    $type = $_POST['type'];
    $il = $_POST['il'];
    $issue = $_POST['issue'];
    $issue_id = $_POST['issue_id'];
    $icr = $_POST['icr'];
    $iro = $_POST['iro'];
    $irod = date('d-m-Y @ H:i:s', strtotime($iro));
    $ad = $_POST['ad'];
    $so = $_SESSION['name'];
    $priority = $_POST['priority'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

        $insert = mysqli_query($conn, "UPDATE issue set facility = '$facility', issue_type = '$type', issue_level = '$il', issue = '$issue', issue_date = '$date',
         issue_client_reporter = '$icr', affected_dept = '$ad', support_officer = '$so', priority = '$priority', issue_reported_on = '$irod' where issue_id = '$issue_id'");
        
        if ($insert) {
        

        $_SESSION['msg'] = '<span class="alert alert-success">Issue Edited Successfully.</span>';
        header("Location: index.php ");
}
    }

if (isset($_POST['submit_media'])) {
    if (isset($_FILES['media'])) {
        $my_array = $_POST['caption'];
        foreach ($my_array as $key => $value) {
            echo "$key = $value";
        }
    }
    }

if (isset($_POST['submit_done'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['dcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 1, resolution_date = '$date', resolved_by = '$so' where issue_id = '$issue_id'");

    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 1) ");
    $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
} else {
    $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");

}
}

if (isset($_POST['submit_app'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 0 where issue_id = '$issue_id'");

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Approved Successfully.</span>';
    header("Location: $url ");

}


if (isset($_POST['confirmed'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $date = date('d-m-Y');
    $url = $_POST['url'];
    $irt = mysqli_real_escape_string($conn, $_POST['irt']);
    $im = mysqli_real_escape_string($conn, $_POST['im']);

    $query = mysqli_query($conn, "UPDATE issue set status = 3, info_relayed_to = '$irt', info_medium = '$im' where issue_id = '$issue_id'");
    

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Confirmed Successfully.</span>';
    header("Location: $url ");

}

if (isset($_POST['submit_icm'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['ncomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 4 where issue_id = '$issue_id'");

    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 4) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_nai'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['ncomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 2 where issue_id = '$issue_id'");

    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 2) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_comm'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 20) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Comments Added Successfully.</span>';
    header("Location: $url ");
}

if (isset($_POST['submit_noc'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['ncomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 5 where issue_id = '$issue_id'");

    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 5) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_req'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['ncomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 6 where issue_id = '$issue_id'");

    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 6) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Issue Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_reo'])) {

    $so = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['rcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 0 where issue_id = '$issue_id'");

    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 0) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Issue Reopened Successfully.</span>';
    header("Location: $url ");
} else {
    $_SESSION['msg'] = '<span class="alert alert-success">Issue Reopened Successfully.</span>';
    header("Location: $url ");
}
}
?>