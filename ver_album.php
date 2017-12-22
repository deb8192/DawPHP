<?php 
 // Titulo de la pagina, keywords y descripcion
 $title = 'Mis albumes';
 $keywords = 'pictures, images, imagen, imagenes, fotos, foto, album, albumes';
 $description = 'Pagina con todos los albumes de un usuario de la galeria on-line.';
 
 // Declaracion de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");

	// Devuelve el titulo y el num de paginas
	function CargarTituloNumPag($id) {
		
		$conexion = conecta();
		$consulta = 'select a.Titulo as ATitulo from fotos f inner join albumes a on IdAlbum = Album where Album = '.$id;
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			$fila = $resultado->fetch_object();
			
			$datos = array(
				"tit" => $fila->ATitulo,
				"numPag" => $resultado->num_rows,
			);
			$resultado->close();
			$conexion->close();
			return $datos;
		}
		$resultado->close();
		$conexion->close();
		return NULL;
	}

// Contiene paginacion
	function CargarAlbum($id_Album, $pagina) {
		
		$registros = 3;	// Fotos a mostrar por pagina
		
		// Si el id no es numerico, salimos de la funcion
		if (!is_numeric($id_Album))
			return false;
		
		// Si la pagina no es numerica, salimos de la funcion
		if (!is_numeric($pagina))
			return false;
		
		if ($pagina <= 0)
			return false;
		
		$existe = false;
		$datos = CargarTituloNumPag($id_Album);
		
		if ($datos != NULL) {
			
			$total_registros = $datos['numPag'];
			$total_paginas = ceil($total_registros / $registros); // ceil redondea el num de paginas
			
			if ($pagina > $total_paginas) {
				// Si el num de pagina es mayor a las paginas totales, salimos de la funcion
				return $existe;
			} else {
				$existe = true;
				echo '<h2>'.$datos['tit'].'</h2>';
			}
		} else {
			// Si no existe el album, salimos de la funcion
			return $existe;
		}
		
		// Calculamos el limite para la select
		if ($pagina == 1) {
			$inicio = 0;
		} else {
			$inicio = ($pagina - 1) * $registros;
		}
		
		$conexion = conecta();
		$consulta = "select a.Titulo as ATitulo, IdFoto, Fichero, f.Titulo as FTitulo from fotos f inner join albumes a on IdAlbum = Album where Album = ".$id_Album." order by a.Titulo asc limit $inicio, $registros";
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
			echo '<div class="paginacion">';
			
				if ($pagina > 1) {
					echo "<a href='ver_album.php?id=".$id_Album."&pagina=".($pagina-1)."' class='p_left'>< Anterior</a>";
				} else {
					echo "<a href='#' class='p_left'>< Anterior</a>";
				}
				
				echo "<a href='ver_album.php?id=".$id_Album."&pagina=1' '>Primera</a> - 
					<a href='ver_album.php?id=".$id_Album."&pagina=".$total_paginas."' >Última</a>";
				
				if (($pagina + 1)<=$total_paginas) {
					echo "<a href='ver_album.php?id=".$id_Album."&pagina=".($pagina+1)."' class='p_right'>Siguiente ></a>";
				} else {
					echo "<a href='#' class='p_right'>Siguiente ></a>";
				}
				
			echo '</div>';
			
		} else {
			albumSinContenido();
		}
		$resultado->close();
		$conexion->close();
		return $existe;
	}
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php");?>
	
	<section id="detalle_imagen">
		<?php
			if (($_GET['id'] != null) && ($_GET['pagina'] != null)) {
				if (!CargarAlbum($_GET['id'], $_GET['pagina'])) {
					ContenidoNoExiste();
				}
			} else {
				ContenidoNoExiste();
			}
		?>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>