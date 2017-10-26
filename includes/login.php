<?php
	session_start();
	
	// Usuarios predefinidos
	$usuarios = array(
		"Débora" => "pupete",
		"Marinés" => "fritz",
		"Prueba" => "prueba",
	);
	
	if (isset($_POST['usuario']) && isset($_POST['password'])) {
		$usuario = addslashes($_POST['usuario']);
		$password = addslashes($_POST['password']);
		
		if (array_key_exists($usuario, $usuarios)) {
			$_SESSION['usuario'] = $usuario;
			header("Location:../menu_usuario.php");
		} else
			header("Location:../index.php");
	}
?>