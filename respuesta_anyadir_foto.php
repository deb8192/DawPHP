<?php 
 // Título de la página, keywords y descripción
 $title = 'Respuesta a añadir foto';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, añadir, subir';
 $description = 'Página de usuario que resume los datos de la foto subida.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="datos_usuario">
		<h2>Datos personales</h2>
		<img src="img/<?php echo $_SESSION['reg']['foto']; ?>" alt="Foto perfil" width="200" height="150"/>
		
		<p>Nombre: <?php echo $_SESSION['reg']['nombre']; ?></p>
		<p>Email: <?php echo $_SESSION['reg']['correo']; ?></p>
		<p>Sexo: <?php echo $_SESSION['reg']['sexo']; ?></p>
		<p>Fecha: <?php
			if (!empty($_SESSION['reg']['fecha_nac']))
				 echo $_SESSION['reg']['fecha_nac']; 
		?></p>
		<p>Ciudad: <?php echo $_SESSION['reg']['ciudad']; ?></p>
		<p>País: <?php echo CargarPais($_SESSION['reg']['pais']); ?></p>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>