<?php 
 // Título de la página, keywords y descripción
 $title = 'Crear album';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página página de confirmación de impresión de álbum.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
		
		<section id="respuesta_crear_album">	
			<h2>Álbum creado</h2>
			
			<?php

			$titulo_album_creado = $_POST['titulo_album_creado'];
			$descripcion_album = $_POST['descripcion_album'];
			$fecha = FormatearFechaBarras($_POST['fecha_album']);
			$pais = $_POST['pais'];
			
			CrearAlbum($titulo_album_creado, $descripcion_album, $_POST['fecha_album'], $pais, $_SESSION['usuario']['id']);
			if(!empty($_POST['titulo_album_creado'])){
				echo "<p>Título del álbum: $titulo_album_creado</p>";
			}
			if(!empty($_POST['descripcion_album'])){
				echo "<p>Descripción: $descripcion_album</p>";
			}
			if(!empty($_POST['fecha_album'])){
				echo "<p>Fecha: $fecha</p>";
			}
			if(!empty($_POST['pais'])){
				echo "<p>País: ".CargarPais($pais)."</p>";
			}
			?>
		</section>
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>
	