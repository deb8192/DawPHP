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
			
			if (strcmp ($password , $usuarios[$usuario] ) == 0) {
				$_SESSION['usuario'] = $usuario;
				header("Location:../menu_usuario.php");
			} else {
				$_SESSION['error'] = "La contraseña no coincide.";
				header("Location:../index.php");
			}
		} else {
			$_SESSION['error'] = "El usuario es incorrecto.";
			header("Location:../index.php");
		}
	}
?>