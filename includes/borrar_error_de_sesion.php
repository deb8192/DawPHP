<?php
	session_start();
	if ($_SESSION['error']['activado']) {
		$url = $_SESSION['error']['url'];
		unset($_SESSION['error']);
		
		$_SESSION['error']['activado'] = false;
		header("Location:../$url");
	}
?>