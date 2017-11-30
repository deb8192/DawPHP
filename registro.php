<?php 
 // Título de la página, keywords y descripción
 $title = 'Registro';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de registro de una galería de fotos on-line.';

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");

if (isset($_POST['registro'])){
	
	//Comparar contraseña con repetir contraseña
	if (strcmp ($_POST['repassword'],$_POST['password2']) !== 0) {
		$_SESSION['error']['activado'] = true;
		$_SESSION['error']['descripcion'] = "Las contraseñas no coinciden.";
	} else {
		
		if (ComprobarNombreUsuario($_POST['nombre'])) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "Usuario no disponible.";
		} else {
			// Foto por defecto
			$destino = "img/perfiles/";
			$foto_de_perfil = $destino.'foto.jpg';
			
			if ($_FILES['fotoPerfil']['error'] == 0) {
				
				$tipo = $_FILES['fotoPerfil']['type'];
				if ($tipo=="image/jpeg" || $tipo=="image/pjpeg" ||
					$tipo=='image/gif' || $tipo=="image/png") {
					
					// Sacamos el destino con el nombre de la foto
					$origen = $_FILES['fotoPerfil']['tmp_name'];
					$carpetaDeDestino = $destino . $_FILES['fotoPerfil']['name'];
					$foto_de_perfil=$carpetaDeDestino;
					
					// Movemos el fichero de la carpeta temporal a la de perfiles
					move_uploaded_file($origen, $carpetaDeDestino);
				}
			}
			
			// Creamos el usuario e iniciamos sesión si todo ha ido bien
			CrearUsuarioEnBD($_POST['nombre'],$_POST['password2'],$_POST['correo'],$_POST['sexo'],
				$_POST['fecha_nac'],$_POST['ciudad'],$_POST['paises'],$foto_de_perfil);
		}
	}
}
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section id="registro">
		<h2>Registro</h2>
		<p class="letra_roja">(*) Campos obligatorios</p>
		<form id="form_registro" enctype="multipart/form-data" action="registro.php" method="post">
		
			<p><label for="nombre">Nombre: <span class="asterisco_rojo">*</span></label>
			<input type="text" name="nombre" id="nombre" required="" tabindex="9"/></p>
			
			<p><label for="password2">Contraseña: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="password2" id="password2" required="" tabindex="10"/></p>
			
			<p><label for="repassword">Repetir contraseña: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="repassword" id="repassword" required="" tabindex="11"/></p>
			
			<p><label for="correo">Email: <span class="asterisco_rojo">*</span></label>
			<input type="email" name="correo" id="correo" required="" tabindex="12"/></p>
			
			<p>Sexo:
				<label for="hombre">Hombre</label>
				<input type="radio" name="sexo" value="Hombre" id="hombre" tabindex="13" checked>
				<label for="mujer">Mujer</label>
				<input type="radio" name="sexo" value="Mujer" id="mujer" tabindex="14">
			</p>
			
			<p><label for="fecha_nac">Fecha nacimiento:</label>
			<input type="date" name="fecha_nac" id="fecha_nac" tabindex="15"/></p>
			
			<p><label for="ciudad">Ciudad: <span class="asterisco_rojo">*</span></label>
			<input type="text" name="ciudad" id="ciudad" required="" tabindex="16"/></p>
			
			<p><label for="pais">País:</label>
				<select name="paises" tabindex="17" id="pais">
					<?php CargarListaPaises(); ?>
				</select>
			</p>
			
			<p><label for="foto">Foto:</label>
			<input type="file" name="fotoPerfil" id="foto" tabindex="18"/></p>
			
			<input type="submit" name="registro" value="Registrarse" tabindex="19"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>