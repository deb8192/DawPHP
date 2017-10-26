<?php
	session_start();
	if (isset($_POST['usuario']) && isset($_POST['password'])) {
		$usuario = addslashes($_POST['usuario']);
		$password = addslashes($_POST['password']);
		
		$_SESSION['usuario'] = $usuario;
		header("Location:../index.php");
	}
?>