<?php 
 // Título de la página, keywords y descripción
 $title = 'Registro';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de registro de una galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section id="registro">
		<h2>Registro</h2>
		<form id="form_registro" action="index.php" method="post">
			<p>
			<label for="nombre">Nombre:</label>
			<input type="text" name="nombre" id="nombre" tabindex="5"/>
			</p>
			<p>
			<label for="password2">Contraseña:</label>
			<input type="password" name="password2" id="password2" tabindex="6"/>
			</p>
			<p>
			<label for="repassword">Repetir contraseña:</label>
			<input type="password" name="repassword" id="repassword" tabindex="7"/>
			</p>
			<p>
			<label for="correo">Email:</label>
			<input type="email" name="correo" id="correo" tabindex="8"/>
			</p>
			
			<p>Sexo:
			<label for="hombre">Hombre</label>
			<input type="radio" name="sexo" value="Hombre" id="hombre" tabindex="9" checked>
			<label for="mujer">Mujer</label>
			<input type="radio" name="sexo" value="Mujer" id="mujer" tabindex="10">
			</p>
			
			<p>Fecha nacimiento:</p>
			<p>
				<select name="dias" tabindex="11">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select>
			
			<select name="meses" tabindex="12">
				<option value="1">enero</option>
				<option value="2">febrero</option>
				<option value="3">marzo</option>
				<option value="4">abril</option>
				<option value="5">mayo</option>
				<option value="6">junio</option>
				<option value="7">julio</option>
				<option value="8">agosto</option>
				<option value="9">septiembre</option>
				<option value="10">octubre</option>
				<option value="11">noviembre</option>
				<option value="12">diciembre</option>
			</select>
			
			<select name="anyos" tabindex="13">
				<option value="2017">2017</option>
				<option value="2016">2016</option>
				<option value="2015">2015</option>
				<option value="2014">2014</option>
				<option value="2013">2013</option>
			</select>
			</p>
			<p>
			<label for="ciudad">Ciudad:</label>
			<input type="text" name="ciudad" id="ciudad" tabindex="14"/>
			</p>
			<p>
			<label for="pais">País:</label>
			<select name="paises" tabindex="15" id="pais">
				<option value="al">Alemania</option>
				<option value="es">Escocia</option>
				<option value="esp">España</option>
				<option value="fr">Francia</option>
				<option value="ga">Gales</option>
				<option value="gr">Grecia</option>
				<option value="ing">Inglaterra</option>
				<option value="ir">Irlanda</option>
				<option value="it">Italia</option>
			</select>
			</p>
			<p>
			<label for="foto">Foto:</label>
			<input type="file" name="fotoPerfil" id="foto" tabindex="16"/>
			</p>
			<input type="submit" name="registro" value="Registrarse" tabindex="17"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>