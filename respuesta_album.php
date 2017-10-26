<?php 
 // Título de la página, keywords y descripción
 $title = 'Respuesta álbum';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página página de confirmación de impresión de álbum.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="respuesta_album">	
		<h2>Solicitud de álbum registrada</h2>
		
		<h3>Tu álbum</h3>
			
		<h4>Datos personales</h4>
				
		<p>Nombre: Pepito</p>
		<p>Apellidos: Palotes</p>
		<p>Título: Título álbum Pepito</p>
		<p>Texto adicional: Texto adicional</p>
		<p>Email: pepitopalotes@email.com</p>

		<h4>Dirección</h4>
							
		<p>Dirección: calle rue del percebe Nº23 1 A</p>
		<p>Código postal: 00000</p>
		<p>Localidad: localidad</p>
		<p>Provincia: provincia</p>
		<p>País: país</p>
				
		<h4>Configuración de tu álbum</h4>
	
		<p>Color de la portada: color</p>
		<p>Número de copias: número</p>
		<p>Resolución de las fotos: 150dpi</p>
		<p>Álbum: Álbum de Pepito</p> 
		<p>Fecha de recepción: dd/mm/aaaa</p>
		<p>Color de las fotos: color</p>
		<p>Precio: 0.00 €</p>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>