// form validation

function validateField(field_name) {
	var v = document.forms[0][field_name].value;
	if (v.length > 0) {
		hideFieldValidation(field_name);
		return true;
	} else {
		 showFieldValidation(field_name);
		 return false;
	}
}

function showFieldValidation(field_name) {
	$('#' + field_name + '_validation').show();
}

function hideFieldValidation(field_name) {
	$('#' + field_name + '_validation').hide();
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function setLang(lang) {
	setCookie('language', lang, 365);
	document.location = document.location;
}