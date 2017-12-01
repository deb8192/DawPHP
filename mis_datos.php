<?php 
 // Título de la página, keywords y descripción
 $title = 'Respuesta álbum';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página de confirmación de impresión de álbum.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="modificar_datos_usuario">
		
		<h2>Modificar mis datos</h2>
		
		<?php
		BuscarUsuario($_SESSION['usuario']['id']);
		?>
		
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>