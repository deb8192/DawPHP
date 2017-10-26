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
		
		<p class="letra_roja">(*) Campos obligatorios</p>
		
		<form action="respuesta_crear_album.php" method="post">
			<fieldset>
				<legend>Crear album</legend>
				
				<p><label for= "titulo_album_creado">Título: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="titulo_album_creado" id="titulo_album_creado" required="" maxlength="100" tabindex="1"/></p>  
			
				<p class="descripcion_album">Descripción: <span class="asterisco_rojo">*</span></p>
				<textarea name="descripcion_album" id="descripcion_album" required="" maxlength="4000" tabindex="2"/></p>
				
				<p><label for= "fecha_album">Fecha: <span class="asterisco_rojo">*</span></label>
				<input type="date" name="fecha_album" id="fecha_album" required="" tabindex="3"/></p>
				
				<p class="quitar_abajo">País: <span class="asterisco_rojo">*</span></p>
				<p class="quitar_arriba"><select name="pais" required=""  tabindex="4">
					<option value="">Elija país...</option>
					<option value="Alemania">Alemania</option>
					<option value="Escocia">Escocia</option>
					<option value="España">España</option>
					<option value="Francia">Francia</option>
					<option value="Gales">Gales</option>
					<option value="Grecia">Grecia</option>
					<option value="Inglaterra">Inglaterra</option>
					<option value="Irlanda">Irlanda</option>
					<option value="Italia">Italia</option>
				</select></p>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>
	