<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página principal de una galería de fotos on-line.';
 // Para cargar la lista de paises
 require_once("includes/functions.php");
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
include_once("includes/cabecera.php");
 ?>
 
<body>
	<!-- HEADER -->
	<?php include_once("includes/header.php"); ?>
	
	<aside id="buscar">
	<!-- Poner la lupa, es lupa.svg -->
		<a href="buscar.php" tabindex="5">Buscar</a>
	</aside>
	
	<section id="principal">
		<h2>Inicio</h2>
		<?php CargarUltimasFotos(); ?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php include_once("includes/footer.php"); ?>