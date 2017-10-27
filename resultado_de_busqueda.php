<?php 
 // Título de la página, keywords y descripción
 $title = 'Resultado búsqueda';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto, buscar, busqueda, búsqueda';
 $description = 'Página de resultados de una búsqueda en una galería de fotos on-line.';
 
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
					<option value="enero">enero</option>
					<option value="febrero">febrero</option>
					<option value="marzo">marzo</option>
					<option value="abril">abril</option>
					<option value="mayo">mayo</option>
					<option value="junio">junio</option>
					<option value="julio">julio</option>
					<option value="agosto">agosto</option>
					<option value="septiembre">septiembre</option>
					<option value="octubre">octubre</option>
					<option value="noviembre">noviembre</option>
					<option value="diciembre">diciembre</option>
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
					<option value="Alemania">Alemania</option>
					<option value="Escocia">Escocia</option>
					<option value="España">España</option>
					<option value="Francia">Francia</option>
					<option value="Gales">Gales</option>
					<option value="Grecia">Grecia</option>
					<option value="Inglaterra">Inglaterra</option>
					<option value="Irlanda">Irlanda</option>
					<option value="Italia">Italia</option>
				</select>
			</p>
			<input type="submit" name="buscar" value="Buscar" tabindex="10"/>
		</form>
		
		<section id="criterio_busqueda">
			<h2>Criterios de búsqueda</h2>
			<?php

				if(!empty($_POST['titulo'])){
					$titulo = $_POST['titulo'];
					echo "<p>Título: $titulo</p> ";
				}
				if(!empty($_POST['dia'])&&!empty($_POST['mes'])&&!empty($_POST['anyo'])){
					$dia = $_POST['dia'];
					$mes = $_POST['mes'];
					$anyo = $_POST['anyo'];
					echo "<p>Fecha: $dia de $mes de $anyo</p> ";
				}
				if(!empty($_POST['pais'])){
					$pais = $_POST['pais'];
					echo "<p>País: $pais ";
				}
				?>
		</section>
	
		<section id="resultado_busqueda">
			<h2>Resultado de la búsqueda</h2>
			<ul class="lista_fotos">
				<li>
					<h3>Título</h3>
					<a href="detalle_foto.php?id=0" name="foto" id="0" title="Ver foto1" tabindex="11"><img src="img/foto.jpg" alt="Foto 1" width="200" height="150"/></a>
					<ul class="datos">
						<li>Fecha</li>
						<li>País</li>
					</ul>
				</li>
				<li>
					<h3>Título</h3>
					<a href="detalle_foto.php?id=1" name="foto" id="1" title="Ver foto2" tabindex="12"><img src="img/foto.jpg" alt="Foto 2" width="200" height="150"/></a>
					<ul>
						<li>Fecha</li>
						<li>País</li>
					</ul>
				</li>
				<li>
					<h3>Título</h3>
					<a href="detalle_foto.php?id=0" name="foto" id="0" title="Ver foto3" tabindex="13"><img src="img/foto.jpg" alt="Foto 3" width="200" height="150"/></a>
					<ul>
						<li>Fecha</li>
						<li>País</li>
					</ul>
				</li>
				<li>
					<h3>Título</h3>
					<a href="detalle_foto.php?id=1" name="foto" id="1" title="Ver foto4" tabindex="14"><img src="img/foto.jpg" alt="Foto 4" width="200" height="150"/></a>
					<ul>
						<li>Fecha</li>
						<li>País</li>
					</ul>
				</li>
				<li>
					<h3>Título</h3>
					<a href="detalle_foto.php?id=0" name="foto" id="0" title="Ver foto5" tabindex="15"><img src="img/foto.jpg" alt="Foto 5" width="200" height="150"/></a>
					<ul>
						<li>Fecha</li>
						<li>País</li>
					</ul>
				</li>
			</ul>
		</section>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("includes/footer.php"); ?>