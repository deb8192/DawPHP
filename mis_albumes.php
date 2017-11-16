<?php 
 // Título de la página, keywords y descripción
 $title = 'Mis álbumes';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, album, albumes';
 $description = 'Página con todos los albumes de un usuario de la galería on-line.';
 
 // Para cargar la lista de paises
 require_once("includes/functions.php");
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section id="detalle_imagen">
		<h2>Mis álbumes</h2>
		<ul class="lista-albumes">
			<?php CargarAlbumes($_SESSION['usuario']['id']); ?>
		</ul>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>