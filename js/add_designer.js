function validate_age()
{
	var element = document.getElementById("age");
 	element.value = element.value.replace(/[^\d]/g, '');
}

function validate_phone()
{
	var element = document.getElementById("phone");
 	element.value = element.value.replace(/[^\d]/g, '');
}

