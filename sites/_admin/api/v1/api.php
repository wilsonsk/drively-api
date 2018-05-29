<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 'On');
// ini_set('display_startup_errors', 'On');

/**
* Output the request in its entirety so we can see what's happening.
*/

if(API_DEBUG)
{
	$input = json_decode(file_get_contents("php://input"));
	$file = fopen("debugAPI.txt", 'w');
	fwrite($file, "//------------------FILES------------------//\n\n");
	fwrite($file, print_r($_FILES, true)."\n");
	fwrite($file, "\n\n//------------------SERVER-----------------//\n\n");
	fwrite($file, print_r($_SERVER,true)."\n");
	fwrite($file, "\n\n//-----------------REQUEST-----------------//\n\n");
	fwrite($file, print_r($_REQUEST,true)."\n");
	fwrite($file, "\n\n//-------------------GET-------------------//\n\n");
	fwrite($file, print_r($_GET,true)."\n");
	fwrite($file, "\n\n//------------------POST-----------------//\n\n");
	fwrite($file, print_r($_POST,true)."\n");
	fwrite($file, "\n\n//----------------RAW POST-----------------//\n\n");
	fwrite($file, print_r($input, true));
	fclose($file);

}

/**
* Construct URLs for API as: https://[URL]/api/v1/[request]?apiKey=[KEY]&[args]
*/

require_once 'MyAPI.class.php';
require_once dirname(dirname(dirname(__DIR__))).'/site_settings.php';

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
	$_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}
try {
	$API = new MyAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
	echo $API->processAPI();
}
catch (Exception $e)
{
	echo json_encode(Array('error' => $e->getMessage()));
}
