{assign var=path value=$smarty.const.ADMIN_PATH}
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>Sinsational Smile Portal</li>
			<li><span id="breadcrumb-title">{$asset_title}</span></li>
			<li id="search-controls" class="search-box">
			{if $asset|default:''}
				{if $asset == "leads"}
					<select id="filter" class="form-control" onchange="filter()">
							{*{if $asset == "practices"}
								<option>Any</option>
								<option value="c">Company</option>
								<option value="p">Contact</option>
								<option value="l">City</option>
							{if $asset=="leads"}*}
								<option value="">Any</option>
								<option value="new lead">New Lead</option>
								<option value="contacted">Contacted</option>
								<option value="demo">Demo Sent</option>
								<option value="do not contact">Do Not Contact</option>
								<option value="contact later">Contact At A Later Date</option>
							
					</select>
				{/if}
			{/if}
				<span id="search-container" class="input-icon input-icon-right">
					<input type="text" id="system-search" placeholder="Search..." title="Search by Company{if $asset!='distributors' and $asset != 'distributor-reps'}, or Contact First or Last Name{/if}{if $asset == 'distributor-reps'}, city, or state{/if}" data-default="45"/>
					<i class="fa fa-search"></i>
				</span>
			<li>
		</ol>
		<div id="title-header" class="page-header">
			<h1><span id="list-title">Manage {$asset_title}</span><span id="edit-title"> {$asset_type} Details</span><span id="add-asset-title"> Add {$asset_type}</span></h1>
			<div id="add-record" onclick="xajax_addAsset('{$asset_single}');"><i class="fa fa-plus-circle"></i> Add {$asset_type}</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div id="form-msg" class="alert"></div>
		<div id="tile-viewport">
			<ul id="tiles" style="display:none;">
				<li id="asset-list" class="tile" data-type="{$asset_single}"">{include file="{$asset}.tpl"}</li>
				<li id="asset-info" class="tile">
					<ul id="asset-tabs" class="nav nav-tabs">
						<li id="tab-1" class="active"><a href="#{$asset}-tab" data-toggle="tab">{$asset_type}</a></li>
						{if $asset != 'distributor-reps'}<li id="tab-3"><a href="#contacts-tab" data-toggle="tab">Contacts</a></li>{/if}
						<li id="tab-4"><a href="#tasks-tab" data-toggle="tab">Tasks</a></li>
						<li id="tab-4"><a href="#notes-tab" data-toggle="tab">Notes</a></li>
						{if $asset == 'practices' or $asset=='distributors'}<li id="tab-4"><a href="#purchase_orders-tab" data-toggle="tab">Purchase Orders</a></li>{/if}
					</ul>
					<div class="tab-content">
						<div id="{$asset}-tab" class="tab-pane fade active in"></div>
						<div id="contacts-tab" class="tab-pane fade">
							<div id="contact-mgmt">
								<div id="contact-tile-viewport">
									<ul id="contact-tiles">
										<li id="contact-list" class="tile"></li>
										<li id="contact-edit" class="tile">{include file="$path/templates/contact-details.tpl"}</li>
									</ul>
								</div>
							</div>
						</div>
						<div id="tasks-tab" class="tab-pane fade">
							<div id="activity-mgmt">
								<div id="note-tile-viewport">
									<div class="asset-task-list"></div>
								</div>
							</div>
						</div>
						<div id="notes-tab" class="tab-pane fade">
							<div id="activity-mgmt">
								<div id="note-tile-viewport">
									<div class="asset-note-list"></div>
								</div>
							</div>
						</div>
						<div id="purchase_orders-tab" class="tab-pane fade">
							<div id="purchase_orders-mgmt">
								<div id="purchase_orders-tile-viewport">
									<ul id="purchase_orders-tiles">
										<li id="purchase_orders" class="tile"></li>
										<li id="purchase_order-details" class="tile"></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li id="quickView" class="tile"></li>
				<li id="add-asset" class="tile"></li>
			</ul>
		</div>
	</div>
</div>
{include file="$path/templates/modals.tpl"}
{include file="$path/templates/_modals.tpl"}