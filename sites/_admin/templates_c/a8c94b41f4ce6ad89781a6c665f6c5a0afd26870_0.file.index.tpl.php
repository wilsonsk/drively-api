<?php
/* Smarty version 3.1.29, created on 2018-04-09 09:43:29
  from "/data/TEST-drively-api/sites/_admin/templates/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5acb9831186023_65366267',
  'file_dependency' => 
  array (
    'a8c94b41f4ce6ad89781a6c665f6c5a0afd26870' => 
    array (
      0 => '/data/TEST-drively-api/sites/_admin/templates/index.tpl',
      1 => 1521591386,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5acb9831186023_65366267 ($_smarty_tpl) {
$_smarty_tpl->tpl_vars['site'] = new Smarty_Variable(@constant('ADMIN_SITE'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'site', 0);
$_smarty_tpl->tpl_vars['admin_url'] = new Smarty_Variable(@constant('ADMIN_URL'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'admin_url', 0);
$_smarty_tpl->tpl_vars['path'] = new Smarty_Variable(@constant('ADMIN_PATH'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'path', 0);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['path']->value)."/templates/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php if ($_smarty_tpl->tpl_vars['content']->value == "login") {?>
	<body class="login">
		<div class="main-login col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4" style="position:relative;">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['path']->value)."/templates/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<?php } else { ?>
	<body>
           <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['path']->value)."/templates/nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
if ((($tmp = @$_smarty_tpl->tpl_vars['module']->value)===null||$tmp==='' ? '' : $tmp)) {?>
	<?php if ((($tmp = @$_smarty_tpl->tpl_vars['no_rights']->value)===null||$tmp==='' ? '' : $tmp)) {?>
		<div class="alert alert-danger" style="text-align:center;">You do not have privileges to view this page.</div>
	<?php } elseif ($_smarty_tpl->tpl_vars['module']->value == 'practices' || $_smarty_tpl->tpl_vars['module']->value == 'leads' || $_smarty_tpl->tpl_vars['module']->value == 'distributors' || $_smarty_tpl->tpl_vars['module']->value == 'distributor-reps') {?>
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['path']->value)."/templates/manageAssets.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<?php } else { ?>
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['path']->value)."/".((string)$_smarty_tpl->tpl_vars['module']->value)."/templates/".((string)$_smarty_tpl->tpl_vars['content']->value).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<?php }?>
			</div>
		</div>
		<div class="footer clearfix">
			<div class="footer-inner">
				<?php echo date('Y');?>
 &copy; Powered By KanaiTek, Inc.
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
	</div>
<?php }
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['path']->value)."/templates/_modals.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<!-- start: MAIN JAVASCRIPTS -->
<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"><?php echo '</script'; ?>
>
<!--<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/js/jquery-2.1.3.min.js"><?php echo '</script'; ?>
>-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"><?php echo '</script'; ?>
>
<!--<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>-->
<?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/blockUI/jquery.blockUI.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/less/less-1.5.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/jquery-cookie/jquery.cookie.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['module']->value == 'email-lists') {?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/chosen_v1.8.3/chosen.jquery.min.js"><?php echo '</script'; ?>
>
<?php }
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/js/main.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/js/kanaitek.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/js/modal_calls.js"><?php echo '</script'; ?>
>
<?php if ((($tmp = @$_smarty_tpl->tpl_vars['asset']->value)===null||$tmp==='' ? '' : $tmp)) {?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/js/crm.js"><?php echo '</script'; ?>
>
<?php }?>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<?php if ((($tmp = @$_smarty_tpl->tpl_vars['js']->value)===null||$tmp==='' ? '' : $tmp)) {
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
if ((($tmp = @$_smarty_tpl->tpl_vars['module']->value)===null||$tmp==='' ? '' : $tmp)) {
echo $_smarty_tpl->tpl_vars['module']->value;
} else { ?>assets<?php }?>/js/<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
.js?v=<?php echo time();?>
"><?php echo '</script'; ?>
><?php }
if ((($tmp = @$_smarty_tpl->tpl_vars['maps']->value)===null||$tmp==='' ? '' : $tmp)) {?>
	<?php echo '<script'; ?>
 src="https://maps.googleapis.com/maps/api/js?sensor=true"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/js/StyledMarker.js"><?php echo '</script'; ?>
>
<?php }
if ((($tmp = @$_smarty_tpl->tpl_vars['ckeditor']->value)===null||$tmp==='' ? '' : $tmp)) {?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
ckeditor/adapters/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
ckfinder/ckfinder.js"><?php echo '</script'; ?>
>
<?php }
if ((($tmp = @$_smarty_tpl->tpl_vars['upload']->value)===null||$tmp==='' ? '' : $tmp)) {?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/plupload/plupload.full.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.js"><?php echo '</script'; ?>
>
<?php }
if ((($tmp = @$_smarty_tpl->tpl_vars['time']->value)===null||$tmp==='' ? '' : $tmp)) {?>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/timeentry/jquery.timeentry.css">
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/timeentry/jquery.timeentry.min.js"><?php echo '</script'; ?>
>
<?php }
if ((($tmp = @$_smarty_tpl->tpl_vars['calendar']->value)===null||$tmp==='' ? '' : $tmp)) {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/plugins/fullcalendar/fullcalendar.min.js"><?php echo '</script'; ?>
>
<?php }
echo $_smarty_tpl->tpl_vars['xajax']->value;?>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<?php echo '<script'; ?>
>jQuery(document).ready(function() { Main.init(); });<?php echo '</script'; ?>
>
</body>
	<!-- end: BODY -->
</html><?php }
}
