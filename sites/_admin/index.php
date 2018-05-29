<?php
	session_start();
	require_once("../site_settings.php");
	
	$myxa = new xajax();
	$myxa->configure('javascript URI', ADMIN_URL."/");
	$myxa->registerfunction("login");
	$myxa->registerfunction("forgotPassword");

	if(isset($_GET['fp']) && strlen($_GET['fp']) == 64)
		$myxa->registerfunction("resetPassword");

	$myxa->configure('debug',XAJAX_DEBUG);
 	$myxa->processRequest();

	if(! isset($_REQUEST['xjxr']))
	{
		$smrty = new MySmarty();
		if(OFFLINE)
		{
			$smrty->assign("title", "Under Maintenance");
			$smrty->assign('content', 'offline');
		}
		else
		{
			$validBrowser = TRUE;
			preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
			if (count($matches)>1)
			{
				if($matches[1] < 9)
				{
					$smrty->assign("title", "Unsupported Browser");
					$smrty->assign('content', 'badBrowser');
					$validBrowser = FALSE;
				}
			}
			if($validBrowser)
			{
				if(isset($_GET['fp']) && strlen($_GET['fp']) == 64)
				{
					require_once("users/ForgotPassword.class.php");
					$fp = new ForgotPassword();
					$fp->checkHash();

					if($fp->data !== NULL)
					{
						$smrty->assign('reset', 1);
						$_SESSION[ADMIN_SITE]['reset-id'] = $fp->data['user_id'];
						$_SESSION[ADMIN_SITE]['reset-ts'] = $fp->data['ts'];
					}
				}

				$smrty->assign("title", "Login To Your Account");
				$smrty->assign('xajax', $myxa->getJavascript());
				$smrty->assign('js', 1);
				$smrty->assign('content', 'login');
			}
		}
		$smrty->display('index.tpl');
	}

	//------------------------------------- XAJAX Functions ---------------------------------------//
	function login($args)
	{
		$objResp = new xajaxResponse();
		require_once("users/User.class.php");
		$p = new User();
		$p->xajax2Post($args);
		$p->login($objResp);
		return $objResp;
	}

	function forgotPassword($email)
	{
		$objResp = new xajaxResponse();
		require_once("users/User.class.php");
		$p = new User();
		$p->forgotPassword($objResp, $email);
		$objResp->call("$.unblockUI");
		return $objResp;
	}

	function resetPassword($pw)
	{
		$objResp = new xajaxResponse();
		require_once("users/ForgotPassword.class.php");
		$fp = new ForgotPassword();
		$curTS = time();
		$with = NULL;

		if(($curTS - $_SESSION[ADMIN_SITE]['reset-ts']) < 1800)
		{
			require_once("users/User.class.php");
			$u = new User($_SESSION[ADMIN_SITE]['reset-id']);
			if($u->data !== NULL)
			{
				$u->updateMyPassword($pw);
				if($u->errors === NULL)
					$objResp->call("showFormMsg", "alert-danger", "alert-success", "Password successfully reset. Please login.");
				else
					$objResp->call("showFormMsg", "alert-success", "alert-danger", "Unable to reset password. Please contact OTE support.");

				$with = "user_id=".$_SESSION[ADMIN_SITE]['reset-id'];
			}
		}
		else
			$objResp->call("showFormMsg", "alert-success", "alert-danger", "The reset request has expired.");

		unset($_SESSION[ADMIN_SITE]['reset-id']);
		unset($_SESSION[ADMIN_SITE]['reset-ts']);
		$objResp->call("$.unblockUI");
		$fp->expireLinks($with);
		$objResp->call("refreshPage");
		return $objResp;
	}
?>
