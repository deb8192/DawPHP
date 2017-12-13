<?php 
 // Título de la página, keywords y descripción
 $title = 'Registro';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de registro de una galería de fotos on-line.';

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");

function Comprobaciones($nombre, $pass, $repassword, $mail, $fecha) {
	
	if (!ComprobarNombre($nombre)) {
		return false;
	} else if (!ComprobarContrasenya($pass, $repassword)) {
		return false;
	} else if (!ComprobarMail($mail)) {
		return false;
	} else if (!ComprobarFechaValida($fecha)) {
		return false;
	}
	return true;
}
/*
if (isset($_SESSION['mod'])) {
	$nom = $_SESSION['mod']['nom'];
	/*$pass = $_SESSION['mod']['pass'];
	$rePas = $_SESSION['mod']['rePas'];*/
	/*$mail = $_SESSION['mod']['mail'];
	$fecha = $_SESSION['mod']['fecha'];
	$ciudad = $_SESSION['mod']['ciudad'];
	$pais = $_SESSION['mod']['pais'];
	$sexo = $_SESSION['mod']['sexo'];
	$foto = $_SESSION['mod']['foto'];
} else {*/
	$usu = BuscarUsuario($_SESSION['usuario']['id']);
	
	$nom=$usu->NomUsuario;
	$mail=$usu->Email;
	$fecha=$usu->FNacimiento;
	$ciudad=$usu->Ciudad;
	$pais=$usu->Pais;
	$foto = $usu->Foto;
	
	if ($usu->Sexo == 2)
		$sexo = "Mujer";
	else
		$sexo = "Hombre";
//}

if (isset($_POST['modificar'])) {
	$_SESSION['error']['activado'] = false;
	
	$_SESSION['mod']['nom'] = $nom = $_POST['nombre'];
	/*$_SESSION['mod']['pass'] = */$pass = $_POST['password2'];//
	/*$_SESSION['mod']['rePas'] = */$rePas = $_POST['repassword'];//
	$passAnterior = $_POST['password'];
	$_SESSION['mod']['mail'] = $mail = $_POST['correo'];
	$_SESSION['mod']['fecha'] = $fecha = $_POST['fecha_nac'];
	$_SESSION['mod']['ciudad'] = $ciudad = $_POST['ciudad'];
	$_SESSION['mod']['pais'] = $pais = $_POST['paises'];
	$_SESSION['mod']['sexo'] = $sexo = $_POST['sexo'];
	//$_SESSION['mod']['foto'] = $foto = "img/perfiles/".$_FILES['fotoPerfil']['name'];
	
	// Comprobamos que la contrasenya anterior es correcta
	if (!ComprobarLogin($_SESSION['usuario']['nombre'], $passAnterior)) {
		$_SESSION['error']['activado'] = true;
		$_SESSION['error']['descripcion'] = "Contraseña anterior incorrecta.";
	} else {
		
		/*$valor = Comprobaciones($nom, $pass, $rePas, $mail, $fecha);
		
		if ($valor) {
			// Borramos los datos a modificar de la sesion
			unset($_SESSION['mod']);
		}*/
	}
}
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section id="modificar_datos_usuario">
		<h2>Modificar mis datos</h2>
		<p class="letra_roja">(*) Campos obligatorios</p>
		<form id="form_modificar_datos" enctype="multipart/form-data" action="mis_datos.php" method="post">
		
			<p><label for="nombre">Nombre: </label>
			<input type="text" name="nombre" id="nombre" tabindex="9" value="<?php echo $nom;?>"/></p>
			
			<p><label for="password2">Contraseña nueva: </label>
			<input type="password" name="password2" id="password2" tabindex="10"/></p>
			
			<p><label for="repassword">Repetir contraseña nueva: </label>
			<input type="password" name="repassword" id="repassword" tabindex="11"/></p>
			
			<p><label for="correo">Email: </label>
			<input type="email" name="correo" id="correo" tabindex="12" value="<?php echo $mail;?>"/></p>
			
			<p>Sexo:
				<label for="hombre">Hombre</label>
				<input type="radio" name="sexo" value="Hombre" id="hombre" tabindex="13"
				<?php 
					if (($sexo=='Hombre') || ($sexo=='')) {
						echo 'checked="checked"';
					}
				?>>
				<label for="mujer">Mujer</label>
				<input type="radio" name="sexo" value="Mujer" id="mujer" tabindex="14"
				<?php 
					if ($sexo=='Mujer') {
						echo 'checked="checked"';
					}
				?>>
			</p>
			
			<p><label for="fecha_nac">Fecha nacimiento: </label>
			<input type="date" name="fecha_nac" id="fecha_nac" tabindex="15" value="<?php echo $fecha;?>"/></p>
			
			<p><label for="ciudad">Ciudad: </label>
			<input type="text" name="ciudad" id="ciudad" tabindex="16" value="<?php echo $ciudad;?>"/></p>
			
			<p><label for="pais">País:</label>
				<select name="paises" tabindex="17" id="pais">
					<?php CargarPaisSeleccionado($pais); ?>
				</select>
			</p>
			
			<p><label for="foto">Foto:</label>
			<p><img src="<?php echo $foto; ?>" alt="Foto perfil" width="200" height="150"/></p>
			<input type="file" name="fotoPerfil" id="foto" tabindex="18"/></p>
			
			<p><label for="password">Introduce tu contraseña antigua: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="password" id="password" required="" tabindex="19"/></p>
			
			<input type="submit" name="modificar" value="Modificar datos" tabindex="20"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>