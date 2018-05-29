$(document).ready(function() {
    $('#login-button').bind("click", function(e) {
		login();
        e.preventDefault();
    });
	
    $('#login-form input, #login-form password').keypress(function(e) {
        if(e.which == 13){
            $('#login-button').focus().click();
            e.preventDefault();
        }
    });
	
	$("#forgot-modal").on("hidden.bs.modal", function(){$("#reset-email").val('');});
	
	$("#reset-passwd-btn").bind("click", function(e){
		var email = $("#reset-email").val();
		if(validEmail(email)){
			xajax_forgotPassword(email);
			$("#forgot-modal").modal("hide");
			$.blockUI({message: "<h3>Sending Reset Link... <i class='fa fa-spinner fa-spin fa-lg'></i>"});
		}
		else{ 
			$("#forgot-alert").removeClass("alert-success alert-error").addClass("alert-error").html('Invalid Email Address');
			$("#email-id").focus();
			showAlert(false);
		}
	});

	$("#uname").focus();
});

function showAlert(cd){
	$("#forgot-alert").fadeIn(500, function(){
		setTimeout(function(){
			$('#forgot-alert').fadeOut(500, function(){
				if(cd){ $("#forgot-modal").modal('hide'); $("#uname").val('');}
			});
		}, 2500);
	});
}

function showLoginMessage(msg)
{
	$("#passwd").val('');
	$("#form-error").text(msg);
	$("#form-error").fadeIn(500, function(){ setTimeout(function(){ $('#form-error').fadeOut(600); }, 2500); });
	//$("#login").hide("fade");
}

function login(){
    var b = true;
    var a = $("#passwd").val();
    a = a.trim();
    if (a.length < 6 || a.length > 15) {
        b = false;
    }
    if (!validEmail($("#uname").val())) {
        b = false;
    }
    if (b) {
		$("#login").show('fade');
        xajax_login(xajax.getFormValues("login-form"));
    } else {
		showLoginMessage('Inavlid Username or password.');
    }
}

function invalidPass(){
    $("#pass-alert").addClass("alert alert-error").css("display", "block");
    $("#email-id").removeClass("alert-error").addClass("alert-error");
}

function validEmail(a) {
    var b = true;
    if ((a.length < 8) || ((a.length > 0) && (!a.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi)))) {
        b = false;
    }
    return b
}

function refreshPage(){
	setTimeout(function(){window.location = "./";}, 3500);
}