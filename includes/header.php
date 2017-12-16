
<?php
	// Codigo comun entre los menus con las direcciones a otras paginas
	function menuUsuario() {
		echo '<li><a href="menu_usuario.php" tabindex="2">Perfil</a></li>
		<li><a href="darse_baja.php" tabindex="3">Darse de baja</a></li>
		<li><a href="mis_albumes.php" tabindex="4">Mis álbumes</a></li>
		<li><a href="crear_album.php" tabindex="5">Crear álbum</a></li>
		<li><a href="solicitar_album.php" tabindex="6">Solicitar álbum</a></li>
		<li><a href="anyadir_foto.php"  tabindex="7">Añadir foto</a></li>
		<li><a href="mis_datos.php"  tabindex="7">Mis datos</a></li>';
	}
	function menuUsuarioIrAlPerfil() {
		echo '<li><a href="menu_usuario.php" tabindex="2">Perfil</a></li>
			<li><a href="includes/logout.php" tabindex="3">Salir</a></li>';
	}
?>

<header>
	<a class="logo" href="index.php" title="PI" tabindex="1"><h1>PI</h1></a>
	
	<?php if (empty ($_SESSION['usuario']['nombre'])){ ?>
			
			<form id="inicio_sesion" action="includes/login.php" method="post">
			
			<?php
				// Si no hay cookies guardadas
				if ($existe == 0) {
			?>
				<a class="registro" href="registro.php" title="Registrarse" tabindex="6">Registrarse</a>
				<p class="barra">|</p>
				<label for="usuario">Usuario:</label>
				<input type="text" name="usuario" id="usuario" required="" tabindex="2"/>

				<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" required="" tabindex="3"/>
				
				<label for="recordar"> Recordarme</label>
				<input type="checkbox" name="recordar" id="recordar" value="1" tabindex="4"/>
				
				<input type="submit" name="enviar" value="Acceder" tabindex="5"/>
				
				<?php } else {
					echo '<p class="cookie_parrafo">Hola '.$_COOKIE["recordar_usuario"].', su última visita fue el '.$_COOKIE["last_visit"].'</p>
							<input type="submit" name="enviar" value="Acceder" tabindex="2"/>
							<input type="submit" name="borrar" value="Salir" tabindex="3"/>';
				}
				?>
			</form>
			
			<form id="inicio_sesion_desplegable" action="includes/login.php" method="post">
				<ul class="desplegable_is">
					<li><a>iniciar sesion</a>
						<ul class="opciones_is">
						
						<?php // Si no hay cookies guardadas
							if ($existe == 0) {
						?>
							<li><label for="usuario">Usuario:</label></li>
							<li><input type="text" name="usuario" id="usuario" required="" tabindex="2"/></li>
							<li><label for="password">Contraseña:</label></li>
							<li><input type="password" name="password" id="password" required="" tabindex="3"/></li>
							<li><label for="recordar"> Recordarme</label><input type="checkbox" name="recordar" id="recordar" value="1" tabindex="4"/></li>
							<li><input type="submit" name="enviar" value="Acceder" tabindex="5"/></li>
							<li><a href="registro.php" title="Registrarse" tabindex="6">Registrarse</a></li>
						
						<?php } else {
							echo '<li><p>Hola '.$_COOKIE["recordar_usuario"].', su última visita fue el '.$_COOKIE["last_visit"].'</p></li>
									<li><input type="submit" name="enviar" value="Acceder" tabindex="2"/></li>
									<li><input type="submit" name="borrar" value="Salir" tabindex="3"/></li>';
						}
						?>
						</ul>
					</li>
				</ul>
			</form>
	<?php
	} else { 
		?>
		
		<p id="bienvenida">Bienvenido/a <?php echo $_SESSION['usuario']['nombre']; ?> | <a class="salir" href="includes/logout.php" tabindex="8">Salir</a></p>
			
		<?php if ( (strpos($_SERVER['PHP_SELF'], 'solicitar_album') !== false) || 
			(strpos($_SERVER['PHP_SELF'], 'respuesta_album') !== false ) ||
			(strpos($_SERVER['PHP_SELF'], 'crear_album') !== false ) ||
			(strpos($_SERVER['PHP_SELF'], 'anyadir_foto') !== false ) ||
			(strpos($_SERVER['PHP_SELF'], 'mis_albumes') !== false ) ||
			(strpos($_SERVER['PHP_SELF'], 'ver_album') !== false ) ||
			(strpos($_SERVER['PHP_SELF'], 'detalle_foto') !== false ) ) { ?>
			
			<nav id="menu_usuario">
				<ul>
					<li><a href="menu_usuario.php" tabindex="2">Perfil</a></li>
				</ul>
			</nav>
			<nav id="menu_usuario_modificado">
				<ul>
					<?php menuUsuarioIrAlPerfil(); ?>
				</ul>
			</nav>
			<nav  id="menu_usuario_desplegable">
				<ul class="desplegable">
					<li><a>Opciones</a>
						<ul class="opciones">
							<?php menuUsuarioIrAlPerfil(); ?>
						</ul>
					</li>
				</ul>
			</nav>
		<?php } else { ?>
			<nav  id="menu_usuario">
			<ul>
				<?php menuUsuario(); ?>
			</ul>
		</nav>
		<nav  id="menu_usuario_modificado">
			<ul>
				<?php menuUsuario(); ?>
				<li><a href="includes/logout.php" tabindex="8">Salir</a></li>
			</ul>
		</nav>
		<nav  id="menu_usuario_desplegable">
			<ul class="desplegable">
				<li><a href="">Opciones</a>
					<ul class="opciones">
						<?php menuUsuario(); ?>
						<li><a href="includes/logout.php" tabindex="8">Salir</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	<?php }
	}
	// Guardamos la url
	$_SESSION['error']['urlIniciarSesion'] = substr($_SERVER['PHP_SELF'],4);
	
	// Borra el error de Iniciar sesión
	if (($_SESSION['error']['activado']) && isset($_SESSION['error']['url'])) {
		$url = $_SESSION['error']['urlIniciarSesion'];
		$urlError = $_SESSION['error']['url'];
		
		if (strcmp($url, $urlError) !== 0) {
			$_SESSION['error']['activado'] = false;
			$_SESSION['error']['urlIniciarSesion'] = NULL;
			$_SESSION['error']['url'] = NULL;
		}
	}
	
	// Borra los errores del registro si no están en la página de registro
	if (isset($_SESSION['error']['reg'])) {
		if (($_SESSION['error']['reg']) && (strcmp($_SESSION['error']['urlIniciarSesion'], 'registro.php') !== 0 )) {
			$_SESSION['error']['activado'] = false;
			$_SESSION['error']['reg'] = false;
		}
	}
	
	// Borra los errores de modificar datos si no están en la página de modificar datos
	if (isset($_SESSION['error']['mod'])) {
		if (($_SESSION['error']['mod']) && (strcmp($_SESSION['error']['urlIniciarSesion'], 'mis_datos.php') !== 0 )) {
			$_SESSION['error']['activado'] = false;
			$_SESSION['error']['mod'] = false;
		}
	}
	
	// Modal de error
	if ($_SESSION['error']['activado']) { 
		echo '<div class="caja_modal">
			<input id="cerrar-modal" name="modal" type="radio" /> 
			<label for="cerrar-modal"> <a href="includes/borrar_error_de_sesion.php"> X </a></label>
			<div id="modal">
				<p class="inicio_error">'.$_SESSION['error']['descripcion'].'</p>
			</div>
		</div>';
	} ?>
</header>