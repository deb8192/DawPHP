<?php
	session_start();
	include_once('datosBD.php');
	
	if (isset($_POST['enviar'])) {
		
		// Iniciar Sesion
		if (isset($_POST['usuario']) && isset($_POST['password'])) {
			$usuario = addslashes($_POST['usuario']);
			$password = addslashes($_POST['password']);
			
			if (array_key_exists($usuario, $usuarios)) {
				
				if (strcmp ($password , $usuarios[$usuario]['passw'] ) == 0) {
					$_SESSION['usuario'] = $usuario;
					
					if($_POST['recordar'] == "1"){
						// Las cookies tienen una duracion maxima de un mes
						setcookie("recordar_usuario", $usuario, (time()+60*60*24*30), '/');
						setcookie("recordar_password", $password, (time()+60*60*24*30), '/');
					}
					header("Location:../menu_usuario.php");
				} else {
					$_SESSION['error'] = "La contraseña no coincide.";
					header("Location:../index.php");
				}
			} else {
				$_SESSION['error'] = "El usuario es incorrecto.";
				header("Location:../index.php");
			}
		} else if (isset($_COOKIE["recordar_usuario"]) && isset($_COOKIE["recordar_password"])) {
			$_SESSION['usuario'] = $_COOKIE["recordar_usuario"];
			header("Location:../menu_usuario.php");
		}
		// Borrar las cookies
	} else {
		// Las guardamos con una hora menos a la actual
		setcookie("recordar_usuario", "", time() - 3600, '/');
		setcookie("recordar_password", "", time() - 3600, '/');
		header("Location:../index.php");
	}
?>