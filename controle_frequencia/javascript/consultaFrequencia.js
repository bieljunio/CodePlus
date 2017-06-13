/**
 * 
 */
$(function(){
	var id = $(".user").attr("id");
	$.ajax({
		type: 'POST',
		url: '../php/consultaFrequencia.php',
		data: {'id':id},
		success:function(html){
			$('table').append(html);
			$('table').css('opacity', 1); 
		},
		error:function(){
			alert("ERROR");
		}
	});
	$('.form').bind('submit', function(e){
		e.preventDefault();
		var periodo = $(this).serialize();
		if(periodo != ""){
			$('tbody').remove();
			$.ajax({
				type: 'POST',
				url: '../php/consultaFrequencia.php',
				data: periodo,
				success:function(retorno){
					$('table').append(retorno);
					$('table').css('opacity', 1);
				},
				error:function(){
					alert("Período inválido!");
				}
			});
		} else {
			alert("Período inválido!");
		}
	});
});