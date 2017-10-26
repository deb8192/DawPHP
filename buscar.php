<?php 
 // Título de la página, keywords y descripción
 $title = 'Buscar';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de búsqueda de una galería de fotos on-line.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("includes/cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("includes/header.php"); ?>
	
	<section class="form_busqueda">
		<h2>Formulario de búsqueda</h2>
		<form action="resultado_de_busqueda.php" method="post">
			<p>
				<label for="titulo">Título:</label>
				<input type="text" name="titulo" id="titulo" tabindex="5"/>
			</p>
			<p>Fecha:</p>
			<p>
				<select name="dia" tabindex="6">
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
				<select name="mes" tabindex="7">
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
				<select name="anyo" tabindex="8">
					<option value="2017">2017</option>
					<option value="2016">2016</option>
					<option value="2015">2015</option>
					<option value="2014">2014</option>
					<option value="2013">2013</option>
				</select>
			</p>
			<p>
				<label for="pais">País:</label>
				<select name="pais" id="pais" tabindex="9">
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
			<input type="submit" name="buscar" value="Buscar" tabindex="10"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>