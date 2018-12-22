<?php

function checkUserSession() {
	if (!isset($_SESSION['email']) && !isset($_SESSION['name'])) {
		header("Location: login.php");
	} else {
		$email = $_SESSION['email'];
		$name = $_SESSION['name'];
	}
}

function userInfo($email) {
	$userInfoQ = mysqli_query($conn, "SELECT * from users where email = $email");
	}


?>
