<header>
	<a class="logo" href="index.php" tabindex="1"><h1>PI</h1></a>
	
	
	<?php require_once("login.php");
		if (!isset ($_SESSION['usuario'])) { ?>

		<form id="inicio_sesion" action="includes/login.php" method="post">
			<label for="usuario">Usuario:</label>
			<input type="text" name="usuario" id="usuario" required="" tabindex="3"/>

			<label for="password">Contraseña:</label>
			<input type="password" name="password" id="password" required="" tabindex="4"/>

			<input type="submit" name="enviar" value="Enviar"/>
		</form>
		<p class="barra">|</p>
		<a class="registro" href="registro.php" title="Registrarse" tabindex="2">Registrarse</a>
		<form id="inicio_sesion_desplegable" action="includes/login.php" method="post">
			<ul class="desplegable_is">
				<li><a href="">iniciar sesion</a>
						<ul class="opciones_is">
						<li><label for="usuario">Usuario:</label></li>
						<li><input type="text" name="usuario" id="usuario" required="" tabindex="2"/></li>
						<li><label for="password">Contraseña:</label></li>
						<li><input type="password" name="password" id="password" required="" tabindex="3"/></li>
						<li><input type="submit" name="enviar" value="Enviar"/></li>
						<li><a href="registro.php" title="Registrarse" tabindex="4">Registrarse</a></li>
					</ul>
				</li>
			</ul>
		</form>
	
	<?php } else { ?>
	
		<p id="bienvenida">Bienvenido Pepito Palotes | <a class="salir" href="includes/logout.php" tabindex="2">Salir</a></p>
			
			
			
			<nav id="menu_usuario">
				<ul>
					<li><a href="menu_usuario.php" tabindex="3">Ir a mi Perfil</a></li>
				</ul>
			</nav>
			<nav id="menu_usuario_modificado">
				<ul>
					<li><a href="menu_usuario.php" tabindex="2">Ir a mi Perfil</a></li>
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
			
			
			
	<?php } ?>
</header>

<?php 
/*         Menú para cuando se haya iniciado sesión

	<header>
		<a class="logo" href="index.php" tabindex="1"><h1>PI</h1></a>
		<p id="bienvenida">Bienvenido Pepito Palotes | <a class="salir" href="index.php" tabindex="2">Salir</a></p>
		
		
		<nav  id="menu_usuario">
			<ul>
				<li><a href="" tabindex="3">Editar datos</a></li>
				<li><a href="" tabindex="4">Darse de baja</a></li>
				<li><a href="" tabindex="5">Mis álbumes</a></li>
				<li><a href="" tabindex="6">Crear álbum</a></li>
				<li><a href="solicitar_album.php" tabindex="7">Solicitar álbum</a></li>
		</nav>
		<nav  id="menu_usuario_modificado">
			<ul>
				<li><a href="" tabindex="3">Editar datos</a></li>
				<li><a href="" tabindex="4">Darse de baja</a></li>
				<li><a href="" tabindex="5">Mis álbumes</a></li>
				<li><a href="" tabindex="6">Crear álbum</a></li>
				<li><a href="solicitar_album.php" tabindex="7">Solicitar álbum</a></li>
				<li><a href="index.php" tabindex="8">Salir</a></li>
			</ul>
		</nav>
		<nav  id="menu_usuario_desplegable">
			<ul class="desplegable">
				<li><a href="">Opciones</a>
					<ul class="opciones">
						<li><a href="" tabindex="3">Editar datos</a></li>
						<li><a href="" tabindex="4">Darse de baja</a></li>
						<li><a href="" tabindex="5">Mis álbumes</a></li>
						<li><a href="" tabindex="6">Crear álbum</a></li>
						<li><a href="solicitar_album.php" tabindex="7">Solicitar álbum</a></li>
						<li><a href="index.php" tabindex="8">Salir</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		
		
	</header>
*/
?>