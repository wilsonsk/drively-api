<?php
	define('ADMIN_SITE', 'SINSATIONAL_PORTAL');
	define('COMPANY', 'Sinsational Smile');
	date_default_timezone_set("America/Los_Angeles");
	setlocale(LC_MONETARY, 'en_US');
	define('XAJAX_DEBUG', TRUE);
	define('OFFLINE', FALSE);
	define('TIMEZONE', "America/Los_Angeles");

	// ini_set('error_reporting', E_ALL);
	// ini_set('display_errors', 'On');
	// ini_set('display_startup_errors', 'On');

	/*************** DEV SETTINGS ****************/
		define('CONTAINER_PATH', '/data/TEST-drively-api'); // change this after initial setup
		define('ADMIN_URL', 'http://ua/TEST-drively-api/sites/_admin/');
		define('WEBSITE_URL', 'http://ua/TEST-drively-api/sites/_public');

		define('TEST_EMAIL', 'swilson@kanaitek.com');
		define('TEST_EMAIL_NAME', 'Sky Wilson');

		define('MYSQL_USER', 'root');
		define('MYSQL_PASSWORD', '!kt@ccess');
		define('MYSQL_SERVER', 'localhost');
		define('MYSQL_DB', 'test_drively_api');

	/*************** URL AND PATH SETTINGS ****************/
	define('SITE_PATH', CONTAINER_PATH.'/sites');
	define('ADMIN_PATH', SITE_PATH.'/_admin');
	define('PUBLIC_PATH', SITE_PATH.'/_public');

	/*************** INCLUDES AND INCLUDE PATH SETTINGS ****************/
	set_include_path(get_include_path().PATH_SEPARATOR.CONTAINER_PATH.'/common/required');
	set_include_path(get_include_path().PATH_SEPARATOR.CONTAINER_PATH.'/modules');
	set_include_path(get_include_path().PATH_SEPARATOR.CONTAINER_PATH.'/common/required/smarty/libs/');
	require_once('KanaiTekSmarty.class.php');
	require_once('xajax_0.5/xajaxAIO.inc.php');

	/*************** UPLOAD SETTINGS ****************/
	define('MAX_FILE_SIZE', 10485760);

	/*****  EMAIL/CUSTOMER SETTINGS  *****/
	define('SMTP_HOST', 'smtp.gmail.com');
	define('SMTP_PORT', 465);
	define('SMTP_NAME', 'Sinsational Smile');
	define('SMTP_USERNAME', 'swilson@kanaitek.com');
	define('SMTP_PASSWORD', 'ioN0t1fy!');
	define('SMTP_SECURE', 'ssl');
	//define('CONTACT_NOTIFY_EMAIL', "info@sinsationalsmile.com"); // CHANGE BEFORE DEPLOYMENT
	//define('CONTACT_NOTIFY_NAME', "Sinsational Smile");

	/*****  MISCELLANEOUS CONSTANTS  *****/
	define('ITEMS_PER_PAGE', 20);
	define('DPI', 72);
	define('MB', 1048576);
	define('IMAGE_MAX_WIDTH', 400);
	define('IMAGE_MAX_HEIGHT', 325);

	/*****  CORE / DATABASE CONSTANTS  *****/
	define('INSERT', 1);
	define('UPDATE', 2);
	define('DELETE', 3);
	define('ROW_COUNT', 4);
	define('SELECT_SINGLE', 5);
	define('SELECT_MULTI', 6);
	define('SELECT_MULTI_SINGLE_COL', 7);
	define('MULTI_INSERT', 8);
	define('SIGNUP', 9);
	define('SIGNUP_VALIDATE', 10);
	define('MEMBER_UPDATE', 11);
	define('DEBUG_SQL', TRUE);

	/*****  GENERAL PURPOSE FUNCTIONS  *****/
	require_once('functions.php');
