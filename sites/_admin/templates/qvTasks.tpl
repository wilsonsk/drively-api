<div class="col-sm-12">
	<h1><span id="qv-add-task-title">Tasks </span><span class="add-note" onclick="$('#add-task-modal').modal('show');"><i class="fa fa-plus-circle"></i></span></h1>
	{if $tasks|default:''}
		{foreach $tasks as $t}
			<div class="col-sm-10 col-sm-offset-1 note-block {if $t.status == 'c'}closed-task{/if}" id="task-list-item-{$t.id}">
				<div class="row">
					<div class="col-sm-10">
						<strong>Updated on {$t.last_update}</strong> by <em>{$t.last_update_by}</em>
					</div>
					{if $t.status != "c"}
						<div class="col-sm-2"><a onclick="xajax_closeTask({$t.id});" class="close-task pull-right" id="task-{$t.id}-close-btn"><i class="fa fa-check"></i></a></div>
					{/if}
				</div>
				<div class="row col-sm-12">
					<p>{$t.content}</p>
				</div>
			</div>
		{/foreach}
	{else}
		<div class="alert alert-info"><h4 class="center">There are no tasks in the system.</h4></div>
	{/if}
</div>