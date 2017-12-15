<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página principal de una galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
include_once("includes/cabecera.php");
 ?>
 
<body>
	<!-- HEADER -->
	<?php include_once("includes/header.php"); ?>
	
	<aside id="buscar">
		<a class="lupa" href="buscar.php" title="Buscar" tabindex="9"></a>
	</aside>
	
	<section id="principal">
		<h2>Inicio</h2>
		<?php CargarUltimasFotos(); ?>
	</section>
	<section id="principal">
		<h2>Fotos seleccionadas</h2>
		<?php MostrarFotoSeleccionada(); ?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php include_once("includes/footer.php"); ?>