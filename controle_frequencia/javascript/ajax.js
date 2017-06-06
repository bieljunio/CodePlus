/**
 * 
 */
$(document).ready(function(){
	$('.form').bind('submit', function(e){
		e.preventDefault();
		var name = $(this).serialize();
		if(name != ''){
			$.ajax({
				type: 'POST',
				url: 'buscaColaborador.php',
				data: name,
				sucess:function(html){
					$('.consultResult').html(html);
				},
				error:function(){
					alert("Nome inválido!");
				}
			});
		} else {
			alert("Nome inválido!");
		}
	});
});