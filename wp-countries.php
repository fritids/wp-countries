<?php

	/**
	 * @package wp-countries
	*/

	/*
		Plugin Name: WP Countries
		Plugin URI: http://www.gabrielburgos.cl/
		Description: Todos los paises del mundo
		Version: 1.0.0
		Author: Gabriel Burgos
		Author URI: http://www.gabrielburgos.cl/
		License: GPLv2 or later
	*/
?>
<?php

	// Get real IP

	function WPC_GetIp($ip){
		if (empty($ip)){
			$ip = (empty($_SERVER['HTTP_CLIENT_IP'])?(empty($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['HTTP_CLIENT_IP']);
			if ( empty($ip) ){
				if ( $ip == "127.0.0.1" ) {
					return _("Error, no se puede obtener el país con una ip local ") . $ip;
				} else {
					return $ip;
				}
			}
		} else {
			return $ip;
		}
	}

	register_activation_hook( __FILE__, 'WPC_GetIp' );

	// Get current country

	function WPC_CurrentCountry($ip){
		return get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
	}

	register_activation_hook( __FILE__, 'WPC_CurrentCountry' );

	// Admin config

	if ( is_admin() ) {

		add_action( 'admin_menu', 'register_my_custom_menu_page' );

		function register_my_custom_menu_page(){
		    add_menu_page( _("General"), _("WP-Countries"), 'manage_options', 'wpc', 'adminPageGeneral', "", 100 ); 
		}

		add_action('admin_menu', 'register_my_custom_submenu_page');

		function register_my_custom_submenu_page() {
			add_submenu_page( 'wpc', _('Países'), _('Países'), 'manage_options', 'wpc-countries', 'adminPageCountries' );
			add_submenu_page( 'wpc', _('Ciudades'), _('Ciudades'), 'manage_options', 'wpc-cities', 'adminPageCities' ); 
		}

		function adminPageGeneral(){
	        require_once dirname( __FILE__ ) . '/admin.php';
	    }

	    function adminPageCountries(){
	        require_once dirname( __FILE__ ) . '/admin-countries.php';
	    }

	    function adminPageCities(){
	        require_once dirname( __FILE__ ) . '/admin-cities.php';
	    }

	}

	// Custom fields

	add_action( 'add_meta_boxes', 'add_events_metaboxes' );

	function add_events_metaboxes() {
		$option_name = 'wpc-post-types';
		$post_types = get_option($option_name);
		for ($i=0;$i<count($post_types);$i++){
    		add_meta_box('wpc_location', _("País"), 'wpc_location', $post_types[$i], 'normal', 'default');
    	}
	}

	function wpc_location() {
		require_once dirname( __FILE__ ) . '/fields.php';
	}

	// SAVE CUSTOM FIELDS

	function wpt_save_events_meta($post_id, $post) {
		if ( !empty($_POST) ){
			// Save country
			if ( !empty($_POST["fcountry"]) ){
				if(get_post_meta($post->ID, "_country", FALSE)) {
					update_post_meta($post_id, "_country", $_POST["fcountry"]);
				} else {
					add_post_meta($post_id, "_country", $_POST["fcountry"]);
				}
			}
			// Save City
			if ( !empty($_POST["fcity"]) ){
				if(get_post_meta($post->ID, "_country", FALSE)) {
					update_post_meta($post_id, "_city", $_POST["fcity"]);
				} else {
					add_post_meta($post_id, "_city", $_POST["fcity"]);
				}
			}
		}
	}

	add_action('save_post', 'wpt_save_events_meta', 1, 2);

?>