<?php
	require_once('admin/db.inc');
	
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
	function ComprobarLogin($usuario, $pass) {

		$conexion = conecta();
		$consulta = "select NomUsuario, Clave from usuarios where NomUsuario = '$usuario' and Clave = SHA1('$pass')";
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
		
		$tab = 6;
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
		
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) { 
				echo '<li><p> '.$fila->IdAlbum.' - '.$fila->Titulo.': '.$fila->Descripcion.' <a href="ver_album.php?id='.$fila->IdAlbum.'&titulo='.$fila->Titulo.'" >Ver álbum</a></p></li>';
			}
		}
		$resultado->close();
		$conexion->close();
	}
	
	function CargarAlbum($id_Album, $tit_Album) {
		
		$conexion = conecta();
		$consulta = 'select a.Titulo as ATitulo, IdFoto, Fichero, f.Titulo as FTitulo from fotos f inner join albumes a on IdAlbum = Album where Album = '.$id_Album;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		$tab = 4;
		$existe = false;
		if ($resultado->num_rows > 0) {
			$existe = true;
			
			echo '<h2>'.$tit_Album.'</h2> <ul class="lista_fotos">';
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
		
		$tab = 11;
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
			ContenidoNoExiste();
		}
		$resultado->close();
		$conexion->close();
	}
	
	function CargarNumerosSelect($principio, $fin, $seleccionado) {
		for ($i=$principio; $i<=$fin; $i++) {
			
			if ($i<10)
				echo '<option value="0'.$i.'"';
			else
				echo '<option value="'.$i.'"';
			
			if ($i == $seleccionado)
				echo' selected';
			
			echo '>'.$i.'</option>';
		}
	 }
	 /*function CargarMeses($seleccionado) {
		 $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto",
			"septiembre", "octubre", "noviembre", "diciembre");
			
			$long = count($meses);
			for ($i=0; $i<$long; $i++) {
				echo '<option value="'.($i+1).'"';
				
					if (($i+1) == $seleccionado)
					echo' selected';
				
				echo '>'.$meses[$i].'</option>';
			}
	 }*/
	 
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
?>