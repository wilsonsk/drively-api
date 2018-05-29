<?php
	session_start();
	require_once(dirname(__DIR__)."/sites/site_settings.php");

	//Check that the user is logged in and that the file exists
	if(! empty($_SESSION[ADMIN_SITE]['uid']) && isset($_GET['fn']))
	{
		//Original File
		$file = ADMIN_PATH."/purchase-orders/temp/".session_id();
		
		//establish proper mime-type
		$ext = preg_replace('/.+\.([^.]+)$/', '$1', $_GET['fn']);
		$mimeContentType = array("pdf" => "Content-type:application/pdf",
		"jpg" => "image/jpeg", "jpeg" => "image/jpeg",
		"png" => "image/png",
		"xls" => "application/vnd.ms-excel",
		"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
		"pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
		"ppt" => "application/vnd.ms-powerpoint",
		"docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		"doc" => "application/msword",		
		"zip" => "application/zip, application/octet-stream");

		//Set the headers for the download
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0, max-age=0");
		header("Content-Description: File Transfer");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Content-type: ".$mimeContentType[$ext]);
		header("Content-Transfer-Encoding: binary");
		header('Content-disposition: attachment; filename="'.$_GET['fn'].'"');
		header('Content-length: '.filesize($file));

		//Push the file down to the user
		$h = @fopen($file, "rb") or die('');
		while(!feof($h))
		{
			print(fread($h, 8192));
			flush();
			if(connection_status()!=0)
			{
				@fclose($file);
				exit();
			}
		}
		@fclose($h);
	}