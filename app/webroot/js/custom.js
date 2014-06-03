jQuery(document).ready(function(){
jQuery("#close").click(function(){
jQuery(".welcome").fadeOut();
});
jQuery("#eclose").click(function(){
	jQuery(".flash-error").fadeOut();
});
});
function startloading() {
	$('#ajaxloading').show();
	if($(".subbtn")){
	$('.subbtn').attr('disabled','disabled');
	}
}
function endloading() {
	$("#ajaxloading").fadeOut(1000);
	if($(".subbtn")){
	$('.subbtn').attr('disabled',false);
	}
}
//javascript return message
function showJavaScriptMessage(response){
	 JSONstring  = JSON.stringify(response);
     var obj = jQuery.parseJSON(JSONstring);
	var message = "";
	var divId='';
	if(obj.success){
		message = obj.success;
		divId='successMessage';
	}else if(obj.error){
	message = obj.error;
	divId='errorMessage';
	}
	$('#'+divId).show();
	setTimeout(function() {
		$("#"+divId).fadeOut(1000);
    }, 4000);
	$("#"+divId).text(message);
}
function redirecturl() {
	var url = $('#redirectUrl').val();
	if(url != undefined) { 
		window.location = url;
	}
}

//validate form 
function validateForm(formId,loading,confrm) {
	loading = typeof loading !== 'undefined' ? loading : 'true';
	confrm = typeof confrm !== 'undefined' ? confrm : 'false';

	if( $("#"+formId).validationEngine('validate')){
		if(confrm !== 'false') {
			var r = confirm(confrm);
			if(r==true) {
				if(loading == 'true'){
					startloading();	
				}
				return true;
			}else {return false;}
		}else {
			if(loading == 'true'){
				startloading();	
			}
			return true;
		}
	}else{
		setTimeout(function() {
			$("#"+formId).validationEngine('hideAll');
	    }, 2000);
		return false;
	}
}

function showAjaxReturnMessageLogin(data,json,errordivid) {
	if(data.response){
		var objl = jQuery.parseJSON(data.response);
	}else {
		var objl = jQuery.parseJSON(data);
	}
	var message = "";
	var divId='';
	if(objl.success){
		window.location.href = objl.redirect;
		message = objl.success;
		divId='successMessage';
	}else if(objl.error){
	message = objl.error;
	divId=errordivid;
	}
	$('#'+divId).show();
	setTimeout(function() {
		$("#"+divId).fadeOut(1000);
    }, 4000);
	$("#"+divId).text(message);
}

//ajax return message
function showAjaxReturnMessage(data,json) {
	if(data.response){
	var obj = jQuery.parseJSON(data.response);
	}else{
	var obj = jQuery.parseJSON(data);
	}
	var message = "";
	var divId='';
	if(obj.success){
		message = obj.success;
		divId='successMessage';
	}else if(obj.error){
	message = obj.error;
	divId='errorMessage';
	}
	$('#'+divId).show();
	setTimeout(function() {
		$("#"+divId).fadeOut(1000);
    }, 4000);
	$("#"+divId).text(message);
}