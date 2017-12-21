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
		$link = $_SERVER['SERVER_NAME'];
		$description = 'Galería de fotos online.';
		$language = 'es';
		$categoria = 'Media';
		
		$conexion = conecta();
		$consulta = 'select IdFoto, Titulo, Descripcion, DATE_FORMAT(Fecha, "%d/%m/%Y") As Fecha, NomPais from fotos inner join paises on Pais = IdPais order by FRegistro desc limit 0, 5';
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
				
				// Imagen
				$nodo2 = CrearHijo($xml, $nodo, $nodo2, 'image');
				//CrearAtributo($xml, $nodo2, 'link', '2.0');
				
			} else {
				// Creamos la raiz atom y su atributo xmlns
				$raiz = CrearHijo($xml, $xml, $raiz, 'feed');
				CrearAtributo($xml, $raiz, 'xmlns', 'http://www.w3.org/2005/Atom');
				
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'title', $title);
				$nodo2 = CrearHijo($xml, $raiz, $nodo2, 'link');
				CrearAtributo($xml, $nodo2, 'href', $link);
				
				$nodo2 = CrearHijoDescripcion($xml, $raiz, $nodo2, 'id', $description);
				
				//<updated>2003-12-13T18:30:02Z</updated>
				/*<author>
					<name>John Doe</name>
				  </author>*/
			}
			
			while($fila = $resultado->fetch_object()) {
				$dir = 'detalle_foto.php?id='.$fila->IdFoto;
				
				// Elementos
				if ((strcmp ($tipo, 'rss') == 0)) {
					$nodo2 = CrearHijo($xml, $nodo, $nodo2, 'item');	// Elemento
					
					// URL de la imagen
					$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, 'link', 'http://localhost/P6/'.$dir);
					
					$tipoDesc = 'description';	// Para la descipción
					
				} else {
					$nodo2 = CrearHijo($xml, $raiz, $nodo2, 'entry');	// Elemento
					
					// URL de la imagen
					$subnodo = CrearHijo($xml, $nodo2, $subnodo, 'link');
					CrearAtributo($xml, $subnodo, 'href', 'http://localhost/P6/'.$dir);
					
					$tipoDesc = 'summary';	// Para la descipción
					
					/*<id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id>
    <updated>2003-12-13T18:30:02Z</updated>*/
				}
				
				// Título y descripción de la imagen
				$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, 'title', $fila->Titulo);
				$subnodo = CrearHijoDescripcion($xml, $nodo2, $subnodo, $tipoDesc, $fila->Descripcion);
				
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