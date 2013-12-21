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

$projects_returned = $api->getProjects();
if( $projects_returned->isSuccess() ){
	foreach( $projects_returned->get("data") as $projects ){
		$projects_collection[$projects->get("id")]["name"] = $projects->get("name");
		$projects_collection[$projects->get("id")]["billable"] = $projects->get("billable");
	}
}

// Need to dynamically get User ID
$result = $api->getUserEntries( 498782, $range );
if( $result->isSuccess() ){

	$e = 0;
	foreach( $result->data as $entries ){ 
		$entry_collection[$e]["adjustment-record"] = $entries->get("adjustment-record");
		$entry_collection[$e]["created-at"]        = $entries->get("created-at");
		$entry_collection[$e]["hours"]             = $entries->get("hours");
		$entry_collection[$e]["id"]                = $entries->get("id");
		$entry_collection[$e]["is-closed"]         = $entries->get("is-closed");
		$entry_collection[$e]["notes"]             = $entries->get("notes");
		$entry_collection[$e]["spent-at"]          = $entries->get("spent-at");
		$entry_collection[$e]["task-id"]           = $entries->get("task-id");
		$entry_collection[$e]["timer-started-at"]  = $entries->get("timer-started-at");
		$entry_collection[$e]["updated-at"]        = $entries->get("updated-at");
		$entry_collection[$e]["user-id"]           = $entries->get("user-id");
		$entry_collection[$e]["is-billed"]         = $entries->get("is-billed");
		$entry_collection[$e]["project-id"]        = $entries->get("project-id");
		if( array_key_exists( $entries->get("project-id"), $projects_collection ) ){
			$entry_collection[$e]["project-name"]      = $projects_collection[$entries->get("project-id")]["name"];
			$entry_collection[$e]["project-billable"]  = $projects_collection[$entries->get("project-id")]["billable"];
		} else {
			$entry_collection[$e]["project-name"]      = "";
			$entry_collection[$e]["project-billable"]  = false;			
		}
		$e += 1;
	}
	//$output["entries"] = $entry_collection;

	die( json_encode( $entry_collection ) );

	//echo "<script>result = " . json_encode( $result->data->projects ) . "</script>" ;
	//echo json_last_error();
} else {
	die( "error!" );
}

