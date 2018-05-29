var cntWidth;
var loc_cntWidth;
var contact_cntWidth;
var searching = false;
var searchTimer;
var rid=0;
var fk=0;
var tid;
var ef; // edit field?
var cl;
var po_cntWidth;

$(document).ready(function() {
	setALT();
	if($(".numbers").length){
		$(".numbers").keypress(function(ev){
			var keyCode = window.event ? ev.keyCode : ev.which;
			if (keyCode < 48 || keyCode > 57) {
				if (keyCode != 0 && keyCode != 8 && keyCode != 13 && !ev.ctrlKey && keyCode != 45 && keyCode != 40 && keyCode != 41 && keyCode != 47) {
					ev.preventDefault();
				}
			}
		});
	}
	cntWidth = $("#tile-viewport").parent().width();
	$("#tile-viewport, li.tile").width(cntWidth);
	$("#tiles").width( cntWidth * 2).fadeIn(600);


	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		if($(this).attr('href') == "#contacts-tab") {
			contact_cntWidth = $("#contact-mgmt").width();
		}
		$("#contact-tile-viewport li.tile").width(contact_cntWidth);
		$("#contact-tiles").width(contact_cntWidth * 2);
	});

	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		if($(this).attr('href') == "#purchase_orders-tab") {
			po_cntWidth = $("#po-mgmt").width();
		}
		$("#purchase_orders-viewport li.tile").width(po_cntWidth);
		$("#purchase_orders-tiles").width(po_cntWidth * 2);
	});

	$(window).resize(function(){
		cntWidth = $("#tile-viewport").parent().width();
		$("#tiles").width( cntWidth * 2);
		$("#tile-viewport, li.tile").width(cntWidth);

		cont_cntWidth = $("#contact-tile-viewport").parent().width();

		$("#contact-tile-viewport li.tile").width(cont_cntWidth);
		$("#contact-tiles").width(cont_cntWidth * 2);

		if($("#tiles").css("margin-left") != '0px')
			$("#tiles").css("margin-left", "-" + cntWidth + "px");

		po_cntWidth = $("#purchase_orders-viewport").parent().width();

		$("#purchase_orders-viewport li.tile").width(po_cntWidth);
		$("#purchase_orders-tiles").width(po_cntWidth * 2);


	});

	// remove modal
	$("#rmv-mdl").on("hidden.bs.modal", function(){ $("#rmv-msg").empty(); rid = ""; });
	$(".rmv-conf").bind("click", function(e){
		mdl = $(this).data('modal');
		debugTimestamp("remove()");
		if(rid !== ''){
			$("#"+mdl).modal("hide");
			$.blockUI({message: "<h4>Deleting Record... <i class='fa fa-spinner fa-spin fa-lg'></i></h4>"});
			xajax_remove(rid, currentPage(), fk, $("#filter").val(), $("#system-search").val());
		}
		else
			showModalMsg("practice-rmv-mdl", "alert-danger", "No ID is associated with this record. Please contact technical support.");

		e.preventDefault();
	});

	$("#system-search").keyup(function(){ xajax_paginate(1, $("#filter  option:selected").val(), $(this).val()); });

	$("#btn-save-note").bind('click', function(e){
		if($("#content-id").val().length) {
			$("#note_ref_fk-id").val($("#pract_obj-id").val());
			$.blockUI({message: "<h4>Saving note... <i class='fa fa-spinner fa-spin'></i></h4>"});
			xajax_saveNote(xajax.getFormValues('add-note-form'));
		}
		else
			showFormMsg("alert-danger", "No note content. Note was not saved.");
		e.preventDefault();
	});

	$("#btn-save-task").bind('click', function(e) {
		if($("#task_input-id").val().length){
			$("#task_ref_fk-id").val($("#pract_obj-id").val());
			xajax_saveTask(xajax.getFormValues("add-task-form"));
			$.blockUI({message: "<h4>Saving task... <i class='fa fa-spinner fa-spin'></i></h4>"});
		}
		else
			showFormMsg("alert-danger", "No task content. Task was not saved.");
		e.preventDefault();
	});

	$("#add-note-modal").on("hidden.bs.modal", function(){
		$("#add-note-form").clearForm();
	});

	$("#add-new-task-mdl").on("hidden.bs.modal", function(){
		$("#add-new-task-form").clearForm();
	});

	if($("#filter").length){
		console.log("yes");
		$("#filter").bind("change", function(){
			 xajax_paginate(1, $("#filter").val(), $('#system-search').val());
		});
	}
});

function paginate(p){ xajax_paginate(p, $("#filter").val(), $("#system-search").val()); }

function filter(){
	if($('#system-search').val().trim().length && ! searching){
		clearTimeout(searchTimer);
	    searchTimer = setTimeout(function(){ xajax_paginate(1, $("#filter").val(), $('#system-search').val());searching=true;}, 500);
	}
}

function saveDetails(){
	$('#btn-details-save').bind('click', function(e){
		var valid = true;
		//validate form
		if($("#asset-form").validate()){
			xajax_save(xajax.getFormValues("asset-form"));
		}
		else{
			showFormMsg("alert-danger", "Missing required fields. Could not be saved.");
		}
		e.preventDefault();
	});
	$("#btn-cancel").bind("click", function(e){
		slide(0);
		e.preventDefault();
	});
}

function fillNotesTasks(element, data){
	$(element).each(function() {
		$(this).html(data);
	});
}

function loadContact(resp){
	if(resp){
		var r = JSON.parse(resp);
		Object.keys(r).forEach(function(e){
			if(r[e]){
				$("#" + e + "-id").val(r[e]);
				$("#" + e + "-counter").text($("#" + e + "-id").val().length);
			}
		});
	}
	else{
		showFormMsg("alert-danger", "Error loading contact edit form.");
	}
	slide(3);
}

function slide(tile,){
	var slideDirection;
	var animateFunc;

	switch(tile){
		case 0:
			$("#edit-title, #add-asset-title").fadeOut(300);
			$("#list-title, #add-record, #search-controls").fadeIn(300);
			slideDirection = { marginLeft: '0px'};
			animateFunc = function(){
				$("#practice-form, #location-form, #contact-form").clearForm();
				$("input.obj-id, #location_note_fk, #contact_note_fk").val(0);
				$("span.counter-disp").text("0");
				$("div.mgmt-forms, #lnote-tab, #cnote-tab, #practice-notes-container, #add-asset").hide();
			}
			$("#tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					$("html, body").scrollTop(0);
					animateFunc();
				}
			);
			break;
		case 1:
			$(".counter").keyup(function() {$("#" + $(this).attr("name") + "-counter").text($(this).val().length); });
			$(".counter").each(function() {$("#" + $(this).attr("name") + "-counter").text($(this).val().length); });
			$("#list-title, #add-record, #search-controls, #add-asset-title").fadeOut(300);
			$("#edit-title").fadeIn(300);
			$("#asset-info").show();
			$("#quickView, #add-asset").hide();

			if($("#btn-convert").length){
				$("#btn-convert").bind("click", function(e){
					if($("#asset-form").validate()){
						$.blockUI({message: "<h4>Converting Lead to Practice <i class='fa fa-spinner fa-spin fa-lg'></i></h4>"});
						xajax_migrateLeadToPractice(xajax.getFormValues("asset-form"));
						e.preventDefault();
					}
				});
			}
			
			slideDirection = { marginLeft: '-' + cntWidth};
			animateFunc = function() { }
			$("div.mgmt-forms").show();

			$("#tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					$("html, body").scrollTop(0);
					animateFunc();
				}
			);
			break;
		case 2:
			$("#list-title, #add-record, #search-controls").fadeOut(300);
			$("#asset-info").hide();
			$("#quickView").show();
			$("#edit-title").fadeIn(300);
			slideDirection = { marginLeft: '-' + cntWidth};
			animateFunc = function() {  }
			$("#tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					$("html, body").scrollTop(0);
					animateFunc();
				}
			);
			break;
		case 3:
			$("#ref_fk-id").val($("#pract_obj-id").val());
			$(".counter").keyup(function(){
				$(".counter").keyup(function() {$("#" + $(this).attr("name") + "-counter").text($(this).val().length); });
			});
			$("#btn-contact-save").bind("click", function(){
				if($("#contact-form").validate()){
					xajax_saveContact(xajax.getFormValues("contact-form"));
				}
				else{
					showFormMsg("alert-danger", "Contact could not be saved. Missing required information.");
				}
			});
			$('#ref_table-id').val($("#asset-list").attr("data-type"));
			slideDirection = { marginLeft: '-' + contact_cntWidth};
			$("#btn_return_contacts-id").bind("click", function(e){
				slide(5);
				e.preventDefault();
			});
			animateFunc = function() { $("#contact-edit").show(); $("#contact-form #location_fk-id").focus(); $("html, body").animate({scrollTop: 0}, "slow"); }
			$("#contact-tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					animateFunc();
				}
			);
			break;
		case 4:
			$("#edit-title, #add-record, #search-controls, #list-title").fadeOut(300);
			$("#add-asset-title").fadeIn(300);
			slideDirection = { marginLeft: '-' + cntWidth};
			animateFunc = function(){
				$("#add-asset").show();
				$("#asset-info").hide();
				$("#quickView").hide();
			}
			$("#tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					$("html, body").scrollTop(0);
					animateFunc();
				}
			);
			break;
		case 5:
			$("#contact-form").clearForm();
			slideDirection = { marginLeft: '0px'};
			animateFunc = function() { $("#contact-list").show(); $("html, body").animate({scrollTop: 0}, "slow"); }
			$("#contact-tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					//animateFunc();
				}
			);
			break;
		case 6:
			slideDirection = { marginLeft: '-' + po_cntWidth};
			animateFunc = function() { $("#purchase_order-details").show(); $("#purchase_orders").hide(); $("html, body").animate({scrollTop: 0}, "slow"); }
			$("#purchase_orders-tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					animateFunc();
				}
			);
			break;
		case 7:
			slideDirection = { marginLeft: '0px'};
			animateFunc = function() { $("#purchase_order-details").hide(); $("#purchase_orders").show(); $("html, body").animate({scrollTop: 0}, "slow"); }
			$("#purchase_orders-tiles").stop().animate(
				slideDirection,
				500,
				function(){
					//Animate Done
					animateFunc();
				}
			);
			break;
		default:
			break;
	}
}

function downloadFile(fileName){
    var iframe;
    iframe = document.getElementById("hiddenDownloader");
    if (iframe === null)
    {
        iframe = document.createElement('iframe');  
        iframe.id = "hiddenDownloader";
        iframe.style.visibility = 'hidden';
        document.body.appendChild(iframe);
    }

    iframe.src = "../../download.php?fn=" + fileName;  
}
