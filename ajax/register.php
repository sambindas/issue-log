<?php
session_start();

require '../connection.php';


	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$password = sha1($_POST['password']);
	$token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 40);
	$type = 'User';

	$query = mysqli_query($conn, "INSERT into user (user_type, user_name, email, phone, password, date_added, token_status) 
								values ('$type', '$name', '$email', '$phone', '$password', now(), '$token')");

	if ($query) {
		$_SESSION['email'] = $email;
		$_SESSION['name'] = $name;
		echo "1";
	} else {
		echo "0";
	}

?>