<?php 
 // Título de la página, keywords y descripción
 $title = 'Buscar';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de búsqueda de una galería de fotos on-line.';

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
 require_once("includes/cabecera.php");
 
 // Criterios de busqueda
 $titulo = $fechaBuscar = $pais = "";
 
 if (isset($_POST['buscar'])) {
	if(!empty($_POST['titulo']))
		$titulo = $_POST['titulo'];
	
	//Si está a null salen las letras y si tiene la fecha, salen los números
	if(!empty($_POST['fecha_buscar']))
		$fechaBuscar = $_POST['fecha_buscar'];
	
	if(!empty($_POST['pais']))
		$pais = $_POST['pais'];
 }
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section class="form_busqueda">
		<h2>Formulario de búsqueda</h2>
		<form action="buscar.php" method="post">
			<p><label for="titulo">Título:</label>
			<input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>" tabindex="9"/></p>
			
			<p><label for="fecha_buscar">Fecha:</label>
			<input type="date" name="fecha_buscar" id="fecha_buscar" value="<?php echo $fechaBuscar;?>" tabindex="10"/></p>
			
			<p>
				<label for="pais">País:</label>
				<select name="pais" id="pais" tabindex="11">
					<option value="">Elegir país...</option>
					<?php CargarPaises($pais); ?>
				</select>
			</p>
			<input type="submit" name="buscar" value="Buscar" tabindex="12"/>
		</form>
		
		<?php
			if (isset($_POST['buscar'])) {
				echo '<section id="resultado_busqueda">
					<h2>Resultado de la búsqueda</h2>';
					BuscarFotos($titulo, $fechaBuscar, $pais);
				echo '</section>';
			}
		?>
	</section>
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>