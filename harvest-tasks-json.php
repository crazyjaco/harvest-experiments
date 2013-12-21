<?php

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/HarvestAPI.php');
 
/* Register Auto Loader */
spl_autoload_register(array('HarvestAPI', 'autoload'));

$range = new Harvest_Range( "20131216", "20131222" );

$api = new HarvestAPI();
$api->setUser( USER_EMAIL );
$api->setPassword( USER_PASS );
$api->setAccount( HARVEST_ACCOUNT );
 
$api->setRetryMode( HarvestAPI::RETRY );
$api->setSSL(true);

// Need to dynamically get User ID
$result = $api->getProjects();
if( $result->isSuccess() ){
echo "<pre>";
	var_dump($result);
echo "</pre>";

	//die( json_encode( $tasks_collection ) );

} else {
	die("Error returning tasks!");
}

