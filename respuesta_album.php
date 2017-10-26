<?php 
 // Título de la página, keywords y descripción
 $title = 'Respuesta álbum';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página página de confirmación de impresión de álbum.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("header.php"); ?>
	
	<section id="respuesta_album">	
		<h2>Solicitud de álbum registrada</h2>
		
		<h3>Tu álbum</h3>
		
		<h4>Datos personales</h4>
				
		<?php

			if(isset($_POST['nombre'])){
				$nombre = $_POST['nombre'];
				echo "<p>Nombre: $nombre</p>";
			}
			if(isset($_POST['apellidos'])){
				$apellidos = $_POST['apellidos'];
				echo "<p>Apellidos: $apellidos</p>";
			}
			if(isset($_POST['email'])){
				$email = $_POST['email'];
				echo "<p>Email: $email</p>";
			}
			if(isset($_POST['titulo_album'])){
				$titulo_album = $_POST['titulo_album'];
				echo "<p>Titulo: $titulo_album</p>";
			}
			if(isset($_POST['area_texto'])&&$_POST['area_texto']!=" "){
				$area_texto = $_POST['area_texto'];
				echo "<p>Texto adicional: $area_texto</p>";
			}
		?>

		<h4>Dirección</h4>
		
		<?php
			if(isset($_POST['calle'])){
				$calle = $_POST['calle'];
				echo "<p>Calle: $calle</p>";
			}
			if(isset($_POST['numero_portal'])){
				$numero_portal = $_POST['numero_portal'];
				echo "<p>Numero: $numero_portal</p>";
			}
			if(isset($_POST['escalera'])){
				$escalera = $_POST['escalera'];
				echo "<p>Escalera: $escalera</p>";
			}
			if(isset($_POST['piso'])){
				$piso = $_POST['piso'];
				echo "<p>Piso: $piso</p>";
			}
			if(isset($_POST['puerta'])){
				$puerta = $_POST['puerta'];
				echo "<p>Puerta: $puerta</p>";
			}
			if(isset($_POST['CP'])){
				$CP = $_POST['CP'];
				echo "<p>Código postal: $CP</p>";
			}
			if(isset($_POST['localidad'])){
				$localidad = $_POST['localidad'];
				echo "<p>Localidad: $localidad</p>";
			}
			if(isset($_POST['provincia'])){
				$provincia = $_POST['provincia'];
				echo "<p>Provincia: $provincia</p>";
			}
			if(isset($_POST['pais'])){
				$pais = $_POST['pais'];
				echo "<p>Pais: $pais</p>";
			}
		?>
				
		<h4>Configuración de tu álbum</h4>
	
		<?php
			if(isset($_POST['color_album'])){
				$color_album = $_POST['color_album'];
				echo "<p>Color de la portada del álbum: $color_album</p>";
			}
			if(isset($_POST['numero_copias'])){
				$numero_copias = $_POST['numero_copias'];
				echo "<p>Numero de copias: $numero_copias</p>";
			}
			if(isset($_POST['resolucion'])){
				$resolucion = $_POST['resolucion'];
				echo "<p>Resolucion de las fotos: $resolucion dpi</p>";
			}
			if(isset($_POST['album'])){
				$album = $_POST['album'];
				echo "<p>Album: $album</p>";
			}
			if(isset($_POST['fecha_recepcion'])){
				$fecha_recepcion = $_POST['fecha_recepcion'];
				echo "<p>Fecha de recepción: $fecha_recepcion</p>";
			}
			if(isset($_POST['color_fotos'])){
				$color_fotos = $_POST['color_fotos'];
				if($color_fotos="blanco_negro")
					echo "<p>Color de las fotos: blanco y negro</p>";
				else
					echo "<p>Color de las fotos: color</p>";
			}
		?>
		<p>Precio: 1000.00 €</p>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("footer.php"); ?>