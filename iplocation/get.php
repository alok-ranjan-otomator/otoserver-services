<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$root_directory = $_SERVER['DOCUMENT_ROOT'];
require_once $root_directory.'iplocation/lib/iplocation.php';

$response = array();
$response['status'] = 0;
$response['message'] = "";
$response['data'] = array();

$client_ip = $_SERVER['REMOTE_ADDR'];

$decimal_ip = ip2long ( $client_ip );

$get_location = get_ip_location( $decimal_ip );

if ( $get_location['status'] == 1 ){
    $response['status'] = 1;
    $response['message'] = "Location Found";
    $response['data']['ip'] = $client_ip;
    
    $ip_location = $get_location['data'][0];
    unset( $ip_location['ip_from'] );
    unset( $ip_location['ip_to'] );

    $response['data']['location'] = $ip_location;
    
}
else {
    $response['status'] = 0;
    $response['message'] = "Location Not Found";
}

echo json_encode( $response );

?>