<?php
	session_start();
	if(isset($_SESSION['Logged_in_Email']))
	{
		unset($_SESSION['Logged_in_Email']);
	}
	
	else if(isset($_SESSION['login_admin_username']))
	{
		unset($_SESSION['login_admin_username']);
	}
	header("Location: index.php");
?>