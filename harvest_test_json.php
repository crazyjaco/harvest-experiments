<?php

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/HarvestAPI.php');
 
/* Register Auto Loader */
spl_autoload_register(array('HarvestAPI', 'autoload'));
 
$api = new HarvestAPI();
$api->setUser( USER_EMAIL );
$api->setPassword( USER_PASS );
$api->setAccount( HARVEST_ACCOUNT );
 
$api->setRetryMode( HarvestAPI::RETRY );
$api->setSSL(true);

$result = $api->getDailyActivity();
if( $result->isSuccess() ){

	$e = 0;
	foreach( $result->data->dayEntries as $entries ){ 
		$entry_collection[$e]["id"] = $entries->get("id");
		$entry_collection[$e]["client"] = $entries->get("client");
		$entry_collection[$e]["project"] = $entries->get("project");
		$entry_collection[$e]["project-id"] = $entries->get("project-id");
		$entry_collection[$e]["task"] = $entries->get("task");
		$entry_collection[$e]["task-id"] = $entries->get("task-id");
		$entry_collection[$e]["hours"] = $entries->get("hours");
		$entry_collection[$e]["hours-without-timer"] = $entries->get("hours-without-timer");
		$entry_collection[$e]["notes"] = $entries->get("notes");
		$entry_collection[$e]["spent-at"] = $entries->get("spent-at");
		$entry_collection[$e]["user-id"] = $entries->get("user-id");
		$entry_collection[$e]["created-at"] = $entries->get("created-at");
		$entry_collection[$e]["updated-at"] = $entries->get("updated-at");
		$e += 1;
	}

	echo "<script>entries=" . json_encode( $entry_collection ) . "</script>";


	$p = 0;
	foreach( $result->data->projects as $projects ){
		$project_collection[$p]["name"]                      = $projects->get("name");
		$project_collection[$p]["code"]                      = $projects->get("code");
		$project_collection[$p]["id"]                        = $projects->get("id");
		$project_collection[$p]["client"]                    = $projects->get("client");
		$project_collection[$p]["client_id"]                 = $projects->get("client_id");
		$project_collection[$p]["client_currency"]           = $projects->get("client_currency");
		$project_collection[$p]["client_currency_symbol"]    = $projects->get("client_currency_symbol");
		$t = 0;
		foreach( $projects->get("tasks") as $tasks ){
			$project_collection[$p]["tasks"][$t]["name"]     = $tasks->get("name");
			$project_collection[$p]["tasks"][$t]["id"]       = $tasks->get("id");
			$project_collection[$p]["tasks"][$t]["billable"] = $tasks->get("billable");
			$t += 1;
		}
		$p += 1;
	}


	echo "<script>projects = " . json_encode( $project_collection ) . "</script>";
	//echo "<script>result = " . json_encode( $result->data->projects ) . "</script>" ;
	//echo json_last_error();
} else {
	die( "error!" );
}

