<?php
require('includes/dbconnect.php');
	session_start();

	unset($_SESSION['user_login']);
	setcookie("uname", ' ', time() - 3600);

	$username= $_SESSION['uname'];

	$sql ="UPDATE tbl_user SET login_session = '' WHERE username ='$username';";
	$sql_exe = mysqli_query($dbc, $sql);

	unset($_SESSION['uname']);

	header('Location: index.php');
?>
