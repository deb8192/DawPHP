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
		
		<section id="crear_album">	
			<h2>Crear album</h2>
			<p class="letra_roja">(*) Campos obligatorios</p>
		
			<form id="form_crear_album" action="respuesta_crear_album.php" method="post">
				
				<p><label for= "titulo_album_creado">Título: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="titulo_album_creado" id="titulo_album_creado" required="" maxlength="100" tabindex="4"/></p>  
			
				<p class="descripcion_album">Descripción: <span class="asterisco_rojo">*</span></p>
				<textarea name="descripcion_album" id="descripcion_album" required="" rows="4" cols="50" maxlength="4000" tabindex="5"></textarea>
				
				<p><label for= "fecha_album">Fecha: <span class="asterisco_rojo">*</span></label>
				<input type="date" name="fecha_album" id="fecha_album" required="" tabindex="6"/></p>
				
				<p class="quitar_abajo">País: <span class="asterisco_rojo">*</span></p>
				<p class="quitar_arriba"><select id="pais" name="pais" required=""  tabindex="7">
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
			<input type="submit" name="crear_album" value="Crear álbum" tabindex="8"/>
			</form>
		</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>
	