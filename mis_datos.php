<?php 
 // Título de la página, keywords y descripción
 $title = 'Mis datos';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, modificar, nombre usuario, contraseña';
 $description = 'Página de modificacion de datos de usuario.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 
 if (isset($_POST['modificar'])){
	
	//Comparar contraseña con repetir contraseña
		if (strcmp ($_SESSION['usuario']['nombre'],$_POST['nombre'])!==0){
			if (ComprobarNombreUsuario($_POST['nombre'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "Usuario no disponible.";
				echo $_SESSION['error']['descripcion'];
			}
			// Comprobar longitud del nombre
			else if (!ComprobarLongitud(3, 15, $_POST['nombre'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "El tamaño del nombre debe ser de 3 a 15 caracteres.";
				echo $_SESSION['error']['descripcion'];
			
			// Comprobar caracteres del nombre
			} else if (!ComprobarPatron("/^([a-zA-Z0-9]{3,15})$/", $_POST['nombre'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "El nombre sólo debe contener letras y números.";
				echo $_SESSION['error']['descripcion'];
			
			
			// Comprobar longitud contrasenya
			} else if (!ComprobarLongitud(6, 15, $_POST['password2'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "El tamaño de la contraseña debe ser de 6 a 15 caracteres.";
				echo $_SESSION['error']['descripcion'];
				
				// Comprobar caracteres de la contrasenya
			} else if (!ComprobarPatron("/^([a-zA-Z0-9_]{6,15})$/", $_POST['password2'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "La contraseña sólo debe contener letras y números.";
				echo $_SESSION['error']['descripcion'];
				
				// Comprobar mayus, minus y numero contrasenya
			} else if (!ComprobarMayusMinusNumeros($_POST['password2'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "La contraseña debe tener un nº, una letra minúscula y otra mayúscula.";
				echo $_SESSION['error']['descripcion'];
				
			} else if (strcmp ($_POST['repassword'],$_POST['password2']) !== 0) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "Las contraseñas no coinciden.";
				echo $_SESSION['error']['descripcion'];
			
				// Comprobar email
			} else if (!ComprobarPatron("/@([\w]{2,4})\./", $_POST['correo'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "Dominio principal de correo no válido. De 2 a 4 caracteres detrás del @.";
				echo $_SESSION['error']['descripcion'];
				
				// Comprobar fecha nacimiento
			} else if (!ComprobarFecha($_POST['fecha_nac'])) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "Fecha no válida.";
				echo $_SESSION['error']['descripcion'];
				
			}/*else if (strcmp ($_SESSION['usuario']['password'],SHA1($_POST['password'])) !== 0) {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "Pasword Incorrecto.";
				echo $_SESSION['error']['descripcion'];
			} */
			else {
				echo 'medio va';
				enviarDatosBD($_POST['nombre'],$_POST['password2'],$_POST['password'],$_POST['correo'],$_POST['sexo'],
				$_POST['fecha_nac'],$_POST['ciudad'],$_POST['paises'],$_FILES['fotoPerfil'], $_SESSION['usuario']['id']);
			
			}
		}
	
}
  ?>
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="modificar_datos_usuario">
		
		<h2>Modificar mis datos</h2>
		
		<?php
		BuscarUsuario($_SESSION['usuario']['id']);
		?>
		
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>