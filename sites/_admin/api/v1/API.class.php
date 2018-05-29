<?php
/**
*
* Sinsational Portal API
* This API provides a vector for safe communication, and distinct separation, between
* the management portal, and the website for Sinsational Smile.
*
*/
define('API_DEBUG', TRUE); // DEBUG flag

abstract class API
{
	/**
	* Property: method
	* The HTTP method this request was made in, either GET, POST, PUT or DELETE
	*/
	protected $method = '';

	/**
	* Property: endpoint
	* The Model requested in the URI. eg: /files
	*/
	protected $endpoint = '';

	/**
	* Property: verb
	* An optional additional descriptor about the endpoint, used for things that can
	* not be handled by the basic methods. eg: /files/process
	*/
	protected $verb = '';

	/**
	* Property: args
	* Any additional URI components after the endpoint and verb have been removed, in our
	* case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
	* or /<endpoint>/<arg0>
	*/
	protected $args = Array();

	/**
	* Property: file
	* Stores the input of the PUT request
	*/
	protected $file = Null;

	public $debugLine = '';

	/**
	* Constructor: __construct
	* Allow for CORS, assemble and pre-process the data
	*/
	public function __construct($request)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");

		$this->args = explode('/', rtrim($request, '/'));
		$this->endpoint = array_shift($this->args);
		if(array_key_exists(0, $this->args) && !is_numeric($this->args[0]))
			$this->verb = array_shift($this->args);

		$this->method = $_SERVER['REQUEST_METHOD'];
		if($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER))
		{
			if($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE')
				$this->method = 'DELETE';
			else if($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT')
				$this->method = 'PUT';
			else
			{
				if(API_DEBUG)
					throw new Exception('Unexpected Header: '.print_r($_SERVER['HTTP_X_HTTP_METHOD'], true));
				else
					throw new Exception('Unexpected Header.');
			}
		}

		switch($this->method)
		{
			case 'DELETE':
			case 'POST':
				$debugLine = "[API.class.php:91]";
				$input = (array)json_decode(file_get_contents("php://input"));
				$this->request = $this->_cleanInputs($input);
				break;
			case 'GET':
				$this->request = $this->_cleanInputs($_GET);
				break;
			case 'PUT':
				$this->request = $this->_cleanInputs($_GET);
				$this->file = file_get_contents("php://input");
				break;
			default:
				$this->_response('Invalid method', 405);
				break;
		}
	}

	public function processAPI()
	{
		$debugLine = '[API.class.php:100]';

		if(API_DEBUG)
		{
			$file = fopen("processAPI.txt", 'w');
			fwrite($file, "\n\n//--------- [API.class.php:100] ----------//\n\n");
			fwrite($file, "\n\n//---------------- METHOD -----------------//\n\n");
			fwrite($file, print_r($this->method, true)."\n");
			fwrite($file, "\n\n//--------------- ENDPOINT ----------------//\n\n");
			fwrite($file, print_r($this->endpoint, true)."\n");
			fwrite($file, "\n\n//----------------- ARGS ------------------//\n\n");
			fwrite($file, print_r($this->args, true)."\n");
			fwrite($file, "\n\n//----------------- REQUEST ------------------//\n\n");
			fwrite($file, print_r($this->request, true)."\n");
		}

		if(method_exists($this, $this->endpoint))
		{
			return $this->_response($this->{$this->endpoint}($this->args));
		}
		if(API_DEBUG)
			return $this->_response($debugLine." No endpoint: $this->endpoint", 404);
		else
			return $this->_response("No endpoint: $this->endpoint", 404);
	}

	private function _response($data, $status = 200)
	{
		header("HTTP/1.1 ".$status." ".$this->_requestStatus($status));
		return json_encode($data);
	}

	private function _cleanInputs($data)
	{
		$clean_input = Array();

		if(is_array($data))
		{
			foreach($data as $key => $value)
				$clean_input[$key] = $this->_cleanInputs($value);
		}
		else
			$clean_input = trim(strip_tags($data));

		return $clean_input;
	}

	private function _requestStatus($code)
	{
		$status = array(
			200 => 'OK',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			500 => 'Internal Server Error'
		);

		return ($status[$code]) ? $status[$code] : $status[500];
	}
}
