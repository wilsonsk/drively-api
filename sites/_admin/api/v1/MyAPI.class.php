<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 'On');
// ini_set('display_startup_errors', 'On');

require_once 'API.class.php';
class MyAPI extends API
{
	public function __construct($request, $origin)
	{
		parent::__construct($request);

		// if(!array_key_exists('apiKey', $this->request))
		// 	throw new Exception('No API Key provided.');
		// else if (!$this->verifyKey($this->request['apiKey'], $origin))
		// 	throw new Exception('Invalid API Key');
	}

	protected function checkCompanyCode() {
		$args = explode("/", $this->request['request']);
		$company = $args[1];
		$code = $args[2];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$comp->checkCompanyCode($company, $code);

		if($comp->data) {
			$jwt = $comp->createAuthToken($comp->data);
			return $jwt;
		} else {
			return 0;
		}
	}

	protected function isTokenExpired() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
    $token = $headers['Authorization'];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$result = $comp->isTokenExpired($token);
			return $result;
		} else {
			return 0;
		}
	}

	public function getCompanyFromToken() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
    $token = $headers['Authorization'];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$expired = $comp->isTokenExpired($token);
			if(!$expired) {
				$company = $comp->getCompanyFromToken($token);
				return $company;
			}
		}
		return 0;
	}

	protected function driverLogin() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
    $token = $headers['Authorization'];

		$args = explode("/", $this->request['request']);
		$username = $args[1];
		$passwd = $args[2];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$expired = $comp->isTokenExpired($token);
			if(!$expired) {
				$token_values = explode('.', $token);
				$payload = $token_values[1];
				$payload = base64_decode($payload);
				$payload = json_decode($payload);
				$companyID = $payload[0]->id;

				require_once 'companies/Driver.class.php';
				$driver = new Driver();
				$driver->findDriver($companyID, $username, $passwd);

				if($driver->data) {
					return $driver->data;
				}
			}
		}
		return 0;
	}

	public function driverClockIn() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
		$token = $headers['Authorization'];

		$args = explode("/", $this->request['request']);
		$username = $args[1];
		$passwd = $args[2];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$expired = $comp->isTokenExpired($token);
			if(!$expired) {
				require_once 'companies/Driver.class.php';
				$driver = new Driver();
				$response = $driver->clockIn($companyID, $username, $passwd);

				if($response) {
					return $response;
				}
			}
		}
		return 0;
	}

	public function submitInspection() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
		$token = $headers['Authorization'];

		// $args = explode("/", $this->request['request']);
		// $username = $args[1];
		// $passwd = $args[2];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$expired = $comp->isTokenExpired($token);
			if(!$expired) {
				return $this->request;
			}
		}
		return 0;
	}

	public function uploadInspectionImage() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
		$token = $headers['Authorization'];

		// $args = explode("/", $this->request['request']);
		// $username = $args[1];
		// $passwd = $args[2];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$expired = $comp->isTokenExpired($token);
			if(!$expired) {
				return $token;
			}
		}
		return 0;
	}

	public function getDriverSchedule() {
		// Enable auth headers
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		$headers = apache_request_headers();
		$token = $headers['Authorization'];

		// $args = explode("/", $this->request['request']);
		// $username = $args[1];
		// $passwd = $args[2];

		require_once 'companies/Company.class.php';
		$comp = new Company();
		$verified = $comp->verifyAuthToken($token);

		if($verified) {
			$expired = $comp->isTokenExpired($token);
			if(!$expired) {
				$arr = array(
					'Trip 1',
					'Trip 2',
					'Trip 3'
				);

				// $arr = json_encode($arr);

				return $arr;
			}
		}
		return 0;
	}
}
