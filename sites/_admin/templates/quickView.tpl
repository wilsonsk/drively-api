					<div class="row">
						<div class="col-sm-8">
							<h1 id="asset_name" style="margin: 0px;">{$type.name|default:''}</h1>
						</div>
						<div class="col-sm-4 text-right">
							<em>Last update by {$type.last_update_by|default:'NA'}</span></em>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p id="{$asset}_description">{$type.description|default:''}</p>
						</div>
					</div>
					<div id="{$asset}-location-id" class="row">
						<div class="col-sm-12">
							<div class="col-sm-4">
								<p>{$type.address|default:'No Address'} {$type.address_two|default:''}<br>{$type.city|default:''} {$type.state|default:''} {$type.zip|default:''} 
									<br><a href="tel://{$type.phone|default:''}"><i class="fa fa-phone"></i> {$type.phone|default:'No Phone'}</a>
								</p>
							</div>
						</div>
					</div>
					<div id="contacts-row" class="row">
						<div class="col-sm-12">
							<h1>Contacts</h1>
							{if $contacts|default:''}
								{foreach $contacts as $c}
									<div class="col-sm-4">
										<strong>{$c.title|default:''} {$c.contact_name|default:''}</strong><br>
										Email: {if $c.email|default:''}<a href="mailto:{$c.email}"><i class="fa fa-envelope"></i> {$c.email}</a>{else} None Listed {/if}<br>
										Phone: {if $c.phone|default:''}<a href="tel://{$c.phone}"><i class="fa fa-phone"></i> {$c.phone} {if $c.ext|default:''}Ext. {$c.ext}{/if}</a>{else} None Listed {/if}<br>
										{if $c.mobile|default:''}Mobile: <a href="tel://{$c.mobile}"><i class="fa fa-phone"></i> {$c.mobile}</a><br>{/if}
									</div>
								{/foreach}
							{else}
								No contacts.
							{/if}
						</div>
					</div>
					<div class="asset-task-list row"></div>
					<div class="asset-note-list row"></div>
					<div class="col-sm-12 text-right row">
						<button onclick="slide(0);" class="btn btn-info btn-form-success" ><i class="fa fa-reply"></i> Return to {$asset_title}</button>
					</div>