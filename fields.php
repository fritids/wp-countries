<table class="form-table">
    <tbody>
    	<tr>
		    <th scope="row">
		        <label style="display:block; text-align:left; width:100px;"><?php _e("País") ?><label>
		    </th>
		    <td>
		    	<?php 
		    		global $post,$wpdb;
					// bbdd
					$sql = "SELECT * FROM wp_countries ORDER BY Name";
					$countries = $wpdb->get_results( $sql );
					// current country
					$current_country = get_post_meta($post->ID, "_country", true);
		    	?>
		        <select name="fcountry" id="wpc-country">
		        	<option value=""><?php _e("Selecciona un país") ?></option>
				<?php
					// loop
					foreach($countries as $country) {
						if ($current_country == $country->Code){
				?>
					<option SELECTED value="<?php echo $country->Code ?>"><?php echo $country->Name ?></option>
				<?php } else { ?>
					<option value="<?php echo $country->Code ?>"><?php echo $country->Name ?></option>
				<?php
						}
					}
				?>
				</select>
		    </td>
        </tr>
        <tr>
		    <th scope="row">
		        <label style="display:block; text-align:left; width:100px;"><?php _e("Ciudad") ?><label>
		    </th>
		    <td>
		    	<?php 
		    		// current country
					$current_city = get_post_meta($post->ID, "_city", true);
					$sql = "SELECT * FROM wp_cities WHERE CountryCode = '$current_country' ORDER BY Name";
					$cities = $wpdb->get_results( $sql );
		    	?>
		        <select name="fcity" id="wpc-city">
		        	<option value=""><?php _e("Selecciona una ciudad") ?></option>
		        <?php
					// loop
					foreach($cities as $city) {
						if ($current_city == $city->ID){
				?>
					<option SELECTED value="<?php echo $city->ID ?>"><?php echo $city->Name ?></option>
				<?php } else { ?>
					<option value="<?php echo $city->ID ?>"><?php echo $city->Name ?></option>
				<?php
						}
					}
				?>
				</select>
		    </td>
        </tr>
	</tbody>
</table>
<script>
	jQuery(document).ready(function(){

		var url = '<?php echo plugins_url("/wp-countries/ajax.php"); ?>';

		jQuery("#wpc-country").change(function(){
			ajax(jQuery(this).val(),url);
		});

		function ajax(value,url){
			jQuery.ajax({
				url : url,
				data : {
					wpc_action : "get_cities", 
					wpc_value : value
				}
			}).done(function( data ) {
				var obj = jQuery.parseJSON( data );
				jQuery("#wpc-city").html("");
				for (i=0;i<obj.length;i++){
					jQuery("#wpc-city").append( '<option value="'+obj[i]["code"]+'">'+obj[i]["name"]+'</option>' )
				}
			});
		}

	});
</script>