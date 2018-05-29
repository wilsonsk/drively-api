<?php
	require_once(dirname(dirname(dirname(__DIR__)))."/sites/site_settings.php");
	require 'vendor/autoload.php';
	use Aws\Common\Enum\Size;
	use Aws\Common\Exception\MultipartUploadException;
	use Aws\S3\Model\MultipartUpload\UploadBuilder;
	use Aws\S3\S3Client;

	if (! empty ($argv[1]))
	{
	    $client = S3Client::factory(array('key' => AWS_KEY, 'secret' => AWS_SECRET));
	    $result = $client->deleteObject(array(
	        // Bucket is required
	        'Bucket' => AWS_BUCKET,
	        // Key is required
	        'Key' => $argv[1]
	    ));
		echo 1;
	}
	else
	    echo 0;

?>