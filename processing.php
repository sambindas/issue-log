<?php
session_start();
require 'connection.php';
require 'functions.php';
checkUserSession();
if ($_SESSION['logged_user'] == 'client') {
    header('Location: clientindex.php');
}

if (isset($_POST['submit_issue'])) {
    $facility = $_POST['facility'];
    $type = $_POST['type'];
    $il = $_POST['il'];
    $issue = $_POST['issue'];
    $icr = $_POST['icr'];
    $iro = $_POST['iro'];
    $irod = date('d-m-Y @ H:i:s', strtotime($iro));
    $ad = $_POST['ad'];
    $so = $_SESSION['id'];
    $priority = $_POST['priority'];
    $date = date('d-m-Y H:i:s');
    $fdate = date('Y-m-d');
    $url = "index.php";
    $month = date('M Y');
    $son = $_SESSION['name'];
    $user = $_POST['assign'];
    $post_type = $_POST['post_type'];
    $state_id = $_SESSION['state_id'];

        $insert = mysqli_query($conn, "INSERT INTO issue (state_id, facility, issue_type, issue_level, issue, issue_date, fissue_date, issue_client_reporter, affected_dept, support_officer, priority, status, month, issue_reported_on, user, type)
         VALUES ('$state_id', '$facility', '$type', '$il', '$issue', '$date', '$fdate', '$icr', '$ad', '$so', '$priority', 0, '$month', '$irod', '$user', '$post_type')");
        $last_id = mysqli_insert_id($conn);
        
        if ($insert) {
            $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$last_id', '$so', '$date', 'Incident was submitted')");
        } else {
            $_SESSION['msg'] = '<span class="alert alert-danger">Incident Not Submitted. An Error Occured.</span>';
            header("Location: index.php ");
        exit();
        }
        if ($user != "") {
            mysqli_query($conn, "UPDATE issue set status = 8 where issue_id = '$last_id'");
                $u = mysqli_query($conn, "SELECT * from user where user_name = '$user'");
                while ($rr = mysqli_fetch_array($u)) {
                    $email = $rr['email'];
                }
                $rrr = strtok($user, " ");
                $msg = '<span class="alert alert-success">Incident Submitted Successfully and mail sent to <span style="text-transform: lowercase;">'.$email.'.</span></span>';

                $subject = 'An Incident Has Been Assigned To You';
                $message = 'Hello '.$rrr.' <br> Incident Log S/N '.$last_id.' has been assigned to you by '.$son.'. 
                <br>
                <blockquote><b>Facility</b>: '.$facility.'<br><b>Details</b>: '.$issue.'</blockquote>
                <br>
                Please <a href="incident-log.eclathealthcare.com">Log In</a> and Check. <br> Best Regards.';
                sendMail($email, $rrr, $subject, $message, $msg, $url);
        }

        $_SESSION['msg'] = '<span class="alert alert-success">Incident Submitted Successfully.</span>';
        header("Location: index.php ");

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
    $so = $_SESSION['id'];
    $priority = $_POST['priority'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];
    $action = "Incident was Edited";

        $insert = mysqli_query($conn, "UPDATE issue set facility = '$facility', issue_type = '$type', issue_level = '$il', issue = '$issue', issue_date = '$date',
         issue_client_reporter = '$icr', affected_dept = '$ad', support_officer = '$so', priority = '$priority', issue_reported_on = '$irod' where issue_id = '$issue_id'");
        if ($insert) {
            $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', '$action')");
        }
        if ($log) {

        $_SESSION['msg'] = '<span class="alert alert-success">Incident Edited Successfully.</span>';
        header("Location: index.php ");
}
    }

if (isset($_POST['submit_re'])) {
    $issue_id = $_POST['issue_id'];
    $reassign = $_POST['reassign'];
    $url = $_POST['url'];
    $n = $_SESSION['name'];
    $date = date('d-m-Y H:i:s');
    $so = $_SESSION['id'];
    $son = $_SESSION['name'];
    $u = mysqli_query($conn, "SELECT * from user where user_name = '$reassign'");
    while ($rr = mysqli_fetch_array($u)) {
        $email = $rr['email'];
    }
        $insert = mysqli_query($conn, "UPDATE issue set user = '$reassign', status = 8 where issue_id = '$issue_id'");

        if ($insert) {
            $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was re-assigned to $reassign')");
        }
        
        if ($log) {
        if (isset($_POST['smail'])) {
            $rrr = strtok($reassign, " ");
                $msg = '<span class="alert alert-success">Incident Re-assigned Successfully and mail sent to <span style="text-transform: lowercase;">'.$email.'</span>.</span>';
                $subject = 'An Incident Has Been Re-assigned To You';
                $message = 'Hello '.$rrr.' <br> Incident Log S/N '.$issue_id.' has been re-assigned to you by '.$son.'. Please <a href="incident-log.eclathealthcare.com">Log In</a> and Check. <br> Best Regards.';
                
                sendMail($email, $rrr, $subject, $message, $msg, $url);

            } 
        $_SESSION['msg'] = '<span class="alert alert-success">Incident Reassigned Successfully.</span>';
        header("Location: index.php ");
        }

}
    

if (isset($_POST['submit_media'])) {
    if (isset($_FILES['media'])) {

        $prefix = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 7);
        $dir = 'media/';
        $url = "index.php";
        $issue_id = $_POST['issue_id'];
        $son = $_SESSION['name'];
        $so = $_SESSION['id'];
        $date = date('d-m-Y H:i:s');

        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $fileName = $prefix.$_FILES['media']['name'];
        $file_size = $_FILES['media']['size'];
        $file_tmp = $_FILES['media']['tmp_name'];
        $file_type= $_FILES['media']['type'];
        $filePath = $dir.$fileName;

        if ($file_size > 1000000) {
            $_SESSION['msg'] = '<span class="alert alert-danger">File Size Must Be Lower Than 1mb</span>';
            header("Location: $url");
            return false;
        }

        if ($file_type != 'image/png' && $file_type != 'image/jpg' && $file_type != 'image/jpeg' && $file_type != 'image/gif') {
            $_SESSION['msg'] = '<span class="alert alert-danger">File Must Be Either Jpg, Png or Gif</span>';
            header("Location: $url");
            return false;
        }

        if (move_uploaded_file($file_tmp, $filePath)) {

        $query_image = "INSERT INTO media (media_name, issue_id, user, caption, date_added) VALUES ('$fileName','$issue_id','$so', '$caption', '$date')";
        
        if(mysqli_query($conn, $query_image)){
            $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Media was submitted')");
            $sss = mysqli_query($conn, "SELECT * from issue where issue_id = '$issue_id'");
            while ($rrrr = mysqli_fetch_array($sss)) {
                $us = $rrrr['user'];
                $us2 = $rrrr['support_officer'];
            }
            // fetch asignee details
            $u = mysqli_query($conn, "SELECT * from user where user_name = '$us'");
            while ($rr = mysqli_fetch_array($u)) {
                $email = $rr['email'];
                $name = $rr['user_name'];
            }
            // fetch creator details
            $u2 = mysqli_query($conn, "SELECT * from user where user_id = '$us2'");
            while ($rr2 = mysqli_fetch_array($u2)) {
                $email2 = $rr2['email'];
                $name2 = $rr2['user_name'];
            }
            $rrr = strtok($name, " ");
                $msg = '<span class="alert alert-success">Media Uploaded Successfully and mail sent to <span style="text-transform: lowercase;">'.$email.' and '.$email2.'.</span></span>';
                $subject = 'New Media Uploaded';
                $message = 'Hello All, <br> A Media has just been uploaded to Incident S/N '.$issue_id.' by '.$son.'. Please <a href="incident-log.eclathealthcare.com">Log In</a> and Check.<br> Best Regards.';
                
                sendMail2($email, $rrr, $subject, $message, $msg, $url, $email2);
        }      
    }

    }
}

if (isset($_POST['submit_done'])) {

    $so = $_SESSION['id'];
    $son = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['dcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 1, resolution_date = '$date', resolved_by = '$so' where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was marked as done')");
    }
    $sss = mysqli_query($conn, "SELECT * from issue where issue_id = '$issue_id'");
    while ($rrrr = mysqli_fetch_array($sss)) {
        $us2 = $rrrr['support_officer'];
    }
    // fetch creator details
    $u2 = mysqli_query($conn, "SELECT * from user where user_id = '$us2'");
    while ($rr2 = mysqli_fetch_array($u2)) {
        $email = $rr2['email'];
        $name = $rr2['user_name'];
    }
    $rrr = strtok($name, " ");
        $msg = '<span class="alert alert-success">Incident Marked Successfully.</span>';
        $subject = 'Incident Marked As Done';
        $message = 'Hello '.$rrr.' <br> Incident Log S/N '.$issue_id.' which you submitted, has been has been marked as DONE by '.$son.'. Please <a href="incident-log.eclathealthcare.com">Log In</a> and Check. <br> Best Regards.';
        
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 1) ");
    sendMail($email, $rrr, $subject, $message, $msg, $url);
    } else {
    sendMail($email, $rrr, $subject, $message, $msg, $url);

}
}

if (isset($_POST['submit_app'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];
    $comments = $_POST['comments'];


    $query = mysqli_query($conn, "UPDATE issue set status = 0 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was approved.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 8) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}

}

if (isset($_POST['submit_dapp'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];
    $comments = $_POST['comments'];


    $query = mysqli_query($conn, "UPDATE issue set status = 7 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was not approved.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 7) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}

}

if (isset($_POST['submit_edt'])) {

    $so = $_SESSION['name'];
    $id = $_POST['id'];
    $date = date('d-m-Y H:i:s');
    $url = "facility.php";
    $name = $_POST['fname'];
    $code = $_POST['fcode'];
    $cpersonp = $_POST['cpersonp'];
    $cperson = $_POST['cperson'];
    $serverip = $_POST['server_ip'];
    $online_url = $_POST['online_url'];
    $email = $_POST['email'];

    $query = mysqli_query($conn, "UPDATE facility set name = '$name', code = '$code', contact_person = '$cperson', contact_person_phone = '$cpersonp', email = '$email', server_ip = '$serverip', online_url = '$online_url' where id = '$id'");
    
    $_SESSION['msg'] = '<span class="alert alert-success">Facility Edited Successfully.</span>';
    header("Location: $url ");

}

if (isset($_POST['confirmed'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];
    $irt = mysqli_real_escape_string($conn, $_POST['irt']);
    $im = mysqli_real_escape_string($conn, $_POST['im']);

    $query = mysqli_query($conn, "UPDATE issue set status = 3, info_relayed_to = '$irt', info_medium = '$im' where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was confirmed as solved.')");
    }

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Confirmed Successfully.</span>';
    header("Location: $url ");

}

if (isset($_POST['submit_iip'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['dcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 9 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was marked as Incomplete Information Provided.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 9) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_icm'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['dcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 4 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was marked as incomplete.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 4) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_nai'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['ncomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 2 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was marked as not an issue.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 2) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_comm'])) {

    $so = $_SESSION['id'];
    $son = $_SESSION['name'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
    $comments2 = $_POST['comments'];
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 20) ");
    if($query2){
            $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Comments Were Added')");
            $sss = mysqli_query($conn, "SELECT * from issue where issue_id = '$issue_id'");
            while ($rrrr = mysqli_fetch_array($sss)) {
                $us = $rrrr['user'];
                $us2 = $rrrr['support_officer'];
            }
            // fetch asignee details
            $u = mysqli_query($conn, "SELECT * from user where user_name = '$us'");
            while ($rr = mysqli_fetch_array($u)) {
                $email = $rr['email'];
                $name = $rr['user_name'];
            }
            // fetch creator details
            $u2 = mysqli_query($conn, "SELECT * from user where user_id = '$us2'");
            while ($rr2 = mysqli_fetch_array($u2)) {
                $email2 = $rr2['email'];
                $name2 = $rr2['user_name'];
            }
            $rrr = strtok($name, " ");
                
                $subject = 'New Comments Available';
                $message = 'Hello, <br> A Comment has just been added to Incident S/N '.$issue_id.' by '.$son.'. 
                <blockquote>'.nl2br($comments2).'</blockquote>
                Please <a href="incident-log.eclathealthcare.com">Log In</a> and Check.<br> Best Regards.';
                if ($email == $_SESSION['email']) {
                    $msg = '<span class="alert alert-success">Comments Added and mail sent to <span style="text-transform: lowercase;">'.$email2.'.</span></span>';
                    sendMail($email2, $rrr, $subject, $message, $msg, $url);
                }else {
                    $msg = '<span class="alert alert-success">Comments Added and mail sent to <span style="text-transform: lowercase;">'.$email.' and '.$email2.'.</span></span>';
                    sendMail2($email, $rrr, $subject, $message, $msg, $url, $email2);
                }
        }
}

if (isset($_POST['submit_noc'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['dcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 5 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was marked as not clear.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 5) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_req'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['ncomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 6 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was marked for approval.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 6) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
} else {
     $_SESSION['msg'] = '<span class="alert alert-success">Incident Marked Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_reo'])) {

    $so = $_SESSION['id'];
    $issue_id = $_POST['issue_id'];
    $comments = mysqli_real_escape_string($conn, $_POST['rcomments']);
    $date = date('d-m-Y H:i:s');
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE issue set status = 8 where issue_id = '$issue_id'");
    if ($query) {
        $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Incident was reopened.')");
    }
    if ($comments != "") {

    $query2 = mysqli_query($conn, "INSERT into comments (issue_id, comment, user, date_added, status) values ('$issue_id', '$comments', '$so', '$date', 0) ");

    $_SESSION['msg'] = '<span class="alert alert-success">Incident Reopened Successfully.</span>';
    header("Location: $url ");
} else {
    $_SESSION['msg'] = '<span class="alert alert-success">Incident Reopened Successfully.</span>';
    header("Location: $url ");
}
}

if (isset($_POST['submit_media2'])) {
    if (isset($_FILES['media'])) {

        $prefix = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 7);
        $dir = 'media/';
        $url = $_POST['url'];
        $issue_id = $_POST['issue_id'];
        $so = $_SESSION['id'];
        $son = $_SESSION['name'];
        $date = date('d-m-Y H:i:s');

        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $fileName = $prefix.$_FILES['media']['name'];
        $file_size = $_FILES['media']['size'];
        $file_tmp = $_FILES['media']['tmp_name'];
        $file_type= $_FILES['media']['type'];
        $filePath = $dir.$fileName;

        if ($file_size > 1000000) {
            $_SESSION['msg'] = '<span class="alert alert-danger">File Size Must Be Lower Than 1mb</span>';
            header("Location: $url");
            return false;
        }

        if ($file_type != 'image/png' && $file_type != 'image/jpg' && $file_type != 'image/jpeg' && $file_type != 'image/gif') {
            $_SESSION['msg'] = '<span class="alert alert-danger">File Must Be Either Jpg, Png or Gif</span>';
            header("Location: $url");
            return false;
        }

        if (move_uploaded_file($file_tmp, $filePath)) {

        $query_image = "INSERT INTO media (media_name, issue_id, user, caption, date_added) VALUES ('$fileName','$issue_id','$so', '$caption', '$date')";
        
        if(mysqli_query($conn, $query_image)){
            $log = mysqli_query($conn, "INSERT into movement (issue_id, done_by, done_at, movement) values ('$issue_id', '$so', '$date', 'Media was submitted')");
            $sss = mysqli_query($conn, "SELECT * from issue where issue_id = '$issue_id'");
            while ($rrrr = mysqli_fetch_array($sss)) {
                $us = $rrrr['user'];
                $us2 = $rrrr['support_officer'];
            }
            // fetch asignee details
            $u = mysqli_query($conn, "SELECT * from user where user_name = '$us'");
            while ($rr = mysqli_fetch_array($u)) {
                $email = $rr['email'];
                $name = $rr['user_name'];
            }
            // fetch creator details
            $u2 = mysqli_query($conn, "SELECT * from user where user_id = '$us2'");
            while ($rr2 = mysqli_fetch_array($u2)) {
                $email2 = $rr2['email'];
                $name2 = $rr2['user_name'];
            }
            $rrr = strtok($name, " ");
                $msg = '<span class="alert alert-success">Media Uploaded Successfully and mail sent to <span style="text-transform: lowercase;">'.$email.' and '.$email2.'.</span></span>';
                $subject = 'New Media Uploaded';
                $message = 'Hello All, <br> A Media has just been uploaded to Incident S/N '.$issue_id.' by '.$son.'. Please <a href="incident-log.eclathealthcare.com">Log In</a> and Check.<br> Best Regards.';
                
                sendMail2($email, $rrr, $subject, $message, $msg, $url, $email2);
        }      
        }      
    }

    }

if (isset($_POST['submit_dact'])) {

    $so = $_SESSION['id'];
    $user_id = $_POST['user_id'];
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE user set status = 0 where user_id = '$user_id'");
    
    $_SESSION['msg'] = '<span class="alert alert-success">User Deactivated Successfully.</span>';
    header("Location: $url ");

}

if (isset($_POST['submit_act'])) {

    $so = $_SESSION['id'];
    $user_id = $_POST['user_id'];
    $url = $_POST['url'];

    $query = mysqli_query($conn, "UPDATE user set status = 1 where user_id = '$user_id'");
    
    $_SESSION['msg'] = '<span class="alert alert-success">User Activated Successfully.</span>';
    header("Location: $url ");

}

if (isset($_POST['submit_switch'])) {
    $state_id = $_POST['state'];
    $user_id = $_SESSION['id'];

    $query = mysqli_query($conn, "UPDATE user set state_id = $state_id where user_id = '$user_id'");
    
    unset($_SESSION['state_id']);
    $_SESSION['state_id'] = $state_id;
    $_SESSION['msg'] = '<span class="alert alert-success">State Changed Successfully.</span>';
    header("Location: index.php ");

}

if (isset($_POST['send_to_client'])) {
    $id = $_POST['issue_id'];
    $user_id = $_SESSION['id'];

    $query = mysqli_query($conn, "UPDATE issue set type = 2 where issue_id = '$id'");
    
    $_SESSION['msg'] = '<span class="alert alert-success">Successfully sent to Home Dashboard.</span>';
    header("Location: index.php ");

}
?>