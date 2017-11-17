<?php
    // Funciones de administración
	function compruebaErrorConexionMysql($mensaje, $conexion)
	{
		if ($conexion->connect_errno != 0)
		{
			echo $mensaje.' : '.$conexion->connect_error();
			exit();
		}
	}
	function compruebaErrorMysql($mensaje, $conexion)
	{
		if ($conexion->errno != 0)
		{
			echo $mensaje.' : '.$conexion->error();
			$conexion->close();
			exit();
		}
	}
	
	function conecta() {
		require_once('configBD.inc');
		
		$conexion = @new mysqli(dbServer, dbUser, dbPassword);
		compruebaErrorConexionMysql("Se ha producido un error al conectar con el servidor", $conexion);
        $conexion->set_charset("utf8");
		$conexion->select_db(dbDatabase);
		compruebaErrorMysql("Se ha producido un error al seleccionar la BBDD", $conexion);
		
		return $conexion;
	}	
	
    function ejecutaConsulta($conexion, $consulta)
	{
		$resultado = $conexion->query($consulta);
		compruebaErrorMysql("Se ha producido un error al ejecutar la consulta", $conexion);
		
		return $resultado;
	}
?>