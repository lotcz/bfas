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