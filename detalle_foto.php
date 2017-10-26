<?php 
 // Título de la página, keywords y descripción
 $title = 'Detalles de la foto';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, detalle, detalles';
 $description = 'Página de detalles de una foto de la galería on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("header.php"); ?>
	
	<section id="detalle_imagen">
		<h2>Detalle foto 1</h2>
		<img src="img/foto.jpg" alt="Foto 1" width="400" height="300"/>
		<aside>
			<h3>Detalles</h3>
			<p>Título: Lorem ipsum</p>
			<p>Fecha: 00/00/0000</p>
			<p>País: España</p>
			<p>Álbum: Carpeta 1</p>
			<p>Usuario: John Smith</p>
		</aside>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("footer.php"); ?>