<?php
	session_start();
	require_once("includes/functions.php");
	
	// Errores del modal
	if (!isset ($_SESSION['error'])) {
		$_SESSION['error']['activado'] = false;
	}
	//cookie de la ultima visita
	if(isset($_SESSION['usuario']['nombre']))
	{
		if(isset($_COOKIE['last_visit']))
			$last_visit = $_COOKIE['last_visit'];
		else
			$last_visit = date('d/m/Y H:i:s');
		$current_visit = date('d/m/Y H:i:s');
		setcookie("last_visit", $current_visit, (time()+60*60*24*30), '/');
	}
	
	// Comprobamos si hay cookies guardadas
	$existe = 0;
	if (isset($_COOKIE["recordar_usuario"]) && isset($_COOKIE["recordar_password"])){
		
		// Comprobamos que no esten vacias
		if (($_COOKIE["recordar_usuario"] !="") || ($_COOKIE["recordar_password"] !="") ){
			
			// Comprobamos si existe el usuario y tiene guardada la contrasenya
			if (ComprobarLogin ($_COOKIE["recordar_usuario"] , $_COOKIE["recordar_password"] )) {
				$existe = 1;
			}
		}
	}
	
	// Borramos los datos de sesión de modificar el usuario
	if ((isset($_SESSION['mod'])) && (strpos($_SERVER['PHP_SELF'], 'mis_datos') === false )) {
		unset($_SESSION['mod']);
	}
	
	// Borramos los datos de sesión del registro de usuario
	if ((isset($_SESSION['reg'])) && (strpos($_SERVER['PHP_SELF'], 'registro') === false )) {
		unset($_SESSION['reg']);
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo $title; ?></title>
	<meta charset="UTF-8"/>
	<meta name="generator" content="Notepad++" /> 
	<meta name="author" content="Débora Galdeano y Mª Inés Antón" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="keywords" content="<?php echo $keywords; ?>" /> 
	<meta name="description" content="<?php echo $description; ?>" />
	<link rel="stylesheet" type="text/css" href="css/estilos.css" title="Estilo principal" media="screen"/>
	<link rel="alternate stylesheet" type="text/css" href="css/contrast.css" title="Estilo de alto contraste" />
	<link rel="stylesheet" type="text/css" href="css/print.css" title="Estilo de impresión" media="print"/>
</head>