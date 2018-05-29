$(document).ready(function() {
	$(".coming-soon-modal").bind('click', function(e){
		$("#comingSoonModal").modal('show');
		e.preventDefault();
	});
});