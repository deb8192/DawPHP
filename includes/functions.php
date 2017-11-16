<?php
	require('admin/db.inc');
	
	function CargarListaPaises() {
		
		$conexion = conecta();
		$consulta = 'select * from paises';
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) { 
				echo '<option value="'.$fila->IdPais.'">'.$fila->NomPais.'</option>';
			}
		}
		$resultado->close();
		$conexion->close();
	}
	
	function CargarUltimasFotos() {
		
		/*$conexion = conecta();
		$consulta = 'select * from fotos order by FRegistro desc limit 0, 5';
		$resultado = ejecutaConsulta($conexion, $consulta);
		
		if ($resultado->num_rows > 0) {
			while($fila = $resultado->fetch_object()) { 
				echo '<option value="'.$fila->IdPais.'">'.$fila->NomPais.'</option>';
			}
		}
		$resultado->close();
		$conexion->close();
 
		<ul class="lista_fotos">
			<li>
				<h3><?php echo $fotos[1]['titulo']; ?></h3>
				<a href="detalle_foto.php?id=1" title="Ver foto1" tabindex="7"><img src="img/jackie.jpg" alt="Foto 1" width="200" height="150"/></a>
				<ul class="datos">
					<li><?php echo $fotos[1]['fecha']; ?></li>
					<li><?php echo $fotos[1]['pais']; ?></li>
				</ul>
			</li>
		</ul>*/
	}
?>