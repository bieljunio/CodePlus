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
		var inicio = $('#inicio').val();
		var final = $('#final').val();
		$('tbody').remove();
		$.ajax({
			type: 'POST',
			url: '../php/consultaFrequenciaFiltro.php',
			data: {inicio,final,id},
			success:function(retorno){
				$('table').append(retorno);
				$('table').css('opacity', 1);
			},
			error:function(){
				alert("Período inválido!");
			}
		});
	});
});