<?php 
 // Título de la página, keywords y descripción
 $title = 'Mis datos';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, modificar, nombre usuario, contraseña';
 $description = 'Página de modificacion de datos de usuario.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 
 if (isset($_POST['modificar'])){
	
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
			ModificarUsuarioEnBD($_POST['nombre'],$_POST['password2'],$_POST['password'],$_POST['correo'],$_POST['sexo'],
				$_POST['fecha_nac'],$_POST['ciudad'],$_POST['paises'],$foto_de_perfil, $_SESSION['usuario']['id']);
		}
	}
}
else{
	$_SESSION['error']['activado'] = true;
	$_SESSION['error']['descripcion'] = "Esto no funciona.";}
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