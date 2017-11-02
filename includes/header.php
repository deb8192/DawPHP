<header>
	<a class="logo" href="index.php" tabindex="1"><h1>PI</h1></a>
	
	<?php if (empty ($_SESSION['usuario'])){ 
		if(empty ($_COOKIE['recordar_usuario']) || empty ($_COOKIE['recordar_password'])){?>

			<form id="inicio_sesion" action="includes/login.php" method="post">
				<label for="usuario">Usuario:</label>
				<input type="text" name="usuario" id="usuario" required="" tabindex="3"/>

				<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" required="" tabindex="4"/>
				
				<label for="recordarme"> Recordarme</label>
				<input type="checkbox" name="recordar" id="recordar" value="1" tabindex="5"/>

				<input type="submit" name="enviar" value="Enviar"/>
			</form>
			<p class="barra">|</p>
			<a class="registro" href="registro.php" title="Registrarse" tabindex="2">Registrarse</a>
			<form id="inicio_sesion_desplegable" action="includes/login.php" method="post">
				<ul class="desplegable_is">
					<li><a>iniciar sesion</a>
						<ul class="opciones_is">
						<li><label for="usuario">Usuario:</label></li>
						<li><input type="text" name="usuario" id="usuario" required="" tabindex="2"/></li>
						<li><label for="password">Contraseña:</label></li>
						<li><input type="password" name="password" id="password" required="" tabindex="3"/></li>
						<li><label for="recordarme"> Recordarme</label><input type="checkbox" name="recordar" id="recordar" value="1" tabindex="4"/></li>
						<li><input type="submit" name="enviar" value="Enviar"/></li>
						<li><a href="registro.php" title="Registrarse" tabindex="5">Registrarse</a></li>
						
						</ul>
					</li>
				</ul>
			</form>
		<?php }
		//No funciona el else
		else { ?>
			<p> Hola <?php echo $_COOKIE['recordar_usuario']; ?>, tu última visita fue el 
			<?php echo $_COOKIE['last_visit']; ?></p>
		<?php}
		
		if (!empty($_SESSION['error'])) { ?>
			<div class="caja_modal">
				<input id="cerrar-modal" name="modal" type="radio" /> 
				<label for="cerrar-modal"> <a href="includes/borrar_error_de_sesion.php"> X </a></label>
				<div id="modal">
					<p class="inicio_error"><?php echo $_SESSION['error']; ?></p>
				</div>
			</div>
	<?php }
	} else { ?>
	
		<p id="bienvenida">Bienvenido/a <?php echo $_SESSION['usuario']; ?> | <a class="salir" href="includes/logout.php" tabindex="2">Salir</a></p>
			
		<?php if ((strpos($_SERVER['PHP_SELF'], 'solicitar_album') !== false) || 
			(strpos($_SERVER['PHP_SELF'], 'respuesta_album') !== false ) ||
			(strpos($_SERVER['PHP_SELF'], 'crear_album') !== false )) { ?>
			
			<nav id="menu_usuario">
				<ul>
					<li><a href="menu_usuario.php" tabindex="3">Perfil</a></li>
				</ul>
			</nav>
			<nav id="menu_usuario_modificado">
				<ul>
					<li><a href="menu_usuario.php" tabindex="2">Perfil</a></li>
					<li><a href="includes/logout.php" tabindex="3">Salir</a></li>
				</ul>
			</nav>
			<nav  id="menu_usuario_desplegable">
				<ul class="desplegable">
					<li><a>Opciones</a>
						<ul class="opciones">
							<li><a href="menu_usuario.php" tabindex="2">Ir a mi Perfil</a></li>
							<li><a href="includes/logout.php" tabindex="3">Salir</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		<?php } else { ?>
			<nav  id="menu_usuario">
			<ul>
				<li><a href="menu_usuario.php" tabindex="3">Perfil</a></li>
				<li><a href="" tabindex="4">Darse de baja</a></li>
				<li><a href="" tabindex="5">Mis álbumes</a></li>
				<li><a href="crear_album.php" tabindex="6">Crear álbum</a></li>
				<li><a href="solicitar_album.php" tabindex="7">Solicitar álbum</a></li>
		</nav>
		<nav  id="menu_usuario_modificado">
			<ul>
				<li><a href="menu_usuario.php" tabindex="3">Perfil</a></li>
				<li><a href="" tabindex="4">Darse de baja</a></li>
				<li><a href="" tabindex="5">Mis álbumes</a></li>
				<li><a href="crear_album.php" tabindex="6">Crear álbum</a></li>
				<li><a href="solicitar_album.php" tabindex="7">Solicitar álbum</a></li>
				<li><a href="includes/logout.php" tabindex="8">Salir</a></li>
			</ul>
		</nav>
		<nav  id="menu_usuario_desplegable">
			<ul class="desplegable">
				<li><a href="">Opciones</a>
					<ul class="opciones">
						<li><a href="menu_usuario.php" tabindex="3">Perfil</a></li>
						<li><a href="" tabindex="4">Darse de baja</a></li>
						<li><a href="" tabindex="5">Mis álbumes</a></li>
						<li><a href="crear_album.php" tabindex="6">Crear álbum</a></li>
						<li><a href="solicitar_album.php" tabindex="7">Solicitar álbum</a></li>
						<li><a href="includes/logout.php" tabindex="8">Salir</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	<?php }
	} ?>
</header>