<?php
	require_once(dirname(dirname(dirname(__DIR__)))."/sites/site_settings.php");
	require 'vendor/autoload.php';
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	function getAWSFile($scan)
	{
		$result = NULL;
		$client = S3Client::factory(array('key' => AWS_KEY, 'secret' => AWS_SECRET));
	
		try {
			// Get the object
			$result = $client->getObject(array(
				'Bucket' => AWS_BUCKET,
				'Key'    => $scan
			));

			$result;
		} catch (S3Exception $e) {
				echo $e->getMessage() . "\n";
		}
		
		return $result;
	}
?>