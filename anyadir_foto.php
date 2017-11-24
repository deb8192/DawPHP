<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página principal de una galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
include_once("includes/cabecera.php");
 ?>
 
<body>
	<!-- HEADER -->
	<?php include_once("includes/header.php"); ?>
		<section id="anyadirFoto">

		<h2>Introduce los datos de tu foto</h2>
		<p class="letra_roja">(*) Campos obligatorios</p>
		<form action="mis_albumes.php" method="post" >
				
				<p><label for= "Titulo">Titulo: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="Titulo" id="Titulo" required="" tabindex="4"/></p>  <!--obligatorio, máximo 200 caracteres entre nombre y apellidos-->
			
				<p><label for= "fecha">Fecha: <span class="asterisco_rojo">*</span></label>
				<input type= "date" name="fecha" id="fecha" required="" tabindex="5"/></p>
				
				<p><label for= "pais">Pais: <span class="asterisco_rojo">*</span></label>
				<select name="paises" tabindex="15" id="pais">
				<?php CargarListaPaises(); ?>
				</select>
				
				<p><label for= "urlFoto">Foto: <span class="asterisco_rojo">*</span></label>
				<input type="file" name="archivo" id="archivo" required="" tabindex="7"/></p>
			
				<p class="quitar_arriba"><select name="album" required="" tabindex="21" id="salbum">
					<?php CargarListaAlbumesPorUsuario($_SESSION['usuario']['id']); ?>
				</select></p> 
			
			<input type="submit" name="anyadirFoto" value="Subir foto" tabindex="25"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>