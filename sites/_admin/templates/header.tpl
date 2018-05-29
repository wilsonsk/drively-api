<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>{$title} | Sinsational Smile Portal</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="description" content="" />
		<meta name="author" content="KanaiTek, Inc."/>
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<!--><link rel="stylesheet" href="{$admin_url}assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="{$admin_url}assets/plugins/font-awesome/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{$admin_url}assets/fonts/style.css">
		<link rel="stylesheet" href="{$admin_url}assets/css/main.css">
		<link rel="stylesheet" href="{$admin_url}assets/css/main-responsive.css">
		<link rel="stylesheet" href="{$admin_url}assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="{$admin_url}assets/plugins/jquery-ui-1.10.3.custom/css/smoothness/ui.min.css">
		<link rel="stylesheet" href="{$admin_url}assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="{$admin_url}assets/css/theme_dark.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="{$admin_url}assets/css/print.css" type="text/css" media="print"/>
		<link rel="stylesheet" href="{$admin_url}assets/css/custom.css" type="text/css">
		<!--[if IE 7]>
		<link rel="stylesheet" href="{$admin_url}assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		
		{if $calendar|default: ''}<link rel="stylesheet" href="{$admin_url}assets/plugins/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" href="{$admin_url}assets/plugins/fullcalendar/fullcalendar.print.css" media="print">{/if}
		{if $time|default: ''}<link rel="stylesheet" type="text/css" href="{$admin_url}assets/plugins/timeentry/jquery.timeentry.css">{/if}
		{if $ckeditor|default: ''}<link rel="stylesheet" type="text/css" href="{$admin_url}ckfinder/css/ckfinder.css"/>{/if}
		{if $upload|default: ''}<link rel="stylesheet" type="text/css" href="{$admin_url}assets/plugins/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css"/>{/if}
		{if $module=='email-lists'}<link rel="stylesheet" type="text/css" href="{$admin_url}assets/plugins/chosen_v1.8.3/chosen.css"/>{/if}
		<link rel="shortcut icon" href="{$admin_url}/favicon.ico" />
		
		<!-- CSS REQUIRED FOR THIS PAGE ONLY -->
		{if $css|default: ''}<link rel="stylesheet" href="{$admin_url}{if $module}{$module}{else}assets{/if}/css/{$content}.css?v={$smarty.now}">{/if}
	</head>