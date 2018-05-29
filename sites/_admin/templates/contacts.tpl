<div id="add-contact" class="add-record" style="top:0px; right:0px;" data-tile="contacts-edit" onclick="slide(3);"><i class="fa fa-plus-circle"></i> Add Contact</div><br><br><br>
{if $contacts|default: ''}
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="center" style="width:105px;"><i class="fa fa-bolt"></i> Actions</th>
			<th><i class="fa fa-user"></i> Name</th>
			<th><i class="fa fa-id-card-o"></i> Title</th>
			<th><i class="fa fa-phone-o"></i> Phone</th>
			<th><i class="fa fa-envelope-o"></i> Email</th>
			<th><i class="fa fa-calendar"></i> Last Update</th>
		</tr>
	</thead>
	<tbody>
		{foreach $contacts as $item}
			<tr class="ri">
				<td class="center">
					<div class="btn-group">
						<a onclick="xajax_loadContact({$item.id}, '{$item.ref_table}');" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
						{if $smarty.session[{$smarty.const.ADMIN_SITE}].permissions & $smarty.const.ADMIN}
							<a onclick="removeAccount('{$item.ref_table}', {$item.id}, {$item.ref_fk});" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
						{/if}
		      </div>
				</td>
				<td id="contact-{$item.id}">{$item.contact_name}</td>
				<td>{$item.title|default: "No Title"}</td>
				<td>{$item.phone|default: "No Phone"}</td>
				<td>{$item.email|default: "No Email"}</td>
				<td>{$item.last_update}</td>
			</tr>
		{/foreach}
	</tbody>
</table>
{else}
	<div class="alert alert-info"><h4 class="center">There are no {$matching|default: ''}contacts in the system.</h4></div>
{/if}
{if $cont_max_pages|default: 1 > 1}
    <div class="col-sm-12 text-center">
        <ul class="pagination">
            <li{if $cont_cur_page==1} class="disabled"><a onclick="return false;"{else}><a onclick="paginate({$cont_cur_page-1});"{/if}>Previous</a></li>
            {if $cont_max_pages <= 10}
                {for $p=1 to $cont_max_pages}
                    <li{if $p==$cont_cur_page} class="active"{/if} rel="{$p}"><a onclick="paginate({$p});">{$p}</a></li>
                {/for}
            {else}
				{assign var=page_group value=(($cont_cur_page - 1) / 10)|intval}
				{assign var=max_group value=($cont_max_pages / 10)|intval}
				{if $page_group}
					<li><a onclick="paginate({($page_group * 10)});">&hellip;</a></li>
				{/if}

				{if $page_group == $max_group}
	                {for $p=($page_group * 10)+1 to $cont_max_pages}
	                    <li{if $p==$cont_cur_page} class="active"{/if} rel="{$p}"><a onclick="paginate({$p});">{$p}</a></li>
	                {/for}
				{else}
	                {for $p=($page_group * 10)+1 to ($page_group*10)+10}
	                    <li{if $p==$cont_cur_page} class="active"{/if} rel="{$p}"><a onclick="paginate({$p});">{$p}</a></li>
	                {/for}
				{/if}

				{if $p < $cont_max_pages}
					<li><a onclick="paginate({$p});">&hellip;</a></li>
				{/if}
            {/if}
            <li{if $cur_page==$cont_max_pages} class="disabled"><a onclick="return false;"{else}><a onclick="paginate({$cont_cur_page+1});"{/if}>Next</a></li>
        </ul>
    </div>
{/if}
