<?php 
 // Título de la página, keywords y descripción
 $title = 'Detalles de la foto';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, detalle, detalles';
 $description = 'Página de detalles de una foto de la galería on-line.';
 
 // Para cargar la lista de paises
 require_once("includes/functions.php");
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section id="detalle_imagen">
		<?php
		// Los usuarios no registrados no pueden ver los detalles de las fotos.
		if (empty ($_SESSION['usuario'])){
			echo '<h2>CONTENIDO NO DISPONIBLE</h2><p>Debes iniciar sesión para poder ver este contenido.</p>';
		} else {
			CargarDetalleFoto($_GET['id']);
		} ?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>