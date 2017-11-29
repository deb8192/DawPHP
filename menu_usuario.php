<?php 
 // Título de la página, keywords y descripción
 $title = 'Menú usuario';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Menú de usuario de la galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="datos_usuario">
		<h2>Datos personales</h2>
		<img src="<?php echo $_SESSION['usuario']['foto']; ?>" alt="Foto perfil" width="200" height="150"/>
		<p>Nombre: <?php echo $_SESSION['usuario']['nombre']; ?></p>
		<p>Email: <?php echo $_SESSION['usuario']['correo']; ?></p>
		<p>Sexo: <?php echo $_SESSION['usuario']['sexo'] ; ?></p>
		<p>Fecha: <?php echo $_SESSION['usuario']['fecha'] ; ?></p>
		<p>Ciudad: <?php echo $_SESSION['usuario']['ciudad'] ; ?></p>
		<p>País: <?php echo $_SESSION['usuario']['pais']; ?></p>
		<?php
		if(isset($_COOKIE['last_visit']))
			echo "<p>Tu último acceso fue el " . $_COOKIE['last_visit'] . "</p>";
		else
			echo "<p>Esta es tu primera vez aquí.</p>";
		?>
	</section>
	
	<!-- FOOTER -->
	<?php require_once("includes/footer.php"); ?>
</body>
</html>