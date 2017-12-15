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

if (isset($_SESSION['reg'])) {
	$nom = $_SESSION['reg']['nom'];
	$pass = $_SESSION['reg']['pass'];
	$rePas = $_SESSION['reg']['rePas'];
	$mail = $_SESSION['reg']['mail'];
	$fecha = $_SESSION['reg']['fecha'];
	$ciudad = $_SESSION['reg']['ciudad'];
	$pais = $_SESSION['reg']['pais'];
	$sexo = $_SESSION['reg']['sexo'];
} else {
	$nom=$pass=$rePas=$mail=$fecha=$ciudad=$pais=$sexo="";
}

if (isset($_POST['registro'])) {
	$_SESSION['error']['activado'] = false;
	
	$_SESSION['reg']['nom'] = $nom = $_POST['nombre'];
	$_SESSION['reg']['pass'] = $pass = $_POST['password2'];
	$_SESSION['reg']['rePas'] = $rePas = $_POST['repassword'];
	$_SESSION['reg']['mail'] = $mail = $_POST['correo'];
	$_SESSION['reg']['fecha'] = $fecha = $_POST['fecha_nac'];
	$_SESSION['reg']['ciudad'] = $ciudad = $_POST['ciudad'];
	$_SESSION['reg']['pais'] = $pais = $_POST['paises'];
	$_SESSION['reg']['sexo'] = $sexo = $_POST['sexo'];
	
	$valor = Comprobaciones($nom, $pass, $rePas, $mail, $fecha);
	
	if ($valor) {
		// Foto por defecto
		$destino = "img/perfiles/";
		$foto_de_perfil = $destino.'foto.jpg';
		
		// Se renombra si hay otro fichero con el mismo nombre
		$nomFich = $_FILES['fotoPerfil']['name'];
		if (ComprobarFicherosIguales($nomFich)) {
			$nomFich = RenombrarFichero($nomFich);
		}
		
		if ($_FILES['fotoPerfil']['error'] == 0) {
			$tipo = $_FILES['fotoPerfil']['type'];
			if ($tipo=="image/jpeg" || $tipo=="image/pjpeg" ||
				$tipo=='image/gif' || $tipo=="image/png") {
				
				// Sacamos el destino con el nombre de la foto
				$origen = $_FILES['fotoPerfil']['tmp_name'];
				$carpetaDeDestino = $destino.$nomFich;
				$foto_de_perfil=$carpetaDeDestino;
				
				// Movemos el fichero de la carpeta temporal a la de perfiles
				move_uploaded_file($origen, $carpetaDeDestino);
			}
		}
		
		
		// Borramos los datos del registro de la sesion
		unset($_SESSION['reg']);
		// Creamos el usuario e iniciamos sesión si todo ha ido bien
		CrearUsuarioEnBD($nom,$pass,$mail,$sexo,$fecha,$ciudad,$pais,$foto_de_perfil);
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
			<input type="text" name="nombre" id="nombre" required="" tabindex="9" value="<?php echo $nom;?>"/></p>
			
			<p><label for="password2">Contraseña: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="password2" id="password2" required="" tabindex="10" value="<?php echo $pass;?>"/></p>
			
			<p><label for="repassword">Repetir contraseña: <span class="asterisco_rojo">*</span></label>
			<input type="password" name="repassword" id="repassword" required="" tabindex="11" value="<?php echo $rePas;?>"/></p>
			
			<p><label for="correo">Email: <span class="asterisco_rojo">*</span></label>
			<input type="email" name="correo" id="correo" required="" tabindex="12" value="<?php echo $mail;?>"/></p>
			
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
			
			<p><label for="fecha_nac">Fecha nacimiento: <span class="asterisco_rojo">*</span></label>
			<input type="date" name="fecha_nac" id="fecha_nac" required="" tabindex="15" value="<?php echo $fecha;?>"/></p>
			
			<p><label for="ciudad">Ciudad: <span class="asterisco_rojo">*</span></label>
			<input type="text" name="ciudad" id="ciudad" required="" tabindex="16" value="<?php echo $ciudad;?>"/></p>
			
			<p><label for="pais">País:</label>
				<select name="paises" tabindex="17" id="pais">
					<?php 
					if ($pais=="")
						CargarListaPaises();
					else
						CargarPaisSeleccionado($pais);
					?>
				</select>
			</p>
			
			<p><label for="foto">Foto:</label>
			<input type="file" name="fotoPerfil" id="foto" tabindex="18"/></p>
			
			<input type="submit" name="registro" value="Registrarse" tabindex="19"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>