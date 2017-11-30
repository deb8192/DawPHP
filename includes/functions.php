<?php
	require_once('admin/db.inc');
	
	//Registro funciona, solo falta subir las fotos a la carpeta y cambiar el formato de fecha
	function CrearUsuarioEnBD($nombre, $password, $correo, $sexo, $fecha_nac, $ciudad, $paises, $foto){
		$sexo_usuario;
		if($sexo == 'Hombre')
			$sexo_usuario=1;
		else
			$sexo_usuario=2;
		
		$conexion = conecta();
		$consulta = "INSERT INTO usuarios (NomUsuario, Clave, Email, Sexo, FNacimiento, Ciudad, Pais, Foto) VALUES ('$nombre',sha1('$password'),'$correo','$sexo_usuario','$fecha_nac','$ciudad','$paises','$foto')";
		
		ejecutaConsulta($conexion, $consulta);
		
		
		$conexion->close();
	}
	function CargarYMostrarUsuarioRegistrado($NombreUsuario){
		
		$conexion = conecta();
		$consulta = "select NomUsuario, Email, Sexo, FNacimiento, Ciudad, NomPais, Foto from usuarios inner join paises on Pais = IdPais where NomUsuario = '$NombreUsuario'";
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			echo '<img src="'.$fila->Foto.'" alt="Foto perfil" width="200" height="150"/>';
		
			echo '<p>Nombre: '.$fila->NomUsuario.'</p>';
			echo '<p>Email: '.$fila->Email.'</p>';
			if($fila->Sexo==1)
				echo '<p>Sexo: Hombre</p>';
			else
				echo '<p>Sexo: Mujer</p>';
			echo '<p>Fecha: ';
			if (!empty($fila->FNacimiento))
				 echo $fila->FNacimiento.' </p>';
			echo '<p>Ciudad: '.$fila->Ciudad.'</p>';
			echo '<p>País:'.$fila->NomPais.'</p>';
		}
		$resultado->close();
		$conexion->close();
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
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
	
	
	// Funciones para el formulario de busqueda
	function BuscarFotos($titulo, $fecha, $pais) {
		
		if (($titulo != "") && ($fecha != "") && ($pais != "")) {
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where Titulo like "%'.$titulo.'%" and IdPais = '.$pais.' and Fecha = "'.$fecha.'"';
			
		} else if (($titulo != "") && ($fecha != "") && ($pais == "")) { // Titulo y fecha
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where Titulo like "%'.$titulo.'%" and Fecha = "'.$fecha.'"';
			
		} else if (($titulo != "") && ($pais != "") && ($fecha == "")) { // Titulo y pais
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where Titulo like "%'.$titulo.'%" and IdPais = '.$pais;
		
		} else if (($titulo == "") && ($fecha != "") && ($pais != "")) { // Fecha y pais
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where IdPais = '.$pais.' and Fecha = "'.$fecha.'"';
		
		} else if (($titulo != "") && ($fecha == "") && ($pais == "")) { // Solo titulo
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where Titulo like "%'.$titulo.'%"';
			 
		} else if (($titulo == "") && ($fecha != "") && ($pais == "")) { // Solo fecha
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where Fecha = "'.$fecha.'"';
			 
		} else if (($titulo == "") && ($fecha == "") && ($pais != "")) { // Solo pais
			$consulta = 'select IdFoto, Fichero, Titulo, DATE_FORMAT(Fecha, "%d/%m/%Y") as Fecha, NomPais from fotos inner join paises on IdPais = Pais
			 where IdPais = '.$pais;
		} else {
			// Si no hay datos, sacacmos el mensaje y salimos de la función
			echo '<p class="color_rojo">Introduce algunos datos para la búsqueda.</p>';
			return;
		}
		
		$conexion = conecta();
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
	}
	
	function CargarPaises($seleccionado) {
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
	
	function darseDeBaja($id) {
		$conexion = conecta();
		$consulta = "delete from usuarios where IdUsuario=".$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		$conexion->close();
		return $resultado;
	}
?>