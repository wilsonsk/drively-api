<?php
/* Smarty version 3.1.29, created on 2018-04-02 15:16:49
  from "/data/sinsational-portal/sites/_admin/templates/_modals.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5ac2abd1e14aa3_52716772',
  'file_dependency' => 
  array (
    '14173ed080dcd08c78fc544b83685265d80a49b3' => 
    array (
      0 => '/data/sinsational-portal/sites/_admin/templates/_modals.tpl',
      1 => 1516832790,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ac2abd1e14aa3_52716772 ($_smarty_tpl) {
?>
	<div id="comingSoonModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Module In Progress</h4>
				</div>
				<div class="modal-body text-center">
					<img src="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
assets/img/black-logo.png" alt="Sinsational Smile&copy; Premium Teeth Whitening System" style="display: block; margin: 0 auto; margin-top: 50px; margin-bottom: 50px;">
					<i class="fa fa-spinner fa-spin fa-2x"></i> <h3 style="display: inline;">This module is still being built. Check back soon!</h3>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php }
}
