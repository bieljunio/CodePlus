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

function search(){
	var cp = new cpaint();
	cp.set_transfer_mode("POST");
	cp.set_response_type("TEXT");
	
	var name = document.getElementsByName("nameFilter")[0].value;
	if(name != ""){
		cp.call("buscaColaborador.php", name, tableConsult);
	} else {
		alert("Por favor, insira um nome válido");
	}
}

function tableConsult(msg){
	for(i = 0; i < 1; i++){
		alert(msg[i]);
	}
}