<?php
 // Título de la página, keywords y descripción
 $title = 'Registro';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de registro de una galería de fotos on-line.';

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");

if (isset($_SESSION['mod'])) {
	
	if (isset($_SESSION['mod']['nom']))
		$nom = $_SESSION['mod']['nom'];
	
	if (isset($_SESSION['mod']['mail']))
		$mail = $_SESSION['mod']['mail'];

	if (isset($_SESSION['mod']['fecha']))
		$fecha = $_SESSION['mod']['fecha'];

	if (isset($_SESSION['mod']['ciudad']))
		$ciudad = $_SESSION['mod']['ciudad'];

	if (isset($_SESSION['mod']['pais']))
		$pais = $_SESSION['mod']['pais'];

	if (isset($_SESSION['mod']['sexo']))
		$sexo = $_SESSION['mod']['sexo'];
	
	if (isset($_SESSION['mod']['foto']))
		$foto = $_SESSION['mod']['foto'];
	
} else {
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
}

if (isset($_POST['modificar'])) {
	$_SESSION['error']['activado'] = false;
	
	$nuevoNom = $_POST['nombre'];
	$pass = $_POST['password2'];
	$rePas = $_POST['repassword'];
	$passAnterior = $_POST['password'];
	$nuevoMail = $_POST['correo'];
	$nuevaFecha = $_POST['fecha_nac'];
	$nuevaCiudad = $_POST['ciudad'];
	$nuevoPais = $_POST['paises'];
	$nuevoSexo = $_POST['sexo'];
	$nuevafoto = $_FILES['fotoPerfil']['name'];
	
	
	$i = -1;
	$variable = [];
	$valor = [];
	$error = false;
	
	// Si los 2 campos de modificar password contienen texto
	if ((!empty($pass)) && (!empty($repassword))) {
		if (ComprobarContrasenya($pass, $repassword)) {
			$i++;
			$variable[$i] = 'Clave';
			$valor[$i] = sha1($pass);
		} else {
			$error = true;
		}
	}
	
	// Si son distintas las cadenas, modifica
	if (strcmp ($nuevoNom , $nom ) !== 0) {
		if (ComprobarNombre($nuevoNom)) {
			$i++;
			$variable[$i] = 'NomUsuario';
			$valor[$i] = $nuevoNom;
		} else {
			$error = true;
		}
	}
	
	if (strcmp ($nuevoMail , $mail ) !== 0) {
		if (ComprobarMail($nuevoMail)) {
			$i++;
			$variable[$i] = 'Email';
			$valor[$i] = $nuevoMail;
		} else {
			$error = true;
		}
	}
	
	if (strcmp ($nuevaFecha , $fecha ) !== 0) {
		if (ComprobarFechaValida($nuevaFecha)) {
			$i++;
			$variable[$i] = 'FNacimiento';
			$valor[$i] = $nuevaFecha;
		} else {
			$error = true;
		}
	}
	
	if (strcmp ($nuevaCiudad , $ciudad ) !== 0) {
		if (!empty($nuevaCiudad)) {
			$i++;
			$variable[$i] = 'Ciudad';
			$valor[$i] = $nuevaCiudad;
		} else {
			$error = true;
		}
	}
	
	if (strcmp ($nuevoPais , $pais ) !== 0) {
		$i++;
		$variable[$i] = 'Pais';
		$valor[$i] = $nuevoPais;
	}
	
	if (strcmp ($nuevoSexo , $sexo ) !== 0) {
		$i++;
		$variable[$i] = 'Sexo';
		$valor[$i] = $nuevoSexo;
	}
	
	if ($nuevafoto !== '') {
		$destino = "img/perfiles/";
		
		if ($_FILES['fotoPerfil']['error'] == 0) {
		
			$tipo = $_FILES['fotoPerfil']['type'];
			if ($tipo=="image/jpeg" || $tipo=="image/pjpeg" ||
				$tipo=='image/gif' || $tipo=="image/png") {
				
				// Sacamos el destino con el nombre de la foto
				$origen = $_FILES['fotoPerfil']['tmp_name'];
				$carpetaDeDestino = $destino . $nuevafoto;
				$foto_de_perfil=$carpetaDeDestino;
				
				// Movemos el fichero de la carpeta temporal a la de perfiles
				move_uploaded_file($origen, $carpetaDeDestino);
				
				$i++;
				$variable[$i] = 'Foto';
				$valor[$i] = $carpetaDeDestino;
			}
		} else {
			$error = true;
		}
		$_SESSION['mod']['foto'] = $carpetaDeDestino;
	} else {
		$_SESSION['mod']['foto'] = $foto;
	}
	
	$_SESSION['mod']['nom'] = $nuevoNom;
	$_SESSION['mod']['mail'] = $nuevoMail;
	$_SESSION['mod']['fecha'] = $nuevaFecha;
	$_SESSION['mod']['ciudad'] = $nuevaCiudad;
	$_SESSION['mod']['pais'] = $nuevoPais;
	$_SESSION['mod']['sexo'] = $nuevoSexo;
	
	
	// Comprobamos que la contrasenya anterior es correcta
	if (!ComprobarLogin($_SESSION['usuario']['nombre'], $passAnterior)) {
		$_SESSION['error']['activado'] = true;
		$_SESSION['error']['descripcion'] = "Contraseña anterior incorrecta.";
		
	} else {
		if (!$error) {
			
			// Revisar esto
			$_SESSION['usuario']['nombre'] = $nuevoNom;
			$_SESSION['usuario']['correo'] = $nuevoMail;
			$_SESSION['usuario']['fecha'] = FormatearFechaBarras($nuevaFecha);
			$_SESSION['usuario']['ciudad'] = $nuevaCiudad;
			$_SESSION['usuario']['pais'] = CargarPais($nuevoPais);
			$_SESSION['usuario']['sexo'] = $nuevoSexo;
			$_SESSION['usuario']['foto'] = $carpetaDeDestino;
			
			
			if ($i >= 0) {
			// Borramos los datos a modificar de la sesion
			unset($_SESSION['mod']);
			
			// Enviamos los arrays para modificar los datos en la BD
			ActualizarUsuario($_SESSION['usuario']['id'], $variable, $valor);
			}
		}
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