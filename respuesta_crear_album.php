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
			
			if (isset($_POST['crear_album'])) {
				$titulo_album_creado = $_POST['titulo_album_creado'];
				$descripcion_album = $_POST['descripcion_album'];
				$date = new DateTime($_POST['fecha_album']);
				$pais = $_POST['pais'];
				$id_album = CrearAlbum($titulo_album_creado, $descripcion_album, $date, $pais, $_SESSION['usuario']['id']);

				CargarAlbum($id_album);
			}
			?>
		</section>
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>
	