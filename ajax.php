<?php 

	include_once("../../../wp-load.php");
	global $post,$wpdb;

	$countryCode = $_REQUEST["wpc_value"];
	$data = Array();

	$i=0;
	$sql = "SELECT * FROM wp_cities WHERE CountryCode = '$countryCode' ORDER BY Name";
	$countries = $wpdb->get_results( $sql );
	foreach($countries as $country) {
		$data[$i] = Array(
			"code" => $country->ID,
			"name" => $country->Name
		);
		$i++;
	}

	echo json_encode($data);