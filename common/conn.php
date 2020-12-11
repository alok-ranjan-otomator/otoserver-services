<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$root_directory = $_SERVER['DOCUMENT_ROOT'];
require_once $root_directory.'env/env.php';
require_once $root_directory.'composer/vendor/autoload.php'; // include Composer's autoloader
require_once $root_directory.'common/constants.php';

$server = "mongodb://".$MONGO_SERVER.":".$MONGO_PORT."/".$MONGO_DB_NAME;
$mongo_db_user_name = $MONGO_DB_USER;
$mongo_db_password = $MONGO_DB_PASSWORD;

$params = ["username"=>$mongo_db_user_name, "password"=>$mongo_db_password];
// Connecting to server
$c = new MongoDB\Client( $server, $params );

if ( $c->connected ){
	$db = $c -> $MONGO_DB_NAME;
	// echo "Connected";
}
else {
	// echo "Could not connect";
}


?>
