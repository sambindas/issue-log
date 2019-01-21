<?php
session_start();

require '../connection.php';


	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$code = mysqli_real_escape_string($conn, $_POST['code']);

	$query = mysqli_query($conn, "INSERT into facility (name, code) 
								values ('$name', '$code')");

	if ($query) {
		$_SESSION['msg'] = '<span class="alert alert-success">Facility Added Successfully</span>';
		echo "1";
	} else {
		echo "0";
	}

?>