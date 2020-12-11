<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$root_directory = $_SERVER['DOCUMENT_ROOT'];
require_once $root_directory.'common/conn.php';


function get_ip_location( $decimal_ip ){
    global $IPLOCATION_COLLECTION;
    global $db;

    $collection = $db->$IPLOCATION_COLLECTION;;

    $return_arr = array();
    $return_arr['status'] = 0;
    $return_arr['message'] = "";
    $return_arr['data'] = array();

    try {
        $filter = [ "ip_from"=>[ '$lte' => $decimal_ip ], "ip_to" => [ '$gte' => $decimal_ip ] ];
        $projections['_id'] = 0;
        $cursor = $collection->find( $filter, [ "projection"=>$projections] );
        
        foreach ( $cursor as $doc ) {
            $pet_details = json_decode( json_encode($doc), true );
            array_push($return_arr['data'], $pet_details);
        }

        if ( sizeof($return_arr['data']) > 0 ){
            $return_arr['status'] = 1;
            $return_arr['message'] = "Locations Found";
        }
        else {
            $return_arr['message'] = "No location found";
        }
    }
    catch ( Exception $e ){
        $return_arr['status'] = 0;
        $return_arr['message'] = "Database Error!";
    }
    
    return $return_arr;
}

function convert_ip_to_decimal_ip( $ip ){
    
}

function get_user_ip_address($return_type=NULL)
{
	$ip_addresses = array();
	$ip_elements = array(
		'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
		'HTTP_X_FORWARDED', 'HTTP_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLUSTER_CLIENT_IP',
		'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
		'REMOTE_ADDR'
	);


	foreach ( $ip_elements as $element ) {
		if(isset($_SERVER[$element])) {
			if ( !is_string($_SERVER[$element]) ) {
				// Log the value somehow, to improve the script!
				continue;
			}
			$address_list = explode(',', $_SERVER[$element]);
			$address_list = array_map('trim', $address_list);
			// Not using array_merge in order to preserve order
			foreach ( $address_list as $x ) {
				$ip_addresses[] = $x;
			}
		}
	}


	if ( count($ip_addresses)==0 ) {
		return FALSE;

	} elseif ( $return_type==='array' ) {
		return $ip_addresses;

	} elseif ( $return_type==='single' || $return_type===NULL ) {
		return $ip_addresses[0];
	}

}


?>