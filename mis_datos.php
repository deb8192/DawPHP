<?php 
 // Título de la página, keywords y descripción
 $title = 'Registro';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de registro de una galería de fotos on-line.';

 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");

// Cargamos los datos del usuario
$usu = BuscarUsuario($_SESSION['usuario']['id']);
$copiaNom=$usu->NomUsuario;
$copiaMail=$usu->Email;
$copiaFecha=$usu->FNacimiento;
$copiaCiudad=$usu->Ciudad;
$copiaPais=$usu->Pais;
$copiaFoto = $usu->Foto;

if ($usu->Sexo == 2)
	$copiaSexo = "Mujer";
else
	$copiaSexo = "Hombre";


if (isset($_SESSION['mod'])) {
	$nom = $_SESSION['mod']['nom'];
	$mail = $_SESSION['mod']['mail'];
	$fecha = $_SESSION['mod']['fecha'];
	$ciudad = $_SESSION['mod']['ciudad'];
	$pais = $_SESSION['mod']['pais'];
	$sexo = $_SESSION['mod']['sexo'];
	//$foto = $_SESSION['mod']['foto'];
} else {
	$nom = $copiaNom;
	$mail = $copiaMail;
	$fecha = $copiaFecha;
	$ciudad = $copiaCiudad;
	$pais = $copiaPais;
	$sexo = $copiaSexo;
	//$foto = $copiaFoto;
}
$foto = $copiaFoto;

if (isset($_POST['modificar'])) {
	$_SESSION['error']['activado'] = false;
	
	$_SESSION['mod']['nom'] = $nom = $_POST['nombre'];
	$_SESSION['mod']['pass'] = $pass = $_POST['password2'];
	$_SESSION['mod']['rePas'] = $rePas = $_POST['repassword'];
	$_SESSION['mod']['mail'] = $mail = $_POST['correo'];
	$_SESSION['mod']['fecha'] = $fecha = $_POST['fecha_nac'];
	$_SESSION['mod']['ciudad'] = $ciudad = $_POST['ciudad'];
	$_SESSION['mod']['pais'] = $pais = $_POST['paises'];
	$_SESSION['mod']['sexo'] = $sexo = $_POST['sexo'];
	//$_SESSION['mod']['foto'] = $foto = $copiaFoto;
	$passAnterior = $_POST['password'];
	
	// Comprobamos que la contrasenya anterior es correcta
	if (!ComprobarLogin($_SESSION['usuario']['nombre'], $passAnterior)) {
		$_SESSION['error']['activado'] = true;
		$_SESSION['error']['descripcion'] = "Contraseña anterior incorrecta.";
		
	} else {
	
		$i = -1;		// Posición en el array
		$variable = [];	// Campos de la tabla usuarios
		$valor = [];	// Valores modificados
		$error = false;
		
		// Si los datos nuevos son distintos, se guardan en los arrays
		if ((!empty($pass)) && (!empty($rePas))) {
			if (ComprobarContrasenya($pass, $rePas)) {
				$i++;
				$variable[$i] = 'Clave';
				$valor[$i] = sha1($pass);
			} else {
				$error = true;
			}
		}
		
		$destino = "img/perfiles/";
		$foto2 = null;
		// Comprobamos si hay fichero
		if ($_FILES['fotoPerfil']['name'] != '') {
			
			// Comprobamos que el nombre es distinto al que tenemos
			$nomFich = $_FILES['fotoPerfil']['name'];
			if (strcmp ($copiaFoto , $destino.$nomFich ) !== 0) {
				
				// Se renombra si hay otro fichero con el mismo nombre
				if (ComprobarFicherosIguales($destino, $nomFich)) {
					$nomFich = RenombrarFichero($destino, $nomFich);
				}
				
				if ($_FILES['fotoPerfil']['error'] == 0) {
					$tipo = $_FILES['fotoPerfil']['type'];
					if ($tipo=="image/jpeg" || $tipo=="image/pjpeg" ||
						$tipo=='image/gif' || $tipo=="image/png") {
						
						$foto2 = $destino.$nomFich;
						$i++;
						$variable[$i] = 'Foto';
						$valor[$i] = $foto2;
					}
				} else {
					$_SESSION['error']['activado'] = true;
					$_SESSION['error']['descripcion'] = "Error al subir la imagen.";
					$error = true;
				}
			}
		}
		
		if (strcmp ($copiaSexo , $sexo ) !== 0) {
			$i++;
			$variable[$i] = 'Sexo';
			
			if ($sexo=='Mujer') {
				$valor[$i] = 2;
			} else {
				$valor[$i] = 1;
			}
		}
		
		if (strcmp ($copiaPais , $pais ) !== 0) {
			$i++;
			$variable[$i] = 'Pais';
			$valor[$i] = $pais;
		}
		
		if (strcmp ($copiaCiudad , $ciudad ) !== 0) {
			if (!empty($ciudad)) {
				$i++;
				$variable[$i] = 'Ciudad';
				$valor[$i] = $ciudad;
			} else {
				$_SESSION['error']['activado'] = true;
				$_SESSION['error']['descripcion'] = "Si modificas la Ciudad, no puedes dejarla vacía.";
				$error = true;
			}
		}
		
		if (strcmp ($copiaFecha , $fecha ) !== 0) {
			if (ComprobarFechaValida($fecha)) {
				$i++;
				$variable[$i] = 'FNacimiento';
				$valor[$i] = $fecha;
			} else {
				$error = true;
			}
		}
		
		if (strcmp ($copiaMail , $mail ) !== 0) {
			if (ComprobarMail($mail)) {
				$i++;
				$variable[$i] = 'Email';
				$valor[$i] = $mail;
			} else {
				$error = true;
			}
		}
		
		if (strcmp ($copiaNom , $nom ) !== 0) {
			if (ComprobarNombre($nom)) {
				$i++;
				$variable[$i] = 'NomUsuario';
				$valor[$i] = $nom;
			} else {
				$error = true;
			}
		}
		
		if (!$error) {
			if ($i >= 0) {
				
				$_SESSION['usuario']['nombre'] = $_SESSION['mod']['nom'];
				$_SESSION['usuario']['correo'] = $_SESSION['mod']['mail'];
				$_SESSION['usuario']['fecha'] = FormatearFechaBarras($_SESSION['mod']['fecha']);
				$_SESSION['usuario']['ciudad'] = $_SESSION['mod']['ciudad'];
				$_SESSION['usuario']['pais'] = CargarPais($_SESSION['mod']['pais']);
				$_SESSION['usuario']['sexo'] = $_SESSION['mod']['sexo'];
				
				if ($foto2 !== NULL) {
					//Borramos la foto antigua
					EliminarFotoPerfil($copiaFoto);
					
					// Sacamos el destino con el nombre de la foto
					$origen = $_FILES['fotoPerfil']['tmp_name'];
					
					// Movemos el fichero de la carpeta temporal a la de perfiles
					// El destino se lo hemos añadido a $foto al cogerlo del POST
					move_uploaded_file($origen, $foto2);
					$_SESSION['usuario']['foto'] = $foto2;
				}
				
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