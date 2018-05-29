<div class="col-sm-12">
	<h1><span id="qv-add-note-title">Notes </span><span class="add-note" onclick="$('#add-note-modal').modal('show');"><i class="fa fa-plus-circle"></i></span></h1>
	{if $notes|default:''}
		{foreach $notes as $n}
			<div class="col-sm-10 col-sm-offset-1 note-block">
				<strong><span style="text-transform:capitalize;">{$n.type}: </span><br>Updated on {$n.last_update}</strong> by <em>{$n.last_update_by}</em><br>
				<p>{$n.content}</p>
			</div>
		{/foreach}	
	{else}
		<div class="alert alert-info"><h4 class="center">There are no notes in the system.</h4></div>
	{/if}
</div>