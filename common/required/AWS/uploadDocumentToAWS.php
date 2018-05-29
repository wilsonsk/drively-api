<?php
	require_once(dirname(dirname(dirname(__DIR__)))."/sites/site_settings.php");
	
	require 'vendor/autoload.php';
	use Aws\Common\Enum\Size;
	use Aws\Common\Exception\MultipartUploadException;
	use Aws\S3\Model\MultipartUpload\UploadBuilder;
	use Aws\S3\S3Client;
	
	//$fh = fopen("aws.txt", 'w');

	if (! empty($argv[1]) && file_exists($argv[1]))
	{
		$file = str_replace("/", "", strrchr($argv[1], "/"));
		$success = 1;
		$client = S3Client::factory(array('key' => AWS_KEY, 'secret' => AWS_SECRET));
		
		//fwrite($fh, "File: ". $file."\nPath: ".$argv[1]);

		$uploader = UploadBuilder::newInstance()
			->setClient($client)
			->setSource($argv[1])
			->setBucket(AWS_BUCKET)
			->setKey($file)
			->setOption('CacheControl', 'max-age=3600')
			->build();
		
		try {
			$uploader->upload();
			$result = $client->putObjectAcl(array('ACL' => 'public-read', 'Bucket' => AWS_BUCKET, 'Key' => $file));
			
		} catch (MultipartUploadException $e) {
			$uploader->abort();
			$success = 0;
			
			//fwrite($fh, "Failed AWS Upload: ".$e->getMessage);
			
			require_once("KanaiTekMailer.class.php");
			$mail = new MyMailer("rgrafton@kanaitek.com", "Randy Grafton");
			$mail->sendSupportMessageDocument($argv[1]);
		}
		echo $success;
	}
	else
	{
		//fwrite($fh, "File Not Found!\n".$argv[1]);
		echo 0;
	}

	//fclose($fh);
?>