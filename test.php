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
 
//$result = $api->getProjects( );
//if( $result->isSuccess() ) {
//    foreach( $result->data as $project ) {
//    	//var_dump($project);
//        echo "Name: " . $project->get( "name" ) . "<br/>";
//        echo "Billable: " . $project->billable . "<br/>";
//        echo "Active: " . $project->active . "<br/>";
//    }
//}

echo "==================";

$result2 = $api->getDailyActivity();
if( $result2->isSuccess() ){
	echo "DAY: " . $result2->data->get("forDay") . "<br/><br/><br/>";	
	echo "Entries<br/>";
	echo "====================";
	
	foreach( $result2->data->dayEntries as $entries ){ 
		echo "ID: " . $entries->get("id") . "<br/>";
		echo "Client: " . $entries->get("client") . "<br/>";
		echo "Project: " . $entries->get("project") . "<br/>";
		echo "Project ID: " . $entries->get("project-id") . "<br/>";
		echo "Task: " . $entries->get("task") . "<br/>";
		echo "Task ID: " . $entries->get("task-id") . "<br/>";
		echo "Hours: " . $entries->get("hours") . "<br/>";
		echo "Hours-without-timer: " . $entries->get("hours-without-timer") . "<br/>";
		echo "Notes: " . $entries->get("notes") . "<br/>";
		echo "Spent-at: " . $entries->get("spent-at") . "<br/>";
		echo "user-id: " . $entries->get("user-id") . "<br/>";
		echo "created-at: " . $entries->get("created-at") . "<br/>";
		echo "updated-at: " . $entries->get("updated-at") . "<br/>";
		echo "---<br/>";
	}

	foreach( $result2->data->projects as $projects ){
		echo "Name: " . $projects->get("name") . "<br/>";
		echo "Code: " . $projects->get("code") . "<br/>";
		echo "ID: " . $projects->get("id") . "<br/>";
		echo "Client: " . $projects->get("client") . "<br/>";
		echo "Client_id: " . $projects->get("client_id") . "<br/>";
		echo "Client_currency: " . $projects->get("client_currency") . "<br/>";
		echo "client_currency_symbol: " . $projects->get("client_currency_symbol") . "<br/>";
		echo "TASKS: <br/>";
		foreach( $projects->get("tasks") as $tasks ){
			echo "&nbsp;&nbsp;Name: " . $tasks->get("name") . "<br/>";
			echo "&nbsp;&nbsp;ID: " . $tasks->get("id") . "<br/>";
			echo "&nbsp;&nbsp;Billable: " . $tasks->get("billable") . "<br/>";
			echo "&nbsp;&nbsp;---<br/>";
		}
	}
}

// Check in HApi to git and composerfy
// Check out laravel for interface.
