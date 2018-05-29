{assign var=site value=$smarty.const.ADMIN_SITE}
{assign var=admin_url value=$smarty.const.ADMIN_URL}
{assign var=path value=$smarty.const.ADMIN_PATH}
{include file="$path/templates/header.tpl"}
{if $content == "login"}
	<body class="login">
		<div class="main-login col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4" style="position:relative;">
			{include file="$path/templates/login.tpl"}
	{else}
	<body>
           {include file="$path/templates/nav.tpl"}
{/if}
{if $module|default:''}
	{if $no_rights|default:''}
		<div class="alert alert-danger" style="text-align:center;">You do not have privileges to view this page.</div>
	{else if $module=='practices' or $module=='leads' or $module=='distributors' or $module=='distributor-reps'}
		{include file="$path/templates/manageAssets.tpl"}
	{else}
		{include file="$path/$module/templates/$content.tpl"}
	{/if}
			</div>
		</div>
		<div class="footer clearfix">
			<div class="footer-inner">
				{date('Y')} &copy; Powered By KanaiTek, Inc.
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
	</div>
{/if}
{include file="$path/templates/_modals.tpl"}
<!-- start: MAIN JAVASCRIPTS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--<script src="{$admin_url}assets/js/jquery-2.1.3.min.js"></script>-->
<script src="{$admin_url}assets/plugins/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
<!--<script src="{$admin_url}assets/plugins/bootstrap/js/bootstrap.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="{$admin_url}assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="{$admin_url}assets/plugins/blockUI/jquery.blockUI.js"></script>
<script src="{$admin_url}assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="{$admin_url}assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="{$admin_url}assets/plugins/less/less-1.5.0.min.js"></script>
<script src="{$admin_url}assets/plugins/jquery-cookie/jquery.cookie.js"></script>
{if $module=='email-lists'}
	<script src="{$admin_url}assets/plugins/chosen_v1.8.3/chosen.jquery.min.js"></script>
{/if}
<script src="{$admin_url}assets/js/main.js"></script>
<script src="{$admin_url}assets/js/kanaitek.js"></script>
<script src="{$admin_url}assets/js/modal_calls.js"></script>
{if $asset|default:''}
	<script src="{$admin_url}assets/js/crm.js"></script>
{/if}
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
{if $js|default:''}<script src="{$admin_url}{if $module|default:''}{$module}{else}assets{/if}/js/{$content}.js?v={$smarty.now}"></script>{/if}
{if $maps|default:''}
	<script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script src="{$admin_url}assets/js/StyledMarker.js"></script>
{/if}
{if $ckeditor|default:''}
    <script type="text/javascript" src="{$admin_url}ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{$admin_url}ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript" src="{$admin_url}ckfinder/ckfinder.js"></script>
{/if}
{if $upload|default:''}
    <script type="text/javascript" src="{$admin_url}assets/plugins/plupload/plupload.full.min.js"></script>
    <script type="text/javascript" src="{$admin_url}assets/plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
{/if}
{if $time|default:''}
	<link rel="stylesheet" type="text/css" href="{$admin_url}assets/plugins/timeentry/jquery.timeentry.css">
	<script type="text/javascript" src="{$admin_url}assets/plugins/timeentry/jquery.timeentry.min.js"></script>
{/if}
{if $calendar|default:''}
	<script type="text/javascript" src="{$admin_url}assets/plugins/fullcalendar/fullcalendar.min.js"></script>
{/if}
{$xajax}
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>jQuery(document).ready(function() { Main.init(); });</script>
</body>
	<!-- end: BODY -->
</html>