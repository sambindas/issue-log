<?php
session_start();

require '../connection.php';


	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$code = mysqli_real_escape_string($conn, $_POST['code']);
	$cperson = mysqli_real_escape_string($conn, $_POST['cperson']);
	$cpersonp = mysqli_real_escape_string($conn, $_POST['cpersonp']);
	$serverip = mysqli_real_escape_string($conn, $_POST['serverip']);

	$query = mysqli_query($conn, "INSERT into facility (name, code, contact_person, contact_person_phone, server_ip) 
								values ('$name', '$code', '$cperson', '$cpersonp', '$serverip')");

	if ($query) {
		$_SESSION['msg'] = '<span class="alert alert-success">Facility Added Successfully</span>';
		echo "1";
	} else {
		echo "0";
	}

?>