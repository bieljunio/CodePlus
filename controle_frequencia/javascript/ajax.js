/**
 * 
 */
$(function(){
	$('.form').bind('submit', function(e){
		e.preventDefault();
		var name = $(this).serialize();
		if(name != ""){
			$('tbody').remove();
			$.ajax({
				type: 'POST',
				url: 'buscaColaborador.php',
				data: name,
				success:function(html){
					$('table').append(html);
					$('table').css('opacity', 1);
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