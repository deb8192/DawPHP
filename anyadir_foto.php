<?php 
 // Título de la página, keywords y descripción
 $title = 'PI - Pictures & images';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página principal de una galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
include_once("includes/cabecera.php");

if (isset($_POST['anyadirFoto'])){
	
	$idAlbum = $_POST['album'];
	$destino = "img/albumes/".$_SESSION['usuario']['id']."/".$idAlbum."/";
	if (!file_exists($idAlbum)) {	// Si no existe el album, lo crea
		mkdir($destino);
	}
	
	// Se renombra si hay otro fichero con el mismo nombre
	$nomFich = $_FILES['archivo']['name'];
	if (ComprobarFicherosIguales($destino, $nomFich)) {
		$nomFich = RenombrarFichero($destino, $nomFich);
	}
	
	if ($_FILES['archivo']['error'] == 0) {
		$tipo = $_FILES['archivo']['type'];
		if ($tipo=="image/jpeg" || $tipo=="image/pjpeg" ||
			$tipo=='image/gif' || $tipo=="image/png") {
			
			// Sacamos el destino con el nombre de la foto
			$origen = $_FILES['archivo']['tmp_name'];
			$carpetaDeDestino = $destino.$nomFich;
			$foto_a_subir=$carpetaDeDestino;
			
			// Movemos el fichero de la carpeta temporal a la de albumes
			move_uploaded_file($origen, $carpetaDeDestino);
			
			SubirFoto($_POST['Titulo'], $_POST['descripcion_foto'], $_POST['fecha'], $_POST['paises'], $_POST['album'], $foto_a_subir);
			
			$_SESSION['foto']['titulo'] = $_POST['Titulo'];
			$_SESSION['foto']['descripcion_foto'] = $_POST['descripcion_foto'];
			$_SESSION['foto']['foto'] = $foto_a_subir;
			
			$fecha = FormatearFechaBarras($_POST['fecha']);
			$_SESSION['foto']['fecha'] = $fecha;
			
			$_SESSION['foto']['pais'] = $_POST['paises'];
			$_SESSION['foto']['album'] = $idAlbum;
			
			header("Location: respuesta_anyadir_foto.php");
		}
	} else {
		$_SESSION['error']['activado'] = true;
		$_SESSION['error']['descripcion'] = "Fallo al subir la foto.";
		header("Location:".$_SESSION['error']['url']);
	}
}
 ?>
 
<body>
	<!-- HEADER -->
	<?php include_once("includes/header.php"); ?>
		<section id="anyadirFoto">

		<h2>Introduce los datos de tu foto</h2>
		<p class="letra_roja">(*) Campos obligatorios</p>
		<form enctype="multipart/form-data" action="anyadir_foto.php" method="post">
				
				<p><label for= "Titulo">Titulo: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="Titulo" id="Titulo" required="" tabindex="9"/></p>  <!--obligatorio, máximo 200 caracteres entre nombre y apellidos-->
			
				<p class="descripcion_foto">Descripción: <span class="asterisco_rojo">*</span></p>
				<textarea name="descripcion_foto" id="descripcion_foto" required="" rows="4" cols="50" maxlength="4000" tabindex="10"></textarea>
				
				<p><label for= "fecha">Fecha: <span class="asterisco_rojo">*</span></label>
				<input type= "date" name="fecha" id="fecha" required="" tabindex="11"/></p>
				
				<p><label for= "pais">Pais: <span class="asterisco_rojo">*</span></label>
				<select name="paises" tabindex="12" id="pais">
				<?php CargarListaPaises(); ?>
				</select>
				
				<p><label for= "urlFoto">Foto: <span class="asterisco_rojo">*</span></label>
				<input type="file" name="archivo" id="archivo" required="" tabindex="13"/></p>
			
				<p class="quitar_arriba">
				<label for= "album">Selecciona un álbum: <span class="asterisco_rojo">*</span></label>
				<select name="album" required="" tabindex="14" id="salbum">
				<option value="">Elegir álbum...</option>
					<?php CargarListaAlbumesPorUsuario($_SESSION['usuario']['id']); ?>
				</select></p> 
			
			<input type="submit" name="anyadirFoto" value="Subir foto" tabindex="14"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>