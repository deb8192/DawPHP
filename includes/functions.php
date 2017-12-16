<?php
	require_once('admin/db.inc');
	
	// TO DO: Meterlas por todos los php
	function FormatearFechaBarras($fecha) {
		$date = new DateTime($fecha);
		$fechaNueva = $date->format('d/m/Y');
		return $fechaNueva;
	}
	
	function FormatearFechaGuiones($fecha) {
		$date = new DateTime($fecha);
		$fechaNueva = $date->format('Y-m-d');
		return $fechaNueva;
	}
	
	function CrearUsuarioEnBD($nombre, $password, $correo, $sexo, $fecha_nac, $ciudad, $paises, $foto){
		
		$sexo_usuario=2; // Iniciamos como mujer
		if ($sexo == 'Hombre')
			$sexo_usuario=1;
		
		$fecha = FormatearFechaBarras($fecha_nac);
		
		$conexion = conecta();
		$consulta = "INSERT INTO usuarios (NomUsuario, Clave, Email, Sexo, FNacimiento, Ciudad, Pais, Foto) VALUES ('$nombre',sha1('$password'),'$correo','$sexo_usuario','$fecha_nac','$ciudad','$paises','$foto')";
		ejecutaConsulta($conexion, $consulta);
		
		$consulta = "select IdUsuario from usuarios where NomUsuario='".$nombre."'";
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			$id = $fila->IdUsuario;
			$_SESSION['usuario']['id'] = $fila->IdUsuario;
			$_SESSION['usuario']['nombre'] = $nombre;
			$_SESSION['usuario']['foto'] = $foto;
			$_SESSION['usuario']['correo'] = $correo;
			$_SESSION['usuario']['sexo'] = $sexo;
			$_SESSION['usuario']['fecha'] = $fecha;
			$_SESSION['usuario']['ciudad'] = $ciudad;
			$_SESSION['usuario']['pais'] = CargarPais($_POST['paises']);
		} else {
			$id = -1;
		}
		$resultado->close();
		$conexion->close();
		
		if ($id >= 0) {
			// Le creamos su carpeta de albumes
			mkdir("img/albumes/".$id);
			
			header("Location: menu_usuario.php");
		} else {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "No se ha podido insertar el usuario.";
			header("Location:../".$_SESSION['error']['url']);
		}
	}
	
	function ActualizarUsuario($id, $variable, $valor) {
		
		// Obtenemos la cadena con los datos a modificar
		$cadena = '';
		for ($i=0; $i<count($variable); $i++) {
			$cadena = $cadena.$variable[$i].' = ';
			
			if ($variable[$i] == 'FNacimiento') {
				$cadena = $cadena.'"'.FormatearFechaGuiones($valor[$i]).'"';
				
			} else if (( $variable[$i] == 'Sexo') || ($variable[$i] == 'Pais')) {
				$cadena = $cadena.$valor[$i];
			} else {
				$cadena = $cadena.'"'.$valor[$i].'"';
			}
			
			if ((count($variable) > 1) && ($i < count($variable)-1)) {
				$cadena = $cadena.', ';
			}
		}
		$conexion = conecta();
		$consulta = "UPDATE usuarios SET ".$cadena." where IdUsuario = ".$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		$conexion->close();
		header("Location: menu_usuario.php");
	}
	
	function CargarListaPaises() {
		
		$conexion = conecta();
		$consulta = 'select IdPais, NomPais from paises';
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) { 
				echo '<option value="'.$fila->IdPais.'">'.$fila->NomPais.'</option>';
			}
		}
		$resultado->close();
		$conexion->close();
	}

	function ComprobarNombreUsuario($usuario) {

		$conexion = conecta();
		$consulta = "select NomUsuario from usuarios where NomUsuario = '$usuario'";
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$existe = false;
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			$existe = true;
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	
	function ComprobarLongitud($min, $max, $frase) {
		if( (strlen($frase) >= $min) && (strlen($frase) <= $max) )
			return true;
		else
			return false;
	}
	
	function ComprobarMayusMinusNumeros($pass) {
		$minus = "([a-z]+)";
		$mayus = "([A-Z]+)";
		$num = "([0-9]+)";
		
		if (ComprobarPatron($minus, $pass))
			if (ComprobarPatron($mayus, $pass))
				if (ComprobarPatron($num, $pass))
					return true;
		return false;
	}
	
	function ComprobarPatron($patron, $nombre) {
		
		if(preg_match($patron, $nombre))
			return true;
		else
			return false;
	}
	
	function ComprobarFecha($fecha) {
		
		$valores = explode('-', $fecha);
		$dia = $valores[2];
		$mes = $valores[1];
		$anyo = $valores[0];
		
		if (count($valores) == 3 && checkdate($mes, $dia, $anyo)) {
			unset($valores);
			$hoy = getdate();
			$anyoActual = $hoy['year'];
			$mesActual = $hoy['mon'];
			$diaActual = $hoy['mday'];
			if ($anyo == $anyoActual) {
				if ($mes < $mesActual) {
					return true;
				} else if ($mes == $mesActual) {
					if ($dia <= $diaActual) {
						return true;
					}
				}
			} else if ($anyo < $anyoActual) {
				return true;
			}
		}
		return false;
	}
	
	function ComprobarNombre($nombre) {
		$patronNom = "/^([a-zA-Z0-9]{3,15})$/";
		
		if (ComprobarNombreUsuario($nombre)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "Usuario no disponible.";
			return false;
			
			// Comprobar longitud del nombre
		} else if (!ComprobarLongitud(3, 15, $nombre)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "El tamaño del nombre debe ser de 3 a 15 caracteres.";
			return false;
			
			// Comprobar caracteres del nombre
		} else if (!ComprobarPatron($patronNom, $nombre)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "El nombre sólo debe contener letras y números.";
			return false;
		}
		return true;
	}
	
	function ComprobarContrasenya($pass, $repassword) {
		$patronPass = "/^([a-zA-Z0-9_]{6,15})$/";
		
		// Comprobar longitud contrasenya
		if (!ComprobarLongitud(6, 15, $pass)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "El tamaño de la contraseña debe ser de 6 a 15 caracteres.";
			return false;
			
			// Comprobar caracteres de la contrasenya
		} else if (!ComprobarPatron($patronPass, $pass)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "La contraseña sólo debe contener letras y números.";
			return false;
			
			// Comprobar mayus, minus y numero contrasenya
		} else if (!ComprobarMayusMinusNumeros($pass)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "La contraseña debe tener un nº, una letra minúscula y otra mayúscula.";
			return false;
			
			// Comparar contrasenya con repetir contrasenya
		} if (strcmp ($repassword, $pass) !== 0) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "Las contraseñas no coinciden.";
			return false;
		}
		return true;
	}
	
	function ComprobarMail($mail) {
		$patronMail = "/@([\w]{2,4})\./";
		
		if (!ComprobarPatron($patronMail, $mail)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "Dominio principal de correo no válido. De 2 a 4 caracteres detrás del @.";
			return false;
		}
		return true;
	}
	
	function ComprobarFechaValida($fecha) {
		if (!ComprobarFecha($fecha)) {
			$_SESSION['error']['activado'] = true;
			$_SESSION['error']['descripcion'] = "Fecha no válida.";
			return false;
		}
		return true;
	}
	
	function ComprobarLogin($usuario, $pass) {

		$conexion = conecta();
		$consulta = "select NomUsuario from usuarios where NomUsuario = '$usuario' and Clave = SHA1('$pass')";
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$existe = false;
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			$existe = true;
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	
	function CargarArrayPaises() {
		
		$conexion = conecta();
		$consulta = 'select NomPais from paises order by IdPais';
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$paises = array();
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) {
				array_push ( $paises , $fila->NomPais );
			}
		}
		$resultado->close();
		$conexion->close();
		return $paises;
	}
	
	function CargarPais($id) {
		
		$conexion = conecta();
		$consulta = 'select NomPais from paises where IdPais = '.$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			return $fila->NomPais;
		}
		$resultado->close();
		$conexion->close();
		return "";
	}
	
	function CargarTituloAlbum($id) {
		
		$conexion = conecta();
		$consulta = 'select Titulo from albumes where IdAlbum = '.$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			return $fila->Titulo;
		}
		$resultado->close();
		$conexion->close();
		return "";
	}
	
	function CargarListaAlbumesPorUsuario($idUsuario) {
		
		$conexion = conecta();
		$consulta = 'select IdAlbum, Titulo from albumes where Usuario = '.$idUsuario;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) { 
				echo '<option value="'.$fila->IdAlbum.'">'.$fila->Titulo.'</option>';
			}
		}
		$resultado->close();
		$conexion->close();
	}
	
	function CargarUltimasFotos() {
		
		$conexion = conecta();
		$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") As Fecha, NomPais from fotos inner join paises on Pais = IdPais order by FRegistro desc limit 0, 5';
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$tab = 10;
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) {
				
				echo '<ul class="lista_fotos">
					<li>
						<h3>'.$fila->Titulo.'</h3>
						<a href="detalle_foto.php?id='.$fila->IdFoto.'" title="Ver '.$fila->Titulo.'" tabindex="'.$tab.'"><img src="'.$fila->Fichero.'" alt="'.$fila->Titulo.'" width="200" height="150"/></a>
						<ul class="datos">
							<li>'.$fila->Fecha.'</li>
							<li>'.$fila->NomPais.'</li>
						</ul>
					</li>
				</ul>';
				$tab++;
			}
		}
		$resultado->close();
		$conexion->close();
	}
	
	function CargarDetalleFoto($id) {
		
		// Si el id no es numerico, salimos de la funcion
		if (!is_numeric($id))
			return false;
		
		$conexion = conecta();
		$consulta = 'select Fichero, f.Titulo as FTitulo, DATE_FORMAT(f.Fecha, "%d/%m/%Y") as FFecha, NomPais, a.Titulo as ATitulo, NomUsuario from fotos f inner join paises on Pais = IdPais inner join albumes a on Album = IdAlbum inner join usuarios on Usuario = IdUsuario where IdFoto = '.$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$existe = false;
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			$existe = true;
			
			echo '<h2>'.$fila->FTitulo.'</h2>
			<img src="'.$fila->Fichero.'" alt='.$fila->FTitulo.'" width="400" height="300"/>
			<aside>
				<h3>Detalles</h3>
				<p>Fecha: '.$fila->FFecha.'</p>
				<p>País: '.$fila->NomPais.'</p>
				<p>Álbum: '.$fila->ATitulo.'</p>
				<p>Usuario: '.$fila->NomUsuario.'</p>
			</aside>';
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	function MostrarFotoSeleccionada(){
		$conexion = conecta();
		$contador = 1;
		$elegida = rand(1, 10);
		$i=0;
		$resultado = '';
		$directorio = './Fotos-seleccionadas/Selecciones.txt';
				
		if(!file_exists($directorio)){
			ContenidoNoExiste();
			
		} else {
			$archivo = fopen($directorio, 'r');
			while($contador<$elegida){
				$contador++;
				while($i < 3){
					$buffer = utf8_encode(fgets($archivo));
					$i++;
				} 
				$i=0;
			}
			while($i < 3){
				$buffer = utf8_encode(fgets($archivo));
				switch ($i)	{
					case 0:{
						$consulta='select Fichero, f.Titulo as FTitulo, DATE_FORMAT(f.Fecha, "%d/%m/%Y") as FFecha, NomPais, a.Titulo as ATitulo, NomUsuario from fotos f inner join paises on Pais = IdPais inner join albumes a on Album = IdAlbum inner join usuarios on Usuario = IdUsuario where IdFoto = '.$buffer;
						$resultado = ejecutaConsulta($conexion, $consulta);
						$fila = $resultado->fetch_object();
						echo '<h2>'.$fila->FTitulo.'</h2>
							<img src="'.$fila->Fichero.'" alt='.$fila->FTitulo.'" width="400" height="300"/>
							<aside>
								<h3>Detalles</h3>
								<p>Fecha: '.$fila->FFecha.'</p>
								<p>País: '.$fila->NomPais.'</p>
								<p>Álbum: '.$fila->ATitulo.'</p>
								<p>Usuario: '.$fila->NomUsuario.'</p>
							</aside>';
						break;
					}
					case 1:{
						echo '<p>Nombre del seleccionador: ' .$buffer.'</p>';
						break;
					}
					case 2:{
						echo '<p>Motivo de la selección: ' .$buffer.'</p>';
						break;
					}
					
				}
				$i++;				
			}
			fclose($archivo);
			$resultado->close();
			$conexion->close();
		}
	}
	function CrearAlbum($titulo_album_creado, $descripcion_album, $date, $pais, $usuario) {
		$conexion = conecta();
		$consulta = "INSERT INTO albumes (Titulo, Descripcion, Fecha, Pais, Usuario) VALUES ('$titulo_album_creado', '$descripcion_album', '$date', '$pais', '$usuario')";
		ejecutaConsulta($conexion, $consulta);
		$conexion->close();
	}
	
	function SubirFoto($titulo, $descripcion, $fecha, $pais, $album, $fichero) {
		$conexion = conecta();
		$consulta = "INSERT INTO fotos (Titulo, Descripcion, Fecha, Pais, Album, Fichero) VALUES ('$titulo', '$descripcion', '$fecha', '$pais', '$album','$fichero')";
		ejecutaConsulta($conexion, $consulta);
		$conexion->close();
	}
	
	function GuardarSolicitud($album, $nombre, $titulo, $descripcion, $email, $direccion, $color_portada, $copias, $resolucion, $fecha, $color_fotos, $coste) {
		$conexion = conecta();
		$consulta = "INSERT INTO solicitudes (Album, Nombre, Titulo, Descripcion, Email, Direccion, Color, Copias, Resolucion, Fecha, IColor, Coste) VALUES ('$album', '$nombre', '$titulo', '$descripcion', '$email', '$direccion', '$color_portada', '$copias', '$resolucion', '$fecha', '$color_fotos', '$coste')";
		ejecutaConsulta($conexion, $consulta);
		$conexion->close();
	}
	
	function CargarAlbumes($idUsuario) {
		
		$conexion = conecta();
		$consulta = 'select IdAlbum, Titulo, Descripcion from albumes where Usuario = '.$idUsuario;
		$resultado = ejecutaConsulta($conexion, $consulta);
		$existe = false;
		
		// Si existe el usuario, sacamos todos los albumes
		if ($resultado->num_rows > 0) {
			$tab=9;
			while($fila = $resultado->fetch_object()){
				$consulta = 'select Fichero from fotos f inner join albumes a on a.IdAlbum = f.Album where a.IdAlbum = '.$fila->IdAlbum;
				$resultado2 = ejecutaConsulta($conexion, $consulta);
				
				echo '<li class="lista_de_albumes">';
				echo '<a href="ver_album.php?id='.$fila->IdAlbum.'" tabindex="'.$tab.'">';
				$tab++;
				if ($resultado2->num_rows > 0){
					$fila2 = $resultado2->fetch_object();
					echo '<img src="'.$fila2->Fichero.'" alt="'.$fila->Titulo.'" width="200" height="150"/>';
				} else {
					echo 'Sin foto';
				}
				echo '</a><p> Título: '.$fila->Titulo.' </br> Descripión: '.$fila->Descripcion.' </br> <a href="ver_album.php?id='.$fila->IdAlbum.'" tabindex="'.$tab.'">Ver álbum</a></p></li>';
				$tab++;
			}
			$resultado2->close();
			$existe = true;
		} else {
			noHayContenido();
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	
	function CargarAlbum($id_Album) {
		
		// Si el id no es numerico, salimos de la funcion
		if (!is_numeric($id_Album))
			return false;
		
		$existe = false;
		$tit_Album = CargarTituloAlbum($id_Album);
		
		if ($tit_Album != "") {
			$existe = true;
			echo '<h2>'.$tit_Album.'</h2>';
		} else {
			// Si no existe el album, salimos de la funcion
			return $existe;
		}
		
		$conexion = conecta();
		$consulta = 'select a.Titulo as ATitulo, IdFoto, Fichero, f.Titulo as FTitulo from fotos f inner join albumes a on IdAlbum = Album where Album = '.$id_Album;
		$resultado = ejecutaConsulta($conexion, $consulta);
		$tab = 9;
		if ($resultado->num_rows > 0) {
			
			echo '<ul class="lista_fotos">';
			while($fila = $resultado->fetch_object()) {
					echo '<li>
						<h3>'.$fila->FTitulo.'</h3>
						<a href="detalle_foto.php?id='.$fila->IdFoto.'" title="Ver '.$fila->FTitulo.'" tabindex="'.$tab.'"><img src="'.$fila->Fichero.'" alt="'.$fila->FTitulo.'" width="200" height="150"/></a>
					</li>';
			}
			echo '</ul>';
		} else {
			albumSinContenido();
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	
	function BuscarUsuario($idUsuario){
		$conexion = conecta();
		$consulta = 'select NomUsuario, Clave, Email, Sexo, FNacimiento, Ciudad, Pais, Foto from usuarios where IdUsuario = '.$idUsuario;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if($resultado->num_rows>0) {
			$fila = $resultado->fetch_object();
		}
		$resultado->close();
		$conexion->close();
		return $fila;
	}
	
	// Funciones para el formulario de busqueda
	function BuscarFotos($titulo, $fecha, $pais) {
		
		$i = -1;
		$variable = [];
		if ($titulo != "") {	// Buscar por título
			$i++;
			$variable[$i] = 'Titulo like "%'.$titulo.'%"';
		}
		if ($pais != "") {		// Buscar por país
			$i++;
			$variable[$i] = 'IdPais = '.$pais;
		}
		if ($fecha != "") {		// Buscar por fecha
			$i++;
			$variable[$i] = 'Fecha = "'.$fecha.'"';
		}
		
		if ($i >= 0) {
			// Obtenemos la cadena con los datos a consultar
			$cadena = '';
			for ($i=0; $i<count($variable); $i++) {
				$cadena = $cadena.$variable[$i];
				if ((count($variable) > 1) && ($i < count($variable)-1)) {
					$cadena = $cadena.' and ';
				}
			}
			$conexion = conecta();
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais where '.$cadena;
			$resultado = ejecutaConsulta($conexion, $consulta);
			
			$tab = 13;
			if ($resultado->num_rows > 0) {
				while($fila = $resultado->fetch_object()) {
					
					echo '<ul class="lista_fotos">
						<li>
							<h3>'.$fila->Titulo.'</h3>
							<a href="detalle_foto.php?id='.$fila->IdFoto.'" title="Ver '.$fila->Titulo.'" tabindex="'.$tab.'"><img src="'.$fila->Fichero.'" alt="'.$fila->Titulo.'" width="200" height="150"/></a>
							<ul class="datos">
								<li>'.$fila->Fecha.'</li>
								<li>'.$fila->NomPais.'</li>
							</ul>
						</li>
					</ul>';
					$tab++;
				}
			} else {
				echo '<p>No hay resultados.</p>';
			}
			$resultado->close();
			$conexion->close();
		} else {
			// Si no hay datos, sacacmos el mensaje y salimos de la función
			echo '<p class="color_rojo">Introduce algunos datos para la búsqueda.</p>';
		}
	}
	
	function CargarPaisSeleccionado($seleccionado) {
		$paises = CargarArrayPaises();
		for ($i=0; $i<(count($paises)); $i++) {
			echo '<option value="'.($i+1).'"';
				if (($i+1) == $seleccionado)
				echo' selected';
			echo '>'.$paises[$i].'</option>';
		}
	}
	 
	function ContenidoNoExiste() {
		echo '<h2>404 Error</h2><p>El contenido que intentas buscar no existe.</p>';
	}
	
	function ContenidoNoDisponible() {
		echo '<h2>CONTENIDO NO DISPONIBLE</h2><p>Debes iniciar sesión para poder ver este contenido.</p>';
	}
	
	function albumSinContenido() {
		echo '<p>Este álbum no tiene contenido.</p>';
	}
	
	function noHayContenido() {
		echo '<p>Todavía no tienes álbumes creados.</p>';
	}
	
	function RenombrarFichero($nomdir, $nomFich) {
		$contador = 0;
		$auxNom = $nomFich;
		while (ComprobarFicherosIguales($nomdir, $auxNom)) {
			$auxNom = $contador.$nomFich;
			$contador++;
		}
		return $auxNom;
	}
	
	function ComprobarFicherosIguales($nomdir, $fichero2) {
		$dir = opendir($nomdir);
		while(($fichero1 = readdir($dir)) != FALSE) {
			if (strcmp($fichero1, $fichero2) == 0) {
				closedir($dir);
				return true;
			}
		} 
		closedir($dir);
		return false;
	}
	
	function EliminarFotoPerfil($foto) {
		// Comprobamos que no sea la foto por defecto
		if ($foto !== 'img/perfiles/foto.jpg')
			unlink($foto);
	}
	
	function darseDeBaja($id) {
		$conexion = conecta();
		$consulta = "delete from usuarios where IdUsuario=".$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		$conexion->close();
		return $resultado;
	}
?>