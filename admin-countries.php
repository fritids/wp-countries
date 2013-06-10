<div class='wrap'>

	<div id="icon-tools" class="icon32"></div><h2>WP-Countries: <?php _e("Países") ?></h2>
	
	<br />

	<?php

		global $post,$wpdb;
		$name = "";
		$localname = "";
		$continent = "";
		$code = "";
		$code2 = "";
		$update = "false";

		$continents = Array(
			Array(
				"id" => "Asia",
				"name" => _("Asia")
			),
			Array(
				"id" => "Europe",
				"name" => _("Europa")
			),
			Array(
				"id" => "Africa",
				"name" => _("Africa")
			),
			Array(
				"id" => "Oceania",
				"name" => _("Oceania")
			),
			Array(
				"id" => "Antarctica",
				"name" => _("Antartica")
			),
			Array(
				"id" => "South America",
				"name" => _("América del sur")
			),
			Array(
				"id" => "North America",
				"name" => _("América del norte")
			),
		);

		

		// delete value
		if ( isset($_GET["dlt"]) ) {

		}

		// get update value
		if (isset($_GET["updt"])) {
			$sql = "SELECT * FROM wp_countries WHERE Code2 = '" . $_GET["updt"] . "' LIMIT 1";
			$country = $wpdb->get_results( $sql );
			$name = $country[0]->Name;
			$localname = $country[0]->LocalName;
			$continent = $country[0]->Continent;
			$code2 = $country[0]->Code;
			$code = $country[0]->Code2;
			$update = "true";
		}

		// Save new country
		if (isset($_POST["fupdate"])){

			$save_update = $_POST["fupdate"];
			$save_name = $_POST["fname"];
			$save_localname = $_POST["flocalname"];
			$save_continent = $_POST["fcontinent"];
			$save_code = $_POST["fcode"];
			$save_abrev = $_POST["fabrev"];
			$save = true;

			if ( empty($save_name) ){
				$message = _("Debes ingresar el nombre del país");
				$save = false;
			}

			if ( empty($save_code) ){
				$message = _("Debes ingresar el código de internet");
				$save = false;
			}

			$sql = "SELECT * FROM wp_countries WHERE Code2 = '$save_code' LIMIT 1";
			$code_exist = $wpdb->get_results( $sql );
			if ( !empty($code_exist) && $save_update == "false") {
				$message = _("El código de internet ya ha sido ingresado");
				$save = false;
			}

			if ( $save == true ) {
				if ($save_update == "false"){
					$wpdb->insert( 
						'wp_countries', 
						array( 
							'Name' => $save_name, 
							'LocalName' => $save_localname, 
							'Continent' => $save_continent, 
							'Code' => $save_abrev, 
							'Code2' => $save_code
						) 
					);
					$message = _("El País ") . "<strong>" . $save_name . "</strong>" . _(" ha sido agregado exitosamente");
				} else {
					$wpdb->update( 
						'wp_countries', 
						array( 
							'Name' => $save_name, 
							'LocalName' => $save_localname, 
							'Continent' => $save_continent, 
							'Code' => $save_abrev
						), 
						array( 'Code2' => $save_code )
					);
					$message = _("El País ") . "<strong>" . $save_name . "</strong>" . _(" ha sido modificado exitosamente");
				}
			}

		}
	?>
	
	<?php if ( !empty($message) ) { ?>
	<div id="message" style="background:#ffffe0; border:1px solid #e6db55; padding:5px 10px; margin:0 0 15px;"><?php echo $message; ?></div>
	<?php } ?>

	<div class="postbox" id="boxid">
	    <div title="Click to toggle" class="handlediv"><br></div>
	    <h3 class="hndle"><span style="padding:5px 10px; display:block; width:50%;"><?php _e("Agregar un nuevo país") ?></span></h3>
	    <div class="inside">
			<form action="?page=wpc-countries" method="post">
				<input type="hidden" id="fupdate" name="fupdate" value="<?php echo $update; ?>">
				<table class="form-table">
				    <tbody>
				    	<tr>
						    <th scope="row">
						        <label for="fcode">Código de Internet *</label>
						    </th>
						    <td>
						        <input type="text" value="<?php echo $code; ?>" id="fcode" name="fcode">
						    </td>
				        </tr>
				        <tr>
						    <th scope="row">
						        <label for="fname">Nombre *</label>
						    </th>
						    <td>
						        <input type="text" value="<?php echo $name; ?>" id="fname" name="fname">
						    </td>
				        </tr>
				        <tr>
						    <th scope="row">
						        <label for="flocalname">Nombre local</label>
						    </th>
						    <td>
						        <input type="text" value="<?php echo $localname; ?>" id="flocalname" name="flocalname">
						    </td>
				        </tr>
				        <tr>
						    <th scope="row">
						        <label for="fcontinent">Continente</label>
						    </th>
						    <td>
						        <select id="fcontinent" name="fcontinent">
						        	<?php 
						        		foreach ($continents as $cont) { 
						        			if ( $cont["id"] ==  $continent) {
						        	?>
						        		<option value="<?php echo $cont["id"] ?>" selected="selected"><?php echo $cont["name"] ?></option>
						        	<?php 	} else { ?>
						        		<option value="<?php echo $cont["id"] ?>"><?php echo $cont["name"] ?></option>
						        	<?php 
						        			}
						        		} 
						        	?>
						        </select>
						    </td>
				        </tr>
				        <tr>
						    <th scope="row">
						        <label for="fabrev">Abreviatura</label>
						    </th>
						    <td>
						        <input type="text" value="<?php echo $code2; ?>" id="fabrev" name="fabrev">
						    </td>
				        </tr>
				        <tr>
						    <th scope="row"></th>
						    <td>
						        <p class="submit"><input type="submit" value="<?php _e("Save Changes"); ?>" class="button-primary" name="Submit"></p>
						    </td>
				        </tr>
				    </tbody>
				</table>
			</form>
		</div>
	</div>

	<?php
		$sql = "SELECT * FROM wp_countries ORDER BY Name";
		$countries = $wpdb->get_results( $sql );
	?>
	<table class="widefat">
		<thead>
		    <tr>
		    	<th>Código Internet</th>
		        <th>Nombre</th>
		    	<th>Nombre local</th>
		        <th>Continente</th>
		    	<th>Abreviatura</th>
		    	<th>Editar</th>
		    	<th>A/D</th>
		    	<th>Eliminar</th>
		    </tr>
		</thead>
		<tfoot>
		    <tr>
		    	<th>Código Internet</th>
		        <th>Nombre</th>
		    	<th>Nombre local</th>
		        <th>Continente</th>
		    	<th>Abreviatura</th>
		    	<th>Editar</th>
		    	<th>A/D</th>
		    	<th>Eliminar</th>
		    </tr>
		</tfoot>
		<tbody>
		<?php
			foreach($countries as $country) {
		?>
		   	<tr>
		   		<td><?php print_r($country->Code2) ?></td>
				<td><?php print_r($country->Name) ?></td>
				<td><?php print_r($country->LocalName) ?></td>
				<td><?php print_r($country->Continent) ?></td>
				<td><?php print_r($country->Code) ?></td>
				<td><a href="?page=wpc-countries&updt=<?php print_r($country->Code2) ?>">Editar</a></td>
				<td><a href="?page=wpc-countries&ctvt=<?php print_r($country->Code2) ?>">Activo</a></td>
				<td><a href="?page=wpc-countries&dlt=<?php print_r($country->Code2) ?>">Eliminar</a></td>
		   	</tr>
		<?php
			}
		?>
		</tbody>
	</table>

</div>
