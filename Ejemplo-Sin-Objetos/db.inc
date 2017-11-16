<?php
    // Funciones de administración
	function compruebaErrorConexionMysql($mensaje)
	{
		if (mysqli_connect_errno() != 0)
		{
			echo $mensaje.' : '.mysqli_connect_error();
			exit();
		}
	}

	function compruebaErrorMysql($mensaje, $conexion)
	{
		if (mysqli_errno($conexion) != 0)
		{
			echo $mensaje.' : '.mysqli_error($conexion);
			mysqli_close($conexion);
			exit();
		}
	}
	
	function conecta() {
		require('configBD.inc');
		
		$conexion = @mysqli_connect(dbServer, dbUser, dbPassword);
		compruebaErrorConexionMysql("Se ha producido un error al conectar con el servidor");
        mysqli_set_charset($conexion,"utf8");

		mysqli_select_db($conexion, dbDatabase);
		compruebaErrorMysql("Se ha producido un error al seleccionar la BBDD", $conexion);
		
		return $conexion;
	}	
	
    function ejecutaConsulta($conexion, $consulta)
	{
		$resultado = mysqli_query($conexion, $consulta);
		compruebaErrorMysql("Se ha producido un error al ejecutar la consulta", $conexion);
		
		return $resultado;
	}
?>