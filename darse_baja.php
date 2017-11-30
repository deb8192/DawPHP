<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página para darse de baja de la galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
include_once("includes/cabecera.php");
 ?>
 
<body>
	<!-- HEADER -->
	<?php include_once("includes/header.php"); ?>
	
	<section id="datos_usuario">
		<h2>Darse de baja</h2>
		
		<?php 
		if (empty ($_SESSION['usuario']['nombre'])){
			echo '<p>Usuario borrado.</p>';
		} else {
			if (isset($_POST['aceptar'])) {
				$resultado = darseDeBaja($_SESSION['usuario']['id']);
				
				if ($resultado === TRUE) {// Borramos la sesión
					$_SESSION = array();
					session_destroy();
					header("Location: darse_baja.php");
				}
			} else if (isset($_POST['cancelar'])) {
				header("Location: menu_usuario.php");
			} else {?>
				<form action="darse_baja.php" method="post">
					<label for="pregunta">¿Quieres darte de baja?</label>
					<p><input type="submit" name="aceptar" value="Aceptar" tabindex="9"/>
					<input type="submit" name="cancelar" value="Cancelar" tabindex="10"/></p>
				</form>
			<?php }
		} ?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php include_once("includes/footer.php"); ?>