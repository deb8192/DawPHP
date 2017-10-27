<?php 
 // Título de la página, keywords y descripción
 $title = 'Detalles de la foto';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, detalle, detalles';
 $description = 'Página de detalles de una foto de la galería on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section id="detalle_imagen">
		<h2>Detalle foto 1</h2>
		<img src="img/<?php echo $fotos[$_GET['id']]['nombre']; ?>" alt=<?php echo $fotos[$_GET['id']]['nombre']; ?>" width="400" height="300"/>
		<aside>
			<h3>Detalles</h3>
			<p>Título: <?php echo $fotos[$_GET['id']]['titulo']; ?></p>
			<p>Fecha: <?php echo $fotos[$_GET['id']]['fecha']; ?></p>
			<p>País: <?php echo $fotos[$_GET['id']]['pais']; ?></p>
			<p>Álbum: <?php echo $fotos[$_GET['id']]['album']; ?></p>
			<p>Usuario: <?php echo $fotos[$_GET['id']]['usuario']; ?></p>
		</aside>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>