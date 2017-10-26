<?php 
 // Título de la página, keywords y descripción
 $title = 'Solicitar álbum';
 $keywords = 'pictures, images, imagen, imágenes, fotos, foto';
 $description = 'Página para solicitar la impresión de un álbum del usuario.';
 
 // Declaración de DOCTYPE, <html>, <head>, <title>, <meta> y <link>. 
require_once("cabecera.php");
 ?>
 
 <body>
	<!-- HEADER -->
	<?php require_once("header.php"); ?>
	
	<aside class="tarifas">
		<h2>Tarifas</h2>
		<table>
			<tr>
				<th>Concepto</th>
				<th>Precio</th>
			</tr>
			<tr>
				<td> menos de 5 páginas </td>
				<td> 0,10 € por página</td>
			</tr>
			<tr>
				<td> entre 5 y 10 páginas </td>
				<td> 0,08 € por página </td>
			</tr>
			<tr>
				<td> entre 5 y 10 páginas </td>
				<td> 0,06 € por página </td>
			</tr>
			<tr>
				<td> fotos en blanco y negro </td>
				<td> sin suplemento</td>
			</tr>
			<tr>
				<td> fotos a color </td>
				<td> suplemento de 0,03 € por foto </td>
			</tr>
			<tr>
				<td> portada en blanco y negro </td>
				<td> sin suplemento </td>
			</tr>
			<tr>
				<td> portada a color </td>
				<td> suplemento de 0,50 €  </td>
			</tr>
			<tr>
				<td> resolución mayor de 450 dpi   </td>
				<td> suplemento de 0,10 € por foto </td>
			</tr>
		</table>
	</aside>
	
	<section id="solicitar">
		<h2>Solicitar álbum impreso</h2>
		<p>En esta página podrás seleccionar un álbum a tú elección entre aquellos que tengas
		para que te lo imprimamos y te lo enviemos a casa con las características que desees.
		Podrás configurarlo como quieras: seleccionar el número de páginas, el tamaño de las 
		imágenes, imágenes a color o en blanco y negro, el color de la portada... Todo como lo desees.</p>
		
		<h2>Introduce los datos de tu álbum</h2>
		<p class="letra_roja">(*) Campos obligatorios</p>
		<form action="respuesta_album.php" method="post">
			
			<fieldset>
				<legend>Datos personales</legend>
				
				<p><label for= "nombre">Nombre: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="nombre" id="nombre" required="" maxlength="100" tabindex="4"/></p>  <!--obligatorio, máximo 200 caracteres entre nombre y apellidos-->
			
				<p><label for= "apellidos">Apellidos: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="apellidos" id="apellidos" required="" maxlength="100" tabindex="5"/></p>
				
				<p><label for= "email">Email: <span class="asterisco_rojo">*</span></label>
				<input type="email" name="email" id="email" required="" tabindex="6"/></p>
				
				<p><label for= "titulo_album">Título del álbum: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="titulo_album" id="titulo_album" required="" maxlength="200" tabindex="7"/></p>  <!--obligatorio, máximo 200 caracteres -->
			
				<p class="quitar_margenes">Texto adicional:</p>  <!--opcional, máximo 4000 caracteres -->
				<textarea rows="4" cols="50" maxlength="4000" placeholder="Dedicatoria, descripción..." tabindex="8"></textarea>
			</fieldset>
			<fieldset class="direction">
				<legend> Dirección </legend>
				<p><label for= "calle">Calle: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="calle" id="calle" required="" tabindex="9"/></p>
				
				<p><label for= "numero_portal">Número: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="numero_portal" id="numero_portal" required="" tabindex="10"/></p>
				
				<p><label for= "escalera">Escalera:</label>
				<input type= "text" name="escalera" id="escalera" tabindex="11"/></p>
				
				<p><label for= "piso">Piso:</label>
				<input type= "text" name="piso" id="piso" tabindex="12"/></p>
				
				<p><label for= "puerta">Puerta:</label>
				<input type= "text" name="puerta" id="puerta" tabindex="13"/></p>
				
				<p><label for= "CP">Código postal: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="CP" id="CP" required="" tabindex="14"/></p>
				
				<p><label for= "localidad">Localidad: <span class="asterisco_rojo">*</span></label>
				<input type= "text" name="localidad" id="localidad" required="" tabindex="15"/></p>
				
				<p class="quitar_abajo">Provincia: <span class="asterisco_rojo">*</span></p>
				<p class="quitar_arriba"><select name="provincia" required="" tabindex="16">
					<option value="">Elija provincia...</option>
					<option value="alava">Álava</option>
					<option value="albacete">Albacete</option>
					<option value="alicante">Alicante</option>
					<option value="almeria">Almería</option>
					<option value="avila">Ávila</option>	
				</select></p>
				
				<p class="quitar_abajo">País: <span class="asterisco_rojo">*</span></p>
				<p class="quitar_arriba"><select name="pais" required="" tabindex="17">
					<option value="">Elija país...</option>
					<option value="al">Alemania</option>
					<option value="es">Escocia</option>
					<option value="esp">España</option>
					<option value="fr">Francia</option>
					<option value="ga">Gales</option>
					<option value="gr">Grecia</option>
					<option value="ing">Inglaterra</option>
					<option value="ir">Irlanda</option>
					<option value="it">Italia</option>
				</select></p>
			</fieldset>
			
			<fieldset>
				<legend> Configuración </legend>
				
				<p><label for="color_album">Color de la portada:</label>
				<input type="color" name="color_album" id="color_album" value="#000000" tabindex="18"/></p>
				
				<p><label for= "numero_copias">Número de copias:</label>
				<input type="number" name="numero_copias" id="numero_copias"  min="1" value="1" tabindex="19"/></p>
				
				<p>Resolución de las fotos:</p>
				<p class="resolucion">150dpi <input type="range" name="resolucion" min="150" max="900" step="150" value="150" tabindex="20"/> 900dpi</p>
				
				<p class="quitar_abajo">Álbum: <span class="asterisco_rojo">*</span></p>
				<p class="quitar_arriba"><select name="album" required="" tabindex="21">
					<option value="">Elija álbum...</option>
					<option value="album1">album 1</option>
					<option value="album2">album 2</option>
					<option value="album3">album 3</option>
					<option value="album4">album 4</option>
				</select></p> 
				
				<p><label for="fecha_recepcion">Fecha de recepción:</label>
				<input type="date"  name="fecha_recepcion" id="fecha_recepcion" tabindex="22"/> </p>
				
				<p class="quitar_abajo">Color de las fotos:</p>
				<p class="quitar_arriba">
					<label for="blanco_negro">Blanco y negro</label>
					<input type="radio" name="color_fotos" value="blanco_negro" id="blanco_negro" tabindex="23" checked>
					<label for="foto_color">Color</label>
					<input type="radio" name="color_fotos" value="color" id="foto_color" tabindex="24">
				</p>
			</fieldset>
			
			<input type="submit" name="solicitar_album" value="Solicitar álbum" tabindex="25"/>
		</form>
	</section>
	
	<!-- FOOTER con </body> y </html> -->
	<?php require_once("footer.php"); ?>