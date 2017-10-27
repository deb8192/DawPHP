<?php
	session_start(); 
	include_once('usuariosBD.php');
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