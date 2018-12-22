<?php
session_start();

require 'connection.php';


	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 40);
	$type = 'User';

	$query = mysqli_query($conn, "INSERT into user (user_type, user_name, email, phone, password, date_added, token_status) 
								values ('$type', '$name', '$email', '$phone', '$password', now(), '$token')");

	if ($query) {
		echo "1";
	} else {
		echo "0";
	}

?>