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
		<?php
		// Los usuarios no registrados no pueden ver los detalles de las fotos.
		if (empty ($_SESSION['usuario'])){
			echo '<h2>CONTENIDO NO DISPONIBLE</h2><p>Debes iniciar sesión para poder ver este contenido.</p>';
		} else {?>
			<h2><?php echo $fotos[$_GET['id']]['titulo']; ?></h2>
			<img src="img/<?php echo $fotos[$_GET['id']]['nombre']; ?>" alt=<?php echo $fotos[$_GET['id']]['nombre']; ?>" width="400" height="300"/>
			<aside>
				<h3>Detalles</h3>
				<p>Fecha: <?php echo $fotos[$_GET['id']]['fecha']; ?></p>
				<p>País: <?php echo $fotos[$_GET['id']]['pais']; ?></p>
				<p>Álbum: <?php echo $fotos[$_GET['id']]['album']; ?></p>
				<p>Usuario: <?php echo $fotos[$_GET['id']]['usuario']; ?></p>
			</aside>
		<?php } ?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>