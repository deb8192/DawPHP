<?php 
 // Título de la página, keywords y descripción
 $title = 'Menú usuario';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Menú de usuario de la galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="datos_usuario">
		<h2>Datos personales</h2>
		<img src="img/foto.jpg" alt="Foto perfil" width="200" height="150"/>
		<p>Nombre: Pepito Palotes</p>
		<p>Email: pepito@gmail.com</p>
		<p>Sexo: Hombre</p>
		<p>Fecha: 00/00/0000</p>
		<p>Ciudad: Alicante</p>
		<p>País: España</p>
	</section>
	
	<!-- FOOTER -->
	<?php require_once("includes/footer.php"); ?>
</body>
</html>