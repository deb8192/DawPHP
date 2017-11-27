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
			if (empty($_POST['fotoPerfil'])){
				CrearUsuarioEnBD($_POST['nombre'],$_POST['password2'],$_POST['correo'],$_POST['sexo'],
				$_POST['fecha_nac'],$_POST['ciudad'],$_POST['paises'],'perfiles/foto.jpg',date('d/m/Y H:i:s'));
			}
			else{
				CrearUsuarioEnBD($_POST['nombre'],$_POST['password2'],$_POST['correo'],$_POST['sexo'],
				$_POST['fecha_nac'],$_POST['ciudad'],$_POST['paises'],$_POST['fotoPerfil'],date('d/m/Y H:i:s'));
			}
			/*
			$_SESSION['reg']['nombre'] = $_POST['nombre'];
			$_SESSION['reg']['correo'] = $_POST['correo'];
			$_SESSION['reg']['sexo'] = $_POST['sexo'];
			$_SESSION['reg']['fecha'] = $_POST['fecha_nac'];
			$_SESSION['reg']['ciudad'] = $_POST['ciudad'];
			$_SESSION['reg']['pais'] = $_POST['paises'];*/
			
			// Foto por defecto
			if (empty($_POST['fotoPerfil']))
				$_SESSION['reg']['foto'] = 'perfiles/foto.jpg';
			else
				$_SESSION['reg']['foto'] = $_POST['fotoPerfil'];
			
			header("Location:respuesta_registro.php");
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
		<form id="form_registro" action="registro.php" method="post">
		
			<p><label for="nombre">Nombre: <span class="asterisco_rojo">*</span></label>
			<input type="text" name="nombre" id="nombre" required="" tabindex="5"/></p>
			
			<p><label for="password2">Contraseña: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="password2" id="password2" required="" tabindex="6"/></p>
			
			<p><label for="repassword">Repetir contraseña: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="repassword" id="repassword" required="" tabindex="7"/></p>
			
			<p><label for="correo">Email: <span class="asterisco_rojo">*</span></label>
			<input type="email" name="correo" id="correo" required="" tabindex="8"/></p>
			
			<p>Sexo:
				<label for="hombre">Hombre</label>
				<input type="radio" name="sexo" value="Hombre" id="hombre" tabindex="9" checked>
				<label for="mujer">Mujer</label>
				<input type="radio" name="sexo" value="Mujer" id="mujer" tabindex="10">
			</p>
			
			<p><label for="fecha_nac">Fecha nacimiento:</label>
			<input type="date" name="fecha_nac" id="fecha_nac" tabindex="11"/></p>
			
			<p><label for="ciudad">Ciudad: <span class="asterisco_rojo">*</span></label>
			<input type="text" name="ciudad" id="ciudad" required="" tabindex="12"/></p>
			
			<p><label for="pais">País:</label>
				<select name="paises" tabindex="13" id="pais">
					<?php CargarListaPaises(); ?>
				</select>
			</p>
			
			<p><label for="foto">Foto:</label>
			<input type="file" name="fotoPerfil" id="foto" tabindex="14"/></p>
			
			<input type="submit" name="registro" value="Registrarse" tabindex="15"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>