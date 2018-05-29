<?php
//	Check the user's admin session
function checkAdminSession(&$objResp = NULL){
	if(isset($_REQUEST['xjxr'])){
		$ret = TRUE;
		if(! isset($_SESSION[ADMIN_SITE]['uid'])){
			$objResp->redirect(ADMIN_URL."?st=1");
			$ret = FALSE;
		}
		return $ret;
	}
	else{
		if(! isset($_SESSION[ADMIN_SITE]['uid']))
			header("Location: " . ADMIN_URL);
	}
}

//	Check the user's public session
function checkPublicSession(&$objResp = NULL){
	if(isset($_REQUEST['xjxr'])){
		$ret = TRUE;
		if(!isset($_SESSION[PUBLIC_SITE]['uid'])){
			$objResp->redirect(PUBLIC_URL);
			$ret = FALSE;
		}
		return $ret;
	}
	else{
		if(!isset($_SESSION[PUBLIC_SITE]['uid']))
			header("Location: " . PUBLIC_URL);
	}
}

// Confirm Admin is logged in
function checkIfAdminLoggedIn()
{
	$ret = TRUE;
	if(! isset($_SESSION[ADMIN_SITE]['uid']))
		$ret = FALSE;
	else
	{
		if(! isset($_SESSION['timer']))
			$ret = FALSE;
		else
		{
			if(($_SESSION['timer'] + $_SESSION[ADMIN_SITE]['timeout']) < time())
				$ret = FALSE;
			else
				$_SESSION['timer'] = time();
		}
	}
	
	return $ret;
}

// Confirm a public account is logged in
function checkIfPublicLoggedIn()
{
	$ret = TRUE;
	if(! isset($_SESSION[PUBLIC_SITE]['uid']))
		$ret = FALSE;
	else
	{
		if(! isset($_SESSION['timer']))
			$ret = FALSE;
		else
		{
			if(($_SESSION['timer'] + $_SESSION[PUBLIC_SITE]['timeout']) < time())
				$ret = FALSE;
			else
				$_SESSION['timer'] = time();
		}
	}
	
	return $ret;
}

//	Cleans up the filename for files that are uploaded by a user
function cleanFilename($fname){
	$fname = preg_replace("/[^[:alnum:]|^\- _\.]/", '', $fname);
	$fname = strtolower(preg_replace('/[-|\s]+/','-',$fname));
	return $fname;
}

//	Create names to be compatible with URL titles
function makeURLFriendly($pre_title){
	$symbol_swap = array('symbols' => array('%', '&', '&amp;'), 'words' => array(' percent ', 'and', 'and'));
 	$post_title = str_replace($symbol_swap['symbols'], $symbol_swap['words'], stripslashes($pre_title));
 	$post_title = ereg_replace("[^A-Za-z0-9 -]", '', $post_title);
 	$post_title = strtolower(preg_replace('/[-|\s]+/','-', $post_title));
	return $post_title;
}

// Empty a directory, e.g. temp/
function emptyDirectory($path){
	if(!$dh = @opendir($path)) return;
    while (false !== ($obj = readdir($dh))) {
        if($obj == '.' || $obj == '..' || $obj == '.gitkeep') continue;
        @unlink($path.'/'.$obj);
    }
    closedir($dh);
    @rmdir($path);
}

// Scale image
function saveMultiSizePicture(&$fname, $path, &$dims=NULL,$tmp){
    $fname = substr($fname, 0, strlen($fname)-4);
    $source_pic = cleanFilename($_FILES['file']['name']);
    if(! file_exists($path)){
        throw new Exception("Path does not exist: ".$path);
        return false;
    }

    //Calculate new image dimensions while keeping aspect ratio
    list($width,$height)=$tmp;
    $_full = getNewImageSize($width, $height);
    $dims = array (($_full[0] * 0.75), ($_full[1] * 0.75));

    //Create 3 image sizes
    $img = new Imagick();
    $img->readImage($path.$source_pic);
    $img->resizeImage($_full[0], $_full[1],Imagick::FILTER_LANCZOS,1);
    $img->writeImage($path.$fname.'_medium.jpg');
    $img->resizeImage(($_full[0] * 1.25), ($_full[1] * 1.25),Imagick::FILTER_LANCZOS,1);
    $img->writeImage($path.$fname.'_large.jpg');
    $img->resizeImage(($_full[0] * .75), ($_full[1] * .75),Imagick::FILTER_LANCZOS,1);
    $img->writeImage($path.$fname.'_small.jpg');
    $img->clear();
    $img->destroy();

    return (file_exists($path.$fname.'_small.jpg') && file_exists($path.$fname.'_medium.jpg') && file_exists($path.$fname.'_large.jpg'));
}

// Save full size and thumbnail size of image
function savePicture(&$fname, $path, $thumb, &$_full=null){
    $fname = substr($fname, 0, strlen($fname)-4).".jpg";
    $source_pic = $_FILES['file']['tmp_name'];
    //$path = HOME_PATH."/page-images/";

    //Calculate new image dimensions while keeping aspect ratio
    list($width,$height)=getimagesize($source_pic);
    $_full = getNewImageSize($width, $height);

    //Create full and thumbnail images if gallery pict, else resize as necessary and move to folder
    $img = new Imagick();
    $img->readImage($source_pic);
    $img->resizeImage($_full[0], $_full[1],Imagick::FILTER_LANCZOS,1);
    $img->writeImage($path.(($thumb)?str_replace('.jpg', '_full.jpg', $fname):$fname));
    if($thumb){
        $_thumb = getNewThumbSize($width, $height);
        $img->resizeImage($_thumb[0], $_thumb[1],Imagick::FILTER_LANCZOS,1);
        $img->writeImage($path.str_replace('.jpg', '_thumb.jpg',$fname));
    }
    $img->clear();
    $img->destroy();
    if($thumb)
        return file_exists($path.str_replace('.jpg', '_full.jpg', $fname));
    else
        return file_exists($path.$fname);
}

// Calculate an image's size without skewing the aspect ratio
function getNewImageSize($width, $height){
	$x_ratio = IMAGE_MAX_WIDTH / $width;
	$y_ratio = IMAGE_MAX_HEIGHT / $height;
	
	if( ($width <= IMAGE_MAX_WIDTH) && ($height <= IMAGE_MAX_HEIGHT) ){
	    $tn_width = $width;
	    $tn_height = $height;
	    }elseif (($x_ratio * $height) < IMAGE_MAX_HEIGHT){
	        $tn_height = ceil($x_ratio * $height);
	        $tn_width = IMAGE_MAX_WIDTH;
	    }else{
	        $tn_width = ceil($y_ratio * $width);
	        $tn_height = IMAGE_MAX_HEIGHT;
	}
	return array($tn_width, $tn_height);
}

// Calculate a necessary thumbnail size without skewing the aspect ratio
function getNewThumbSize($width, $height){
	$x_ratio = (0.4 * IMAGE_MAX_WIDTH) / $width;
	$y_ratio = (0.4 * IMAGE_MAX_HEIGHT) / $height;
	
	if( ($width <= (0.4 * IMAGE_MAX_WIDTH)) && ($height <= (0.4 * IMAGE_MAX_HEIGHT)) ){
	    $tn_width = $width;
	    $tn_height = $height;
	    }elseif (($x_ratio * $height) < (0.4 * IMAGE_MAX_HEIGHT)){
	        $tn_height = ceil($x_ratio * $height);
	        $tn_width = (0.4 * IMAGE_MAX_WIDTH);
	    }else{
	        $tn_width = ceil($y_ratio * $width);
	        $tn_height = (0.4 * IMAGE_MAX_HEIGHT);
	}
	return array($tn_width, $tn_height);
}

// Empties the the folder for holding uploaded files that are older than 5 minutes
function removeTempFiles($path){
    if(is_dir($path))
    {
        $objs = scandir($path);
        if($objs)
        {
            $cur_time = (time() - 300);
            foreach($objs as $obj)
            {
                if($obj == '.' || $obj == '..' || $obj == '.gitkeep') continue;
                if(filemtime($path.$obj) < $cur_time)
                    @unlink($path.$obj);
            }
        }
    }
}

// Parse a phone/fax/mobile number for storage in the database
function parsePhoneFax($number)
{
	$number = preg_replace('/[^\d]/', '', $number);
	return preg_replace("/(\d{3})(\d{3})(\d{4})/", "$1-$2-$3", $number);
}

// Sanitize and validate email
function sanitizeEmail($email)
{
	$temp = $email;
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if($email == $temp && filter_var($email, FILTER_VALIDATE_EMAIL))
		return true;
	return false;
}
