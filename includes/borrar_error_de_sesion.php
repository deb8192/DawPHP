<?php
	session_start();
	
	if (isset($_SESSION['error'])) {
		unset($_SESSION['error']);
		header("Location:../index.php");
	}
?>