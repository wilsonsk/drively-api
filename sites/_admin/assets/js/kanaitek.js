/* Return the Order for which a list of records is displayed */
function getListDisplayOrder(){
    var order = $('.asc').attr('id');
    if(typeof(order) == "undefined"){
        order = $('.desc').attr('id') + " DESC";
    }
    else{
        order += " ASC";
    }
    return order;
}

/* Reset Search Timer to avoid overloading search calls */
function filter(){
    if(! searching){
        clearTimeout(search_timer);
        search_timer = setTimeout('commitFilter()', 400);
    }
}

/* Evaluate if a search is already occuring */
function search(){
    if(! searching){
        clearTimeout(search_timer);
        search_timer = setTimeout('commitSearch()', 400);
    }
}

/* Execute a search */
function commitSearch(){
    searching = true;
    //openIndicator("Searching...", "indicator_default", false);
    searching = false;
    xajax_hotkeySearch($('#searchText').val());
}

/* RegEx Patterns for Form Validation */
var form_fmt = {
    'email': /\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi,
    'phone': /^(\(\d{3}\)|\d{3})(\.{0,1}|-{0,1}|\s{0,1})(\d{3})(\.{0,1}|-{0,1}|\s{0,1})(\d{4})$/,
    'ssn': /^\d{3}(\.|-)?\d{2}(\.|-)?\d{4}$/,
    'date': /\b(^\d{1,2}\/\d{1,2}\/\d{4}$)\b/gi,
    'zip':  /^\d{5}(-\d{4})?$/
};

/* Get appropriate RegEx pattern for evaulated field */
function getFormElementFormat(key) {
    return (form_fmt)[key];
}

/* Validate a form */
$.fn.validate = function(){
    clearWhiteSpace();
    if(typeof(showIndicator) == "undefined"){
        showIndicator = true;
        var errMsg = "Missing Required Information.<br/>Please see highlighted areas.";
    }
    src_form = "#" + $(this).attr("id");
    prepEditors(src_form);
    $(src_form + " div.control-group").removeClass('has-error');
    var iVal = new String();
    var element, fmt, elem_valid;
    valid = true;
    first = '';
    $(src_form + ' label.required').each(function () {
        element = src_form+" #"+$(this).attr('for')+"-id";
        iVal = $(element).val().trim();

        elem_valid = true;
        fmt = ($(this).attr("data-fmt")) ? getFormElementFormat($(this).attr("data-fmt")) : null;
        if(fmt){
            elem_valid = (! iVal.match(fmt)) ? false : elem_valid;
        }
        else{
            if($(this).attr("data-fmt") == "password" &&  ( iVal.length < 8 || iVal != $(src_form + " #pw-conf-id").val() )){
				if(iVal != $(src_form + " #pw-conf-id").val())
					showFormMsg("alert-success", "alert-error", "The passwords do not match.");
				else
					showFormMsg("alert-success", "alert-error", "The password does not meet 8 character minimum requirement.");

                elem_valid = false;
                $(this).parent().addClass('has-error');
				$("#cg-pw-conf").addClass('has-error');
            }
            else
            {
                elem_valid = (iVal.length == 0 || iVal == 0) ? false : elem_valid;
            }
        }
        if(! elem_valid){
            valid = false;
            $(this).parent().addClass('has-error');
            first = (first == '') ? element : first;
        }
    });
    $(src_form + ' label[data-fmt]').not(".required, .alert").each(function(){
        element = src_form+" #"+$(this).attr('for')+"-id";
		//console.log(element);
        iVal = $(element).val().trim();
        if(iVal.length && ! iVal.match(getFormElementFormat($(this).attr("data-fmt")))){
            valid = false;
            if ( $(element)[0].nodeName.toLowerCase() == 'input' || $(element)[0].nodeName.toLowerCase() == 'textarea' ){
                $(element + ":not(:hidden)").addClass('alert');
            }
            first = (first == '') ? element : '';
        }
    });
    if(! valid)
        $(first).focus();

    return valid;
}

function currentPage()
{
	var pg = 1;
	if($("ul.pagination").length){ pg = $("ul.pagination li.active a").text(); }
	return pg;
}

function showFormMsg(cls, msg){
	$("#form-msg").addClass(cls).html(msg);
	setTimeout(function(){
		$("#form-msg").fadeIn(600, function(){ setTimeout(function(){ $("#form-msg").fadeOut(600, function(){ $("#form-msg").removeClass(cls).html(''); }); }, 3500); });
	},
	500);
}

/* Retrieve the content from a Ckeditor for form validation and submission */
function prepEditors(src_form){
    $(src_form + " input[type='text'], " + src_form + " textarea").each(function(){ $(this).val( ($(this).val().match(/^\s*$/)?'':$(this).val()) ); });
    $(src_form + ' input[data-editor]').each(
        function () {
            //consoleOutput(src_form+" #"+$(this).attr('data-editor'));
            var iVal = new String($(src_form+" #"+$(this).attr('data-editor')).val());
            iVal = iVal.trim();
            if(iVal == '<br />'){
                iVal = '';
            }
            $(this).val(iVal);
        }
    );
}

/* Clear a form */
$.fn.clearForm = function() {
    $("div.control-group.error").removeClass("error");
    return this.each(function () {
        $(':input', this).each(function() {
            var type = this.type, tag = this.tagName.toLowerCase();
            if(type == 'text' || type == 'textarea' || type == 'password'){
                this.value = '';
                //$(this).css('background-color', '#fff');
            }
            else if(type == 'checkbox' || type == 'radio')
                this.checked = false;
            else if ( tag == 'select')
                this.selectedIndex = 0;
            else if($(this).attr("data-editor")) { $("#" + $(this).attr("data-editor")).val(''); }
        });
    });
    return false;
};

function download(url)
{
    var iframe;
    iframe = document.getElementById("hiddenDownloader");
    if (iframe === null)
    {
        iframe = document.createElement('iframe');
        iframe.id = "hiddenDownloader";
        iframe.style.visibility = 'hidden';
        document.body.appendChild(iframe);
    }
    iframe.src = url;
}

function setALT(){
	var _to=$("#timer").attr("data-to"), hrs, mins, secs;
	if(tid) clearInterval(tid);
	tid = setInterval(function(){
		hrs = parseInt(_to / 3600);
		mins = parseInt((_to % 3600) / 60);
		secs = parseInt(_to % 60);
		mins = (mins < 10) ? "0" + mins : mins;
		secs = (secs < 10) ? "0" + secs : secs;
		$("#timer").text(hrs + ":" + mins + ":" + secs);
		_to--;
		if(_to < 0) window.location = window.location.origin+"/sinsational-portal/sites/_admin/logout.php";
	}, 1000);
}

/* Remove white space from string */
String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}

/* Truncate a string to specified number of characters and replace trailing/truncated characters */
String.prototype.truncate = function (keep, ext) {
    if(keep < this.length){
        var str = this.substr(0, keep) + "...";
        if(typeof(ext) != 'undefined'){
            str += this.substr((this.length - 3));
        }
        return str;
    }
    return this;
}

/* Capitalize a string */
String.prototype.capitalize = function(){
    return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
};

/* Capitalize the first character of each word within a string */
String.prototype.ucwords = function(){
    return this.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

/* Calculate file sizes */
function fileSize(bytes){
    var sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[[i]];
}

/* Clear white space filled form elements */
function clearWhiteSpace(){
    var txt, i;
    txt = document.getElementsByTagName('input');
    for(i=0; i<txt.length; i++){
        if(txt[i].type == 'text' && txt[i].value.match(/^\s*$/)){
            txt[i].value = '';
        }
    }
}

/* Debugging: Alternate to direct console.log call to avoid leftover debugs */
function consoleOutput(str){
    if(window.console){
        console.log(str);
    }
}

/* Debugging: Output object values */
function outputObject(obj){
    var out = '';
    for(var val in obj){
        out += val + ": " + obj[val] + "\n";
    }
    return out;
}