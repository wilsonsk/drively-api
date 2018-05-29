<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-04-02 15:09:43
         compiled from "/data/sinsational/sites/_admin/templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19441367735ac2aa27a53772-69435623%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a87a25419227e4fcc59187cbd880bae6e59e6ff' => 
    array (
      0 => '/data/sinsational/sites/_admin/templates/header.tpl',
      1 => 1522685938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19441367735ac2aa27a53772-69435623',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'admin_url' => 0,
    'calendar' => 0,
    'time' => 0,
    'ckeditor' => 0,
    'upload' => 0,
    'css' => 0,
    'module' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5ac2aa27a62a39_37571865',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac2aa27a62a39_37571865')) {function content_5ac2aa27a62a39_37571865($_smarty_tpl) {?><!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 | Sinsational Smile Web Portal</title>
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
		<!--><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/font-awesome/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/fonts/style.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/css/main.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/css/main-responsive.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/jquery-ui-1.10.3.custom/css/smoothness/ui.min.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/css/print.css" type="text/css" media="print"/>
		<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		
		<?php if ($_smarty_tpl->tpl_vars['calendar']->value) {?><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/fullcalendar/fullcalendar.print.css" media="print"><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['time']->value) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/timeentry/jquery.timeentry.css"><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['ckeditor']->value) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
ckfinder/css/ckfinder.css"/><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['upload']->value) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css"/><?php }?>
		<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
/favicon.ico" />
		
		<!-- CSS REQUIRED FOR THIS PAGE ONLY -->
		<?php if ($_smarty_tpl->tpl_vars['css']->value) {?><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
if ($_smarty_tpl->tpl_vars['module']->value) {
echo $_smarty_tpl->tpl_vars['module']->value;
} else { ?>assets<?php }?>/css/<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
.css?v=<?php echo time();?>
"><?php }?>
	</head><?php }} ?>
