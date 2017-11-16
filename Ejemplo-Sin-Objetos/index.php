<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página principal de una galería de fotos on-line.';

 require('admin/db.inc');
 $conexion = conecta();
 $consulta = 'select * from usuarios';
 $resultado = ejecutaConsulta($conexion, $consulta);
 mysqli_free_result($resultado);
 mysqli_close($conexion);
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
include_once("includes/cabecera.php");
 ?>
 
<body>
	<!-- HEADER -->
	<?php include_once("includes/header.php"); ?>
	
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
				<h3><?php echo $fotos[1]['titulo']; ?></h3>
				<a href="detalle_foto.php?id=1" title="Ver foto1" tabindex="7"><img src="img/jackie.jpg" alt="Foto 1" width="200" height="150"/></a>
				<ul class="datos">
					<li><?php echo $fotos[1]['fecha']; ?></li>
					<li><?php echo $fotos[1]['pais']; ?></li>
				</ul>
			</li>
			<li>
				<h3><?php echo $fotos[0]['titulo']; ?></h3>
				<a href="detalle_foto.php?id=0" title="Ver foto2" tabindex="8"><img src="img/piensa.jpg" alt="Foto 2" width="200" height="150"/></a>
				<ul class="datos">
					<li><?php echo $fotos[0]['fecha']; ?></li>
					<li><?php echo $fotos[0]['pais']; ?></li>
				</ul>
			</li>
			<li>
				<h3><?php echo $fotos[1]['titulo']; ?></h3>
				<a href="detalle_foto.php?id=1" title="Ver foto3" tabindex="9"><img src="img/jackie.jpg" alt="Foto 3" width="200" height="150"/></a>
				<ul class="datos">
					<li><?php echo $fotos[1]['fecha']; ?></li>
					<li><?php echo $fotos[1]['pais']; ?></li>
				</ul>
			</li>
			<li>
				<h3><?php echo $fotos[0]['titulo']; ?></h3>
				<a href="detalle_foto.php?id=0" title="Ver foto4" tabindex="10"><img src="img/piensa.jpg" alt="Foto 4" width="200" height="150"/></a>
				<ul class="datos">
					<li><?php echo $fotos[0]['fecha']; ?></li>
					<li><?php echo $fotos[0]['pais']; ?></li>
				</ul>
			</li>
			<li>
				<h3><?php echo $fotos[1]['titulo']; ?></h3>
				<a href="detalle_foto.php?id=1" title="Ver foto5" tabindex="11"><img src="img/jackie.jpg" alt="Foto 5" width="200" height="150"/></a>
				<ul class="datos">
					<li><?php echo $fotos[1]['fecha']; ?></li>
					<li><?php echo $fotos[1]['pais']; ?></li>
				</ul>
			</li>
		</ul>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php include_once("includes/footer.php"); ?>