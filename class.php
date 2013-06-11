<?php

    class WP_Countries {
        // get IP
        function get_client_ip(){
            return (empty($_SERVER['HTTP_CLIENT_IP'])?(empty($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['HTTP_CLIENT_IP']);
        }
        // get current country
        function get_client_country( $ip="186.103.135.82", $cookie="wp_countries"  ) {
            if ( empty($ip) ) {
                $ip = $this->get_client_ip();
            }
            if ( isset( $_COOKIE[$cookie] ) ){
                $code = $_COOKIE[$cookie];
            } else {
                $country = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
                $code = $country["iso2"];
                setcookie($cookie, $code);
            }
            return $code;
        }
        // Get Continents
        function get_continents(){
            $array = Array(
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
            sort($array);
            return $array;
        }

        ## Countries
        // Get countries
        function get_countries( $order="Name" ){
            global $wpdb;
            $where = "";
            if ( !empty($code) ){
                $where = "Code = '$code'"; 
            }
            $sql = "SELECT * FROM wp_countries $where ORDER BY $order";
            $countries = $wpdb->get_results( $sql );
            return $countries;
        }
        // Get country
        function get_country($code){
            global $wpdb;
            $sql = "SELECT * FROM wp_countries WHERE Code2 = '" . $_GET["updt"] . "' LIMIT 1";
            $country = $wpdb->get_results( $sql );
            return $country;
        }
        // Update country
        function update_country(){

        }
        // Desactivate country
        function desactivate_country(){

        }
        // Delete country
        function delete_country(){

        }
        // Cities

    };