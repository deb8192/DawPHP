<?php 
 // Título de la página, keywords y descripción
 $title = 'Usuario registrado';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, detalle, detalles';
 $description = 'Página de usuario registrado de la galería on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="datos_usuario">
		<h2>Datos personales</h2>
		
		<?php
		CargarYMostrarUsuarioRegistrado($_SESSION['reg']['nombre']);
		?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>