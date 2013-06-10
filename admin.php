<div class='wrap'>
	<div id="icon-tools" class="icon32"></div><h2>WP Countries <?php _e("configuration") ?></h2>
	<br />
	<div class="postbox" id="boxid">
	    <div title="Click to toggle" class="handlediv"><br></div>
	    <h3 class="hndle"><span style="padding:5px 10px; display:block; width:50%;"><?php _e("Mostrar en") ?>:</span></h3>
	    <div class="inside">
			<form action="?page=wpc" method="post">
				<table>
					<tbody>
		    	<?php 

		    		$option_name = 'wpc-post-types';

		    		if ( isset($_POST["wpc-types"]) ) {
		    			if ( get_option($option_name) ) {
		    				update_option( $option_name, $_POST["wpc-types"] );
		    			} else {
		    				add_option( $option_name , $_POST["wpc-types"], '', 'yes' );
		    			}
		    		}

		    		print_r( get_option($option_name) );

					$post_types=get_post_types('','names'); 
					foreach ($post_types as $post_type ) {
						$object = get_post_type_object( $post_type );
						$name = $object->labels->name;
						if ($post_type != "attachment" && $post_type != "revision" && $post_type != "nav_menu_item") {
				?>
						<tr>
							<td scope="row"><input type="checkbox" name="wpc-types[]" value="<?php echo $post_type ?>" /> <label><?php echo $name . " (" . $post_type . ")" ?></label></td>
						</tr>
				<?php		  	
						}
					}
				?>
						<tr>
						    <td scope="row">
						    	<p class="submit"><input type="submit" value="<?php _e("Save Changes"); ?>" class="button-primary" name="Submit"></p>
						   	</td>
				        </tr>
				    </tbody>
				</table>
			</form>
		</div>
	</div>	    
</div>