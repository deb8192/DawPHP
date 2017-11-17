<?php 
 // Título de la página, keywords y descripción
 $title = 'Buscar';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de búsqueda de una galería de fotos on-line.';
 
 // Para cargar la lista de paises
 require_once("includes/functions.php");

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
 require_once("includes/cabecera.php");
 
 // Criterios de busqueda
 $titulo = $dia = $mes = $anyo = $pais = "";
 
 if (isset($_POST['buscar'])) {
	if(!empty($_POST['titulo'])){
		$titulo = $_POST['titulo'];
	}
	if(!empty($_POST['dia'])&&!empty($_POST['mes'])&&!empty($_POST['anyo'])){
		$dia = $_POST['dia'];
		$mes = $_POST['mes'];
		$anyo = $_POST['anyo'];
	}
	if(!empty($_POST['pais'])){
		$pais = $_POST['pais'];
	}
 }
 
 function CargarNumerosSelect($principio, $fin, $seleccionado) {
	for ($i=$principio; $i<=$fin; $i++) {
		echo '<option value="'.$i.'"';
		
		if ($i == $seleccionado)
			echo' selected';
		
		echo '>'.$i.'</option>';
	}
 }
 function CargarMeses($seleccionado) {
	 $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto",
		"septiembre", "octubre", "noviembre", "diciembre");
		
		$long = count($meses);
		for ($i=0; $i<$long; $i++) {
			echo '<option value="'.($i+1).'"';
			
				if (($i+1) == $seleccionado)
				echo' selected';
			
			echo '>'.$meses[$i].'</option>';
		}
 }
 
 function CargarPaises($seleccionado) {
	$paises = CargarArrayPaises();
	for ($i=0; $i<(count($paises)); $i++) {
		echo '<option value="'.($i+1).'"';
			if (($i+1) == $seleccionado)
			echo' selected';
		echo '>'.$paises[$i].'</option>';
	}
 }
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section class="form_busqueda">
		<h2>Formulario de búsqueda</h2>
		<form action="buscar.php" method="post">
			<p>
				<label for="titulo">Título:</label>
				<input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>" tabindex="5"/>
			</p>
			<p>Fecha:</p>
			<p>
				<select name="dia" tabindex="6">
				<?php CargarNumerosSelect(1,31, $dia); ?>
				</select>
				<select name="mes" tabindex="7">
					<?php CargarMeses($mes); ?>
				</select>
				<select name="anyo" tabindex="8">
					<?php CargarNumerosSelect(2013,2017, $anyo); ?>
				</select>
			</p>
			<p>
				<label for="pais">País:</label>
				<select name="pais" id="pais" tabindex="9">
					<?php CargarPaises($pais); ?>
				</select>
			</p>
			<input type="submit" name="buscar" value="Buscar" tabindex="10"/>
		</form>
		
		<?php
			if (isset($_POST['buscar'])) {
				echo '<section id="resultado_busqueda">
					<h2>Resultado de la búsqueda</h2>';
					BuscarFotos();
				echo '</section>';
			}
		?>
	</section>
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>