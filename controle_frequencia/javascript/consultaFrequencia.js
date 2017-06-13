/**
 * 
 */
$(window).load(function(){
	$.ajax({
		type: 'POST',
		url: 'consultaFrequencia.php',
		success:function(html){
			$('table').appendd(html);
			$('table').css('opacity', 1); 
		},
		error:function(){
			alert("ERROR");
		}
	});
});
$(function(){
	$('.form').bind('submit', function(e){
		e.preventDefault();
		var perido = $(this).serialize();
		if(periodo != ""){
			$('tbody').remove();
			$.ajax({
				type: 'POST',
				url: 'consultaFrequencia.php',
				data: periodo,
				success:function(html){
					$('table').append(html);
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