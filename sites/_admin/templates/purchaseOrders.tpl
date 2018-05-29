<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="center" style="width:85px;"><i class="fa fa-bolt"></i> Action</th>
			<th><i class="fa fa-building"></i> Distributor/Practice Name</th>
			<th style="width:200px;"><i class="fa fa-calendar"></i> Date of P/O</th>
			<th style="width:200px;"><i class="fa fa-check-square-o"></i> Status</th>
			<th style="width:200px;"><i class="fa fa-calendar"></i> Last Update</th>
		</tr>
	</thead>
	<tbody>
	{if $set}
		{foreach $set as $item}
		<tr class="ri">
			<td class="center">
				<div class="btn-group">
            <a onclick="xajax_qvPO({$item.id});" data-toggle="tooltip" title="Quick View" class="btn btn-xs btn-info"><i class="fa fa-search"></i></a>
            <a onclick="xajax_download({$item.id});" data-toggle="tooltip" title="Download PDF" class="btn btn-xs btn-warning"><i class="fa fa-download"></i></a>
        </div>
			</td>
			<td id="po-{$item.id}">{$item.name}</td>
			<td>{$item.date_of_po}</td>
			<td class="{if $item.status == 'o'}open{else}{if $item.status == 'i'}invoiced{else}processing{/if}{/if}">{if $item.status == 'o'}Open{else}{if $item.status == 'i'}Invoiced{else}Processing{/if}{/if}</td>
			<td>{$item.lastUpdate}</td>
		</tr>
		{/foreach}
		{else}
		<tr><td colspan="6"><div class="alert alert-danger" style="text-align:center;">There are no invoiced Purchase Orders in the system.</div></td></tr>
	{/if}
	</tbody>
</table>
{if $max_pages > 1}
<div class="row">
	<div class="col-sm-12">
    <div style="text-align:center;">
        <ul class="pagination pagination">
            <li{if $cur_page==1} class="disabled"><a onclick="return false;"{else}><a onclick="paginate({$cur_page-1});"{/if}>Previous</a></li>
            {if $max_pages <= 10}
                {for $p=1 to $max_pages}
                    <li{if $p==$cur_page} class="active"{/if} rel="{$p}"><a onclick="paginate({$p});">{$p}</a></li>
                {/for}
            {else}
                {if $cur_page > 5}
                    <li><a onclick="return false;">&hellip;</a></li>
                    {if ($cur_page + 5) > $max_pages}{assign var=top value=$max_pages}{else}{assign var=top value=($cur_page + 5)}{/if}
                    {for $p=($cur_page - 4) to $top}
                        <li{if $p==$cur_page} class="active"{/if} rel="{$p}"><a onclick="paginate({$p});">{$p}</a></li>
                    {/for}
                    {if $top < $max_pages}<li><a onclick="return false;">&hellip;</a></li>{/if}
                {else}
                    {for $p=1 to 10}
                        <li{if $p==$cur_page} class="active"{/if} rel="{$p}"><a onclick="paginate({$p});">{$p}</a></li>
                    {/for}
                    <li><a onclick="return false;">&hellip;</a></li>
                {/if}
            {/if}
            <li{if $cur_page==$max_pages} class="disabled"><a onclick="return false;"{else}><a onclick="paginate({$cur_page+1});"{/if}>Next</a></li>
        </ul>
    </div>
</div>
</div>
{/if}