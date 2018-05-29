<?php
/* Smarty version 3.1.29, created on 2018-04-09 09:43:29
  from "/data/TEST-drively-api/sites/_admin/templates/header.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5acb98311a0760_74121282',
  'file_dependency' => 
  array (
    'bc2118fdfaf2a8db623d721df485d8bab367439e' => 
    array (
      0 => '/data/TEST-drively-api/sites/_admin/templates/header.tpl',
      1 => 1521591386,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5acb98311a0760_74121282 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 | Sinsational Smile Portal</title>
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
assets/css/theme_dark.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/css/print.css" type="text/css" media="print"/>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/css/custom.css" type="text/css">
		<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['calendar']->value)===null||$tmp==='' ? '' : $tmp)) {?><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/fullcalendar/fullcalendar.print.css" media="print"><?php }?>
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['time']->value)===null||$tmp==='' ? '' : $tmp)) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/timeentry/jquery.timeentry.css"><?php }?>
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['ckeditor']->value)===null||$tmp==='' ? '' : $tmp)) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
ckfinder/css/ckfinder.css"/><?php }?>
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['upload']->value)===null||$tmp==='' ? '' : $tmp)) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css"/><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['module']->value == 'email-lists') {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/chosen_v1.8.3/chosen.css"/><?php }?>
		<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
/favicon.ico" />
		
		<!-- CSS REQUIRED FOR THIS PAGE ONLY -->
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['css']->value)===null||$tmp==='' ? '' : $tmp)) {?><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
if ($_smarty_tpl->tpl_vars['module']->value) {
echo $_smarty_tpl->tpl_vars['module']->value;
} else { ?>assets<?php }?>/css/<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
.css?v=<?php echo time();?>
"><?php }?>
	</head><?php }
}
