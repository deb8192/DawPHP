<?php
	require_once('../admin/db.inc');

	function CrearHijo($xml, $padre, $hijo, $tit) {
		$hijo = $xml->createElement($tit);		// Creamos el hijo
		$hijo = $padre->appendChild($hijo);		// Lo añadimos al padre
		return $hijo;
	}

	function CrearHijoDescripcion($xml, $padre, $hijo, $tit, $desc) {
		$hijo = $xml->createElement($tit, $desc);	// Creamos el hijo con descripción
		$hijo = $padre->appendChild($hijo);			// Lo añadimos al padre
		return $hijo;
	}
	
	function CrearAtributo($xml, $padre, $desc, $valor) {
		$atributo = $xml->createAttribute($desc);				// Creamos el atributo
		$atributo->appendChild($xml->createTextNode($valor));	// Le damos valor
		$padre->appendChild($atributo);							// Lo añadimos al padre
	}
	
	function CargarUltimasFotos($tipo) {
		
		// Datos del canal
		$title = 'Feed de imágenes de "PI - Pictures and images"';
		$link = 'http://'.$_SERVER['SERVER_NAME'].'/P6';
		$description = 'Galería de fotos online.';
		$language = 'es';
		$categoria = 'Media';
		$imagen = $link.'/img/pi.png';
		
		// Formato de la fecha para la select
		if ((strcmp ($tipo, 'rss') == 0)) {
			$formato = '"%a, %d %b %Y %T +0100"';	// Fri, 15 Dec 2017 11:58:54 +0100
		} else {
			$formato = '"%Y-%m-%dT%T+01:00"';		// 2017-12-15T11:58:54+01:00
		}
		
		$conexion = conecta();
		$consulta = 'select IdFoto, f.Titulo as Titulo, f.Descripcion as Descripcion, NomPais, NomUsuario, DATE_FORMAT(f.FRegistro, '.$formato.') As Fecha from usuarios inner join albumes inner join fotos f inner join paises p on f.Pais = IdPais where Usuario = IdUsuario and IdAlbum = Album order by f.FRegistro desc limit 0, 5';
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			$xml = new DomDocument('1.0', 'UTF-8');
			
			if ((strcmp ($tipo, 'rss') == 0)) {
				// Creamos la raiz rss y su atributo version
				$raiz = CrearHijo($xml, $xml, $raiz, 'rss');
				CrearAtributo($xml, $raiz, 'version', '2.0');

				$nodo = CrearHijo($xml, $raiz, $nodo, 'channel');	//Creamos el hijo channel
				
				// Sub-nodos hijos de channel
				$nodo2 = CrearHijoDescripcion($xml, $nodo, $nodo2, 'title', $title);
				$nodo2 = CrearHijoDescripcion($xml, $nodo, $nodo2, 'link', $link);
				$nodo2 = CrearHijoDescripcion($xml, $nodo, $nodo2, 'description', $description);
				
				// Opcionales
				$nodo2 = CrearHijoDescripcion($xml, $nodo, $nodo2, 'language', $language);
				$nodo2 = CrearHijoDescripcion($xml, $nodo, $nodo2, 'category', $categoria);
				
				// Logo de la web
				$nodo2 = CrearHijo($xml, $nodo, $nodo2, 'image');
				$nodo3 = CrearHijoDescripcion($xml, $nodo2, $nodo3, 'link', $link);
				$nodo3 = CrearHijoDescripcion($xml, $nodo2, $nodo3, 'title', $title);
				$nodo3 = CrearHijoDescripcion($xml, $nodo2, $nodo3, 'url', $imagen);
				$nodo3 = CrearHijoDescripcion($xml, $nodo2, $nodo3, 'description', $description);
				$nodo3 = CrearHijoDescripcion($xml, $nodo2, $nodo3, 'height', '32');
				$nodo3 = CrearHijoDescripcion($xml, $nodo2, $nodo3, 'width', '96');
				
				
			} else {
				// Creamos la raiz atom y su atributo xmlns
				$raiz = CrearHijo($xml, $xml, $raiz, 'feed');
				CrearAtributo($xml, $raiz, 'xmlns', 'http://www.w3.org/2005/Atom');
				
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'title', $title);
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'id', $link);
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'updated', date(DATE_ATOM));
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'subtitle', $description);
				
				// Logo de la web
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'logo', $imagen);
			}
			
			while($fila = $resultado->fetch_object()) {
				$dir = '/detalle_foto.php?id='.$fila->IdFoto;
				
				// Elementos
				if ((strcmp ($tipo, 'rss') == 0)) {
					$nodo2 = CrearHijo($xml, $nodo, $nodo2, 'item');	// Elemento
					
					$id = 'guid';				// Para el id único
					$tipoDesc = 'description';	// Para la descipción
					$tipoPubli = 'pubDate'; 	// Para la fecha de publicación
					
					// URL de la imagen
					$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, 'link', $link.$dir);
				
				} else {
					$nodo2 = CrearHijo($xml, $raiz, $nodo2, 'entry');	// Elemento
					
					$id = 'id';				// Para el id único
					$tipoDesc = 'summary';	// Para la descipción
					$tipoPubli = 'updated'; // Para la fecha de publicación
					
					$subnodo = CrearHijo($xml, $nodo2, $subnodo, 'author');
					$subnodo2 = CrearHijoDescripcion($xml, $subnodo, $subnodo2, 'name', $fila->NomUsuario);
					
					// URL de la imagen
					$subnodo = CrearHijo($xml, $nodo2, $subnodo, 'link');
					CrearAtributo($xml, $subnodo, 'href', $link.$dir);
				}
				
				// Título y descripción de la imagen
				$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, 'title', $fila->Titulo);
				$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, $tipoDesc, $fila->Descripcion.' País: '.$fila->NomPais);
				$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, $tipoPubli, $fila->Fecha);
				$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, $id, $link.$dir);
			}
		}
		$resultado->close();
		$conexion->close();
		
		// Guardar en un archivo
		$xml->formatOutput = true;
		$xml->saveXML();
		if ((strcmp ($tipo, 'rss') == 0)) {
			$xml->save('rss.xml');
			header("Location: rss.xml");
		} else {
			$xml->save('atom.xml');
			header("Location: atom.xml");
		}
	}
		
	if (isset($_GET['tipo'])) {
		$tipo = $_GET['tipo'];
		
		if ((strcmp ($tipo, 'rss') == 0) || (strcmp ($tipo, 'atom') == 0) ) {
			CargarUltimasFotos($tipo);
		}
	} else {
		echo "No existe ese tipo de contenido.";
	}
?>