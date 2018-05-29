<div class="navbar navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="clip-list-2"></span>
			</button>
			<img src="{$admin_url}assets/img/admin-logo.png" style="margin:1px 0;"/>
		</div>
		<div class="navbar-tools">
			<ul class="nav navbar-right">
				<li>
					<a href="{$admin_url}logout.php">
						<i class="fa fa-power-off"></i> Logout {$smarty.session[$smarty.const.ADMIN_SITE].uname} <span id="timer" data-to="{$timeOut}">{$displayTimer}</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="main-container">
	<div class="navbar-content">
		<div class="main-navigation navbar-collapse collapse">
			<div class="navigation-toggler">
				<i class="clip-chevron-left"></i>
				<i class="clip-chevron-right"></i>
			</div>
			<ul class="main-navigation-menu">
				{if $smarty.session[{$smarty.const.ADMIN_SITE}].permissions & $smarty.const.ADMIN ||  $smarty.session[{$smarty.const.ADMIN_SITE}].permissions & $smarty.const.SITE_MGR_NO_DELETE}
				<li class="{if $nav_group == 'crm'} open selected{/if}">
					<a href="javascript:void(0)"><i class="fa fa-building"></i><span class="title">CRM</span><i class="icon-arrow"></i></a>
					<ul class="sub-menu" {if $nav_group == 'crm'}style="display:block;{/if}">
						<li class="{if $nav_tab == 'registrations'}active{/if}">
							<a href="{$admin_url}registrations/"><i class="fa fa-clipboard"></i> Registrations{if $nav_tab == 'registrations'}<span class="selected"></span>{/if}</a>
						</li>
						<li class="{if $nav_tab == 'leads'}active{/if}">
							<a href="{$admin_url}leads/"><i class="fa fa-binoculars {if $nav_tab == 'leads'} selected{/if}"></i> Leads </a>
						</li>
						<li class="{if $nav_tab == 'practices'}active{/if}">
							<a href="{$admin_url}practices/"><i class="fa fa-building {if $nav_tab == 'practices'}selected{/if}"></i> Practices </a>
						</li>
						<li class="{if $nav_tab == 'distributors'}active{/if}">
							<a href="{$admin_url}distributors/"><i class="fa fa-truck {if $nav_tab == 'distributors'} selected{/if}"></i> Distributors </a>
						</li>
						<li class="{if $nav_tab == 'distributor-rep'}active{/if}">
							<a href="{$admin_url}distributor-reps/"><i class="fa fa-archive {if $nav_tab == 'distributor-rep'}selected{/if}"></i> Distributor/Rep </a>
						</li>
					</ul>
				</li>
				<li class="{if $nav_tab == 'tasks'}active{/if}">
					<a href="{$admin_url}tasks"><i class="fa fa-th-list"></i>
						<span class="title">Tasks</span>{if $nav_tab == 'tasks'}<span class="selected"></span>{/if}
					</a>
				</li>
				<li class="{if $nav_tab == 'purchase-orders'}active{/if}">
					<a href="{$admin_url}purchase-orders/"><i class="fa fa-cubes"></i> 
						<span class="title">Purchase Orders</span>{if $nav_tab == 'purchase-orders'}<span class="selected"></span>{/if}
					</a>
				</li>
				<li class="{if $nav_tab == 'documents'}active{/if}">
					<a href="{$admin_url}documents"><i class="fa fa-file-text-o"></i>
						<span class="title">Documents</span>{if $nav_tab == 'documents'}<span class="selected"></span>{/if}
					</a>
				</li>
				<li class="{if $nav_tab == 'products'}active{/if}">
					<a href="{$admin_url}products/"><i class="fa fa-cube"></i> 
						<span class="title">Products</span>{if $nav_tab == 'products'}<span class="selected"></span>{/if}
					</a>
				</li>
				<li{if $nav_group == 'email_campaigns'} class="open"{/if}>
					<a href="javascript:void(0)"><i class="fa fa-envelope-o"></i>
						<span class="title"> Email Campaigns</span><i class="icon-arrow"></i>
						{if $nav_group == 'email_campaigns'}<span class="selected"></span>{/if}
					</a>
					<ul class="sub-menu"{if $nav_group== 'email_campaigns'} style="display:block;"{/if}>
						<li {if $nav_tab == 'start_email_campaign'}class="active open"{/if}>
							<a href="{$admin_url}start-campaign/"><i class="fa fa-send"></i> Start Campaign{if $nav_tab == 'start_email_campaign'}<span class="selected"></span>{/if}</a>
						</li>
						<li {if $nav_tab == 'email_lists'}class="active open"{/if}>
							<a href="{$admin_url}email-lists/"><i class="fa fa-list-alt"></i> Email Lists{if $nav_tab == 'email_lists'}<span class="selected"></span>{/if}</a>
						</li>
						<li {if $nav_tab == 'email_templates'}class="active open"{/if}>
							<a href="{$admin_url}email-templates/"><i class="fa fa-laptop"></i> Email Templates{if $nav_tab == 'email_templates'}<span class="selected"></span>{/if}</a>
						</li>
					</ul>
				</li>
				{/if}
				{if $smarty.session[{$smarty.const.ADMIN_SITE}].permissions & $smarty.const.ADMIN}
				<li class="{if $nav_tab == 'dp-settings'}active{/if}">
					<a href="{$admin_url}dp-settings/"><i class="fa fa-gears"></i>
						<span class="title">Doc/Proc Settings</span>{if $nav_tab == 'dp-settings'}<span class="selected"></span>{/if}
					</a>
				</li>
				<li class="{if $nav_tab == 'users'}active{/if}">
					<a href="{$admin_url}users/"><i class="fa fa-lock"></i>
						<span class="title">System Accounts</span>{if $nav_tab == 'users'}<span class="selected"></span>{/if}
					</a>
				</li>
				{else}
				<li class="{if $nav_tab == 'myaccount'}active{/if}">
					<a href="{$admin_url}my-account/"><i class="fa fa-lock"></i>
						<span class="title">My Account</span>{if $nav_tab == 'myaccount'}<span class="selected"></span>{/if}
					</a>
				</li>
				{/if}
			</ul>
		</div>
	</div>
	<div class="main-content">
		<div class="container">
