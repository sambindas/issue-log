<?php
session_start();

require '../connection.php';

	$email = $_POST['email'];
	$password = sha1($_POST['password']);

	$query = mysqli_query($conn, "SELECT * from user where email = '$email' and password = '$password'");



		if ($row = mysqli_fetch_array($query)) {
			$_SESSION['name'] = $row['user_name'];
			$_SESSION['email'] = $row['email'];
			echo "1";
		}
		
	 else {
		echo "0";
	}


?>