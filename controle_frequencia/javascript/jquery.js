/**
 * 
 */
function registerEntry(){
	$.ajax({
		url: '../php/registerPoint.php?entry',
		complete: function(response) {
			alert(response.responseText);
		},
		error: function() {
			alert('Erro');
		}
	});
	return false;
}

function registerExit(){
	$.ajax({
		url: '../php/registerPoint.php?exit',
		complete: function(response) {
			alert(response.responseText);
		},
		error: function() {
			alert('Erro');
		}
	});
	return false;
}