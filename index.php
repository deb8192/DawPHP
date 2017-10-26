<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página principal de una galería de fotos on-line.';

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
<body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<aside id="buscar">
		<form action="buscar.php" method="post">
			<input type="text" name="buscador" tabindex="5"/>
			<input type="submit" name="buscar" value="Buscar" tabindex="6"/>
		</form>
	</aside>
	
	<section id="principal">
		<h2>Inicio</h2>
		<ul class="lista_fotos">
			<li>
				<h3>Título</h3>
				<a href="detalle_foto.php" title="Ver foto1" tabindex="7"><img src="img/foto.jpg" alt="Foto 1" width="200" height="150"/></a>
				<ul class="datos">
					<li>Fecha</li>
					<li>País</li>
				</ul>
			</li>
			<li>
				<h3>Título</h3>
				<a href="detalle_foto.php" title="Ver foto2" tabindex="8"><img src="img/foto.jpg" alt="Foto 2" width="200" height="150"/></a>
				<ul class="datos">
					<li>Fecha</li>
					<li>País</li>
				</ul>
			</li>
			<li>
				<h3>Título</h3>
				<a href="detalle_foto.php" title="Ver foto3" tabindex="9"><img src="img/foto.jpg" alt="Foto 3" width="200" height="150"/></a>
				<ul class="datos">
					<li>Fecha</li>
					<li>País</li>
				</ul>
			</li>
			<li>
				<h3>Título</h3>
				<a href="detalle_foto.php" title="Ver foto4" tabindex="10"><img src="img/foto.jpg" alt="Foto 4" width="200" height="150"/></a>
				<ul class="datos">
					<li>Fecha</li>
					<li>País</li>
				</ul>
			</li>
			<li>
				<h3>Título</h3>
				<a href="detalle_foto.php" title="Ver foto5" tabindex="11"><img src="img/foto.jpg" alt="Foto 5" width="200" height="150"/></a>
				<ul class="datos">
					<li>Fecha</li>
					<li>País</li>
				</ul>
			</li>
		</ul>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>