<?php
	session_start();
	
	function ComprobarLogin($usuario, $pass) {
		require_once('../admin/db.inc');
		$conexion = conecta();
		$consulta = "select IdUsuario, NomUsuario, Email, IF(Sexo = 1, 'Hombre', 'Mujer') as Sexo, DATE_FORMAT(FNacimiento, '%d/%m/%Y') as FNacimiento, Ciudad, NomPais, Foto from usuarios inner join paises on Pais = IdPais where NomUsuario = '$usuario' and Clave = SHA1('$pass')";
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$existe = false;
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			
			//$_SESSION['usuario'] = true;
			$_SESSION['usuario']['id'] = $fila->IdUsuario;
			$_SESSION['usuario']['nombre'] = $fila->NomUsuario;
			$_SESSION['usuario']['foto'] = $fila->Foto;
			$_SESSION['usuario']['correo'] = $fila->Email;
			$_SESSION['usuario']['sexo'] = $fila->Sexo;
			$_SESSION['usuario']['fecha'] = $fila->FNacimiento;
			$_SESSION['usuario']['ciudad'] = $fila->Ciudad;
			$_SESSION['usuario']['pais'] = $fila->NomPais;
			$existe = true;
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	
	function PasarErrorAlIndex() {
		$_SESSION['error']['activado'] = true;
		$_SESSION['error']['descripcion'] = "El usuario o la contraseña no coincide.";
		header("Location:../".$_SESSION['error']['url']);
	}
	
	if (isset($_POST['enviar'])) {
		
		// Iniciar Sesion
		if (isset($_POST['usuario']) && isset($_POST['password'])) {
			$usuario = addslashes($_POST['usuario']);
			$password = addslashes($_POST['password']);
			
			if (ComprobarLogin($usuario, $password)) {
				
				if($_POST['recordar'] == "1"){
					// Las cookies tienen una duracion maxima de un mes
					setcookie("recordar_usuario", $usuario, (time()+60*60*24*30), '/');
					setcookie("recordar_password", $password, (time()+60*60*24*30), '/');
				}
				header("Location:../menu_usuario.php");
			} else {
				PasarErrorAlIndex();
			}
		} else if (isset($_COOKIE["recordar_usuario"]) && isset($_COOKIE["recordar_password"])) {
			$usuario = $_COOKIE["recordar_usuario"];
			$password = $_COOKIE["recordar_password"];
			
			if (ComprobarLogin($usuario, $password)) {
				header("Location:../menu_usuario.php");
			} else {
				PasarErrorAlIndex();
			}
		}
		// Borrar las cookies
	} else {
		// Las guardamos con una hora menos a la actual
		setcookie("recordar_usuario", "", time() - 3600, '/');
		setcookie("recordar_password", "", time() - 3600, '/');
		header("Location:../index.php");
	}
?>