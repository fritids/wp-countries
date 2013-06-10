<div class='wrap'>

	<div id="icon-tools" class="icon32"></div><h2>WP-Countries: <?php _e("Ciudades") ?></h2>
	
	<br />

	<?php

		global $post,$wpdb;

		$name = "";
		$country = "";
		$id = "";
		$district = "";
		$update = "false";

		// delete value
		if ( isset($_GET["dlt"]) ) {

		}

		// get update value
		if (isset($_GET["updt"])) {
			$sql = "SELECT * FROM wp_cities WHERE ID = '" . $_GET["updt"] . "' LIMIT 1";
			$city = $wpdb->get_results( $sql );
			$name = $city[0]->Name;
			$district = $city[0]->District;
			$country = $city[0]->CountryCode;
			$uid = $_GET["updt"];
			$update = "true";
		}

		print_r($continent);

		// Save new country
		if (isset($_POST["fupdate"])){

			$save_update = $_POST["fupdate"];
			$save_name = $_POST["fname"];
			$save_district = $_POST["fdistrict"];
			$save_country = $_POST["fcountry"];
			$save_id = $_POST["fuid"];
			$save = true;

			if ( empty($save_name) ){
				$message = _("Debes ingresar el nombre de la cuidad");
				$save = false;
			}

			if ( empty($save_country) ){
				$message = _("Debes seleccionar un país para la cuidad");
				$save = false;
			}

			if ( $save == true ) {
				if ($save_update == "false"){
					$wpdb->insert( 
						'wp_cities', 
						array( 
							'Name' => $save_name, 
							'District' => $save_district, 
							'CountryCode' => $save_country
						) 
					);
					$message = _("La cuidad ") . "<strong>" . $save_name . "</strong>" . _(" ha sido agregado exitosamente");
				} else {
					$wpdb->update( 
						'wp_cities', 
						array( 
							'Name' => $save_name, 
							'District' => $save_district, 
							'CountryCode' => $save_country
						), 
						array( 'ID' => $save_id )
					);
					$message = _("La cuidad ") . "<strong>" . $save_name . "</strong>" . _(" ha sido modificado exitosamente");
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
			<form action="?page=wpc-cities" method="post">
				<input type="hidden" id="fupdate" name="fupdate" value="<?php echo $update; ?>">
				<input type="hidden" id="fuid" name="fuid" value="<?php echo $uid; ?>">
				<table class="form-table">
				    <tbody>
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
						        <label for="fdistrict">Distrito</label>
						    </th>
						    <td>
						        <input type="text" value="<?php echo $district; ?>" id="fdistrict" name="fdistrict">
						    </td>
				        </tr>
				        <tr>
						    <th scope="row">
						        <label for="fcountry">País</label>
						    </th>
						    <td>
						        <select id="fcountry" name="fcountry">
						        	<?php
										$sql = "SELECT * FROM wp_countries ORDER BY Name";
										$countries = $wpdb->get_results( $sql );
						        		foreach($countries as $field) {
						        			if ( $field->Code ==  $country) {
						        	?>
						        		<option value="<?php echo $field->Code ?>" selected="selected"><?php echo $field->Name ?></option>
						        	<?php 	} else { ?>
						        		<option value="<?php echo $field->Code ?>"><?php echo $field->Name ?></option>
						        	<?php 
						        			}
						        		} 
						        	?>
						        </select>
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
		$sql = "SELECT
					wp_cities.ID,
					wp_cities.Name,
					wp_countries.Name AS Country,
					wp_cities.District
				FROM wp_cities 
			    INNER JOIN wp_countries ON (wp_cities.CountryCode =  wp_countries.Code)
			    ORDER BY wp_cities.Name
			   ";
		$cities = $wpdb->get_results( $sql );
	?>
	<table class="widefat">
		<thead>
		    <tr>
		        <th>Nombre</th>
		        <th>Distrito</th>
		        <th>País</th>
		    	<th>Editar</th>
		    	<th>A/D</th>
		    	<th>Eliminar</th>
		    </tr>
		</thead>
		<tfoot>
		    <tr>
		        <th>Nombre</th>
		        <th>Distrito</th>
		        <th>País</th>
		    	<th>Editar</th>
		    	<th>A/D</th>
		    	<th>Eliminar</th>
		    </tr>
		</tfoot>
		<tbody>
		<?php
			foreach($cities as $city) {
		?>
		   	<tr>
				<td><?php print_r($city->Name) ?></td>
				<td><?php print_r($city->District) ?></td>
				<td><?php print_r($city->Country) ?></td>
				<td><a href="?page=wpc-cities&updt=<?php print_r($city->ID) ?>">Editar</a></td>
				<td><a href="?page=wpc-cities&ctvt=<?php print_r($city->ID) ?>">Activo</a></td>
				<td><a href="?page=wpc-cities&dlt=<?php print_r($city->ID) ?>">Eliminar</a></td>
		   	</tr>
		<?php
			}
		?>
		</tbody>
	</table>

</div>
