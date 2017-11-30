<?php 
 // Título de la página, keywords y descripción
 $title = 'Respuesta a añadir foto';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, añadir, subir';
 $description = 'Página que resume los datos de la foto subida.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="datos_usuario">
		<h2>Foto insertada</h2>
		<img src="<?php echo $_SESSION['foto']['foto']; ?>" alt="Foto perfil" width="400" height="300"/>
		<aside>
			<h3>Detalles</h3>
			<p>Título: <?php echo $_SESSION['foto']['titulo']; ?></p>
			<p>Descripción: <?php echo $_SESSION['foto']['descripcion_foto']; ?></p>
			<p>Fecha: <?php echo $_SESSION['foto']['fecha'];?></p>
			<p>País: <?php echo CargarPais($_SESSION['foto']['pais']);?></p>
			<p>Álbum: <?php echo CargarTituloAlbum($_SESSION['foto']['album']);?></p>
		</aside>
		
		
		
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>